<?php
require_once 'config/database.php';
//$conn = getConnection();

// Eliminar pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_pedido'])) {
    $id_pedido = intval($_POST['id_pedido']);
    
    if ($id_pedido > 0) {
        $sql_delete = "DELETE FROM pedidos WHERE id_pedido = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bind_param("i", $id_pedido);
        
        if ($stmt->execute()) {
            $mensaje_exito = "Pedido eliminado exitosamente.";
        } else {
            $mensaje_error = "Error al eliminar el pedido.";
        }
        $stmt->close();
    }
}

// Obtener pedidos
$sql_pedidos = "SELECT 
                    ped.id_pedido,
                    ped.cantidad,
                    ped.fecha_pedido,
                    p.id_producto,
                    p.nombre as producto_nombre,
                    p.descripcion as producto_descripcion,
                    p.precio,
                    p.imagen,
                    c.nombre as categoria_nombre,
                    (ped.cantidad * p.precio) as total
                FROM pedidos ped
                INNER JOIN productos p ON ped.id_producto = p.id_producto
                LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
                ORDER BY ped.fecha_pedido DESC";
$result_pedidos = $conn->query($sql_pedidos);

// Estadísticas
$sql_stats = "SELECT 
                COUNT(*) as total_pedidos,
                SUM(ped.cantidad) as total_productos,
                SUM(ped.cantidad * p.precio) as total_ventas
              FROM pedidos ped
              INNER JOIN productos p ON ped.id_producto = p.id_producto";
$result_stats = $conn->query($sql_stats);
$stats = $result_stats->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Cafetería</title>
    <link rel="stylesheet" href="css/pedidos.css">
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo">☕ Cafetería</div>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="pedidos.php" class="active">Pedidos</a></li>
            </ul>
        </nav>
    </header>

    <section class="section">
        <div class="container">
            <h1 class="section-title">Mis Pedidos</h1>

            <?php if (isset($mensaje_exito)): ?>
                <div class="alert alert-success">✓ <?php echo htmlspecialchars($mensaje_exito); ?></div>
            <?php endif; ?>

            <?php if (isset($mensaje_error)): ?>
                <div class="alert alert-error">✗ <?php echo htmlspecialchars($mensaje_error); ?></div>
            <?php endif; ?>

            <!-- Estadísticas -->
            <?php if ($stats['total_pedidos'] > 0): ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
                    <div class="order-card" style="text-align: center;">
                        <div style="font-size: 2.5rem; color: #6F4E37; font-weight: bold;">
                            <?php echo $stats['total_pedidos']; ?>
                        </div>
                        <div style="color: #666; margin-top: 0.5rem;">Total de Pedidos</div>
                    </div>
                    <div class="order-card" style="text-align: center;">
                        <div style="font-size: 2.5rem; color: #6F4E37; font-weight: bold;">
                            <?php echo $stats['total_productos']; ?>
                        </div>
                        <div style="color: #666; margin-top: 0.5rem;">Productos Ordenados</div>
                    </div>
                    <div class="order-card" style="text-align: center;">
                        <div style="font-size: 2.5rem; color: #6F4E37; font-weight: bold;">
                            $<?php echo number_format($stats['total_ventas'], 2); ?>
                        </div>
                        <div style="color: #666; margin-top: 0.5rem;">Total en Ventas</div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Tabla de Pedidos -->
            <div class="table-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h2 style="color: #6F4E37; margin: 0;">Historial de Pedidos</h2>
                    <?php if ($result_pedidos && $result_pedidos->num_rows > 0): ?>
                        <a href="productos.php" class="btn btn-small">Nuevo Pedido</a>
                    <?php endif; ?>
                </div>

                <?php if ($result_pedidos && $result_pedidos->num_rows > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Precio Unit.</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($pedido = $result_pedidos->fetch_assoc()): ?>
                                <tr>
                                    <td><strong>#<?php echo str_pad($pedido['id_pedido'], 4, '0', STR_PAD_LEFT); ?></strong></td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            <?php if (!empty($pedido['imagen'])): ?>
                                                <img src="<?php echo htmlspecialchars($pedido['imagen']); ?>" 
                                                     alt="<?php echo htmlspecialchars($pedido['producto_nombre']); ?>"
                                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;"
                                                     onerror="this.style.display='none'">
                                            <?php endif; ?>
                                            <strong><?php echo htmlspecialchars($pedido['producto_nombre']); ?></strong>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (!empty($pedido['categoria_nombre'])): ?>
                                            <span class="badge badge-info">
                                                <?php echo htmlspecialchars($pedido['categoria_nombre']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>$<?php echo number_format($pedido['precio'], 2); ?></td>
                                    <td><span class="order-quantity"><?php echo $pedido['cantidad']; ?></span></td>
                                    <td><strong style="color: #6F4E37;">$<?php echo number_format($pedido['total'], 2); ?></strong></td>
                                    <td style="white-space: nowrap;">
                                        <?php 
                                        $fecha = new DateTime($pedido['fecha_pedido']);
                                        echo $fecha->format('d/m/Y H:i');
                                        ?>
                                    </td>
                                    <td>
                                        <form method="POST" action="pedidos.php" 
                                              onsubmit="return confirm('¿Está seguro de eliminar este pedido?');"
                                              style="display: inline;">
                                            <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">
                                            <button type="submit" name="eliminar_pedido" class="btn btn-small"
                                                    style="background: #dc3545; padding: 0.4rem 0.8rem;">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📦</div>
                        <h3>No hay pedidos registrados</h3>
                        <p style="margin-top: 1.5rem;">
                            <a href="productos.php" class="btn">Explorar Productos</a>
                        </p>
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