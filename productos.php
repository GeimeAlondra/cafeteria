<?php
require_once 'config/database.php';
//$conn = getConnection();

// Procesar nuevo pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['realizar_pedido'])) {
    $id_producto = intval($_POST['id_producto']);
    $cantidad = intval($_POST['cantidad']);
    
    if ($id_producto > 0 && $cantidad > 0) {
        $sql_insert = "INSERT INTO pedidos (id_producto, cantidad) VALUES (?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("ii", $id_producto, $cantidad);
        
        if ($stmt->execute()) {
            $mensaje_exito = "¡Pedido realizado exitosamente!";
        } else {
            $mensaje_error = "Error al realizar el pedido.";
        }
        $stmt->close();
    }
}

// Filtros
$categoria_filtro = isset($_GET['categoria']) ? intval($_GET['categoria']) : 0;
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

// Consulta con filtros
$sql = "SELECT p.*, c.nombre as categoria_nombre 
        FROM productos p 
        LEFT JOIN categorias c ON p.id_categoria = c.id_categoria 
        WHERE 1=1";

$params = [];
$types = "";

if ($categoria_filtro > 0) {
    $sql .= " AND p.id_categoria = ?";
    $params[] = $categoria_filtro;
    $types .= "i";
}

if (!empty($busqueda)) {
    $sql .= " AND (p.nombre LIKE ? OR p.descripcion LIKE ?)";
    $busqueda_param = "%{$busqueda}%";
    $params[] = $busqueda_param;
    $params[] = $busqueda_param;
    $types .= "ss";
}

$sql .= " ORDER BY p.nombre ASC";

if (!empty($params)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result_productos = $stmt->get_result();
} else {
    $result_productos = $conn->query($sql);
}

// Categorías para filtro
$sql_categorias = "SELECT * FROM categorias ORDER BY nombre";
$result_categorias = $conn->query($sql_categorias);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Cafetería</title>
    <link rel="stylesheet" href="css/productos.css">
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo">☕ Cafetería</div>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="productos.php" class="active">Productos</a></li>
                <li><a href="pedidos.php">Pedidos</a></li>
            </ul>
        </nav>
    </header>

    <section class="section">
        <div class="container">
            <h1 class="section-title">Nuestros Productos</h1>

            <?php if (isset($mensaje_exito)): ?>
                <div class="alert alert-success">
                    ✓ <?php echo htmlspecialchars($mensaje_exito); ?>
                    <a href="pedidos.php" style="margin-left: 1rem;">Ver mis pedidos</a>
                </div>
            <?php endif; ?>

            <?php if (isset($mensaje_error)): ?>
                <div class="alert alert-error">✗ <?php echo htmlspecialchars($mensaje_error); ?></div>
            <?php endif; ?>

            <!-- Filtros -->
            <div class="filters">
                <form method="GET" action="productos.php" style="display: contents;">
                    <div class="filter-item">
                        <label for="categoria">Categoría</label>
                        <select name="categoria" id="categoria" class="form-control" onchange="this.form.submit()">
                            <option value="0">Todas las categorías</option>
                            <?php 
                            if ($result_categorias && $result_categorias->num_rows > 0):
                                while($cat = $result_categorias->fetch_assoc()): 
                            ?>
                                <option value="<?php echo $cat['id_categoria']; ?>" 
                                        <?php echo ($categoria_filtro == $cat['id_categoria']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['nombre']); ?>
                                </option>
                            <?php 
                                endwhile;
                            endif; 
                            ?>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="busqueda">Buscar producto</label>
                        <input type="text" name="busqueda" id="busqueda" class="form-control" 
                               placeholder="Nombre o descripción..." value="<?php echo htmlspecialchars($busqueda); ?>">
                    </div>

                    <div class="filter-item" style="display: flex; align-items: flex-end; gap: 0.5rem;">
                        <button type="submit" class="btn btn-small">Buscar</button>
                        <?php if ($categoria_filtro > 0 || !empty($busqueda)): ?>
                            <a href="productos.php" class="btn btn-secondary btn-small">Limpiar</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Grid de Productos -->
            <div class="products-grid">
                <?php if ($result_productos && $result_productos->num_rows > 0): ?>
                    <?php while($producto = $result_productos->fetch_assoc()): ?>
                        <div class="product-card">
                            <?php if (!empty($producto['imagen'])): ?>
                                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" 
                                     alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                                     class="product-image"
                                     onerror="this.src='https://via.placeholder.com/280x220?text=Sin+Imagen'">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/280x220?text=Sin+Imagen" alt="Sin imagen" class="product-image">
                            <?php endif; ?>
                            
                            <div class="product-info">
                                <?php if (!empty($producto['categoria_nombre'])): ?>
                                    <span class="product-category"><?php echo htmlspecialchars($producto['categoria_nombre']); ?></span>
                                <?php endif; ?>
                                
                                <h3 class="product-name"><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                                
                                <?php if (!empty($producto['descripcion'])): ?>
                                    <p class="product-description"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                                <?php endif; ?>
                                
                                <div class="product-price">$<?php echo number_format($producto['precio'], 2); ?></div>

                                <!-- Formulario de pedido -->
                                <form method="POST" action="productos.php" style="display: flex; gap: 0.5rem; align-items: center;">
                                    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                                    <input type="number" name="cantidad" min="1" value="1" class="form-control" 
                                           style="width: 80px; text-align: center;" required>
                                    <button type="submit" name="realizar_pedido" class="btn btn-small" style="flex: 1;">
                                        Ordenar
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <p>No se encontraron productos</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2026 Cafetería - Universidad Andrés Bello</p>
        </div>
    </footer>
</body>
</html>
<?php $conn->close(); ?>