<?php
// Variables
$cafes = array(
    array(
        "nombre" => "Espresso",
        "descripcion" => "Café espresso italiano intenso y aromático",
        "precio" => "$2.50",
        "img" => "espresso",
        "opciones" => array("Simple", "Doble", "Sin azúcar")
    ),
    array(
        "nombre" => "Cappuccino",
        "descripcion" => "Espresso con leche vaporizada y espuma",
        "precio" => "$3.75",
        "img" => "cappuccino",
        "opciones" => array("Leche entera", "Leche de almendra", "Extra espuma")
    ),
    array(
        "nombre" => "Latte",
        "descripcion" => "Café suave con leche y toque de vainilla",
        "precio" => "$4.25",
        "img" => "latte",
        "opciones" => array("Grande", "Mediano", "Leche de soya")
    ),
    array(
        "nombre" => "Americano",
        "descripcion" => "Espresso diluido con agua caliente, suave y ligero",
        "precio" => "$2.75",
        "img" => "americano",
        "opciones" => array("Simple", "Doble", "Con un toque de crema")
    ),
);

$bebidas = array(
    array(
        "nombre" => "Frappé de caramelo",
        "descripcion" => "Bebida helada con café y caramelo",
        "precio" => "$4.50",
        "img" => "frappe",
        "opciones" => array("Crema batida", "Extra caramelo", "Sin azúcar")
    ),
    array(
        "nombre" => "Smoothie de fresa",
        "descripcion" => "Batido natural de fresas con yogurt",
        "precio" => "$3.95",
        "img" => "smoothie",
        "opciones" => array("Proteína extra", "Sin azúcar", "Leche de coco")
    ),
    array(
        "nombre" => "Té helado",
        "descripcion" => "Té negro con durazno servido frío",
        "precio" => "$3.25",
        "img" => "teHelado",
        "opciones" => array("Con limón", "Menta fresca", "Sin azúcar")
    ),
    array(
        "nombre" => "Matcha latte",
        "descripcion" => "Té verde matcha cremoso con leche vaporizada",
        "precio" => "$4.50",
        "img" => "matchaLatte",
        "opciones" => array("Leche de avena", "Extra matcha", "Frío")
    ),
);

$postres = array(
    array(
        "nombre" => "Cheesecake",
        "descripcion" => "Suave cheesecake con frutos rojos",
        "precio" => "$4.75",
        "img" => "cheesecake",
        "opciones" => array("Porción grande", "Extra frutos", "Sin topping")
    ),
    array(
        "nombre" => "Brownie",
        "descripcion" => "Brownie de chocolate con nueces",
        "precio" => "$3.95",
        "img" => "brownie",
        "opciones" => array("Con helado", "Sin nueces", "Caliente")
    ),
    array(
        "nombre" => "Tiramisú",
        "descripcion" => "Postre italiano con café y mascarpone",
        "precio" => "$5.25",
        "img" => "tiramisu",
        "opciones" => array("Porción individual", "Extra cacao", "Sin alcohol")
    ),
    array(
        "nombre" => "Flan de caramelo",
        "descripcion" => "Clásico flan casero con salsa de caramelo suave",
        "precio" => "$4.25",
        "img" => "flan",
        "opciones" => array("Con crema batida", "Extra caramelo", "Sin gluten")
    ),
);

$snacks = array(
    array(
        "nombre" => "Croissant",
        "descripcion" => "Croissant con jamón y queso",
        "precio" => "$3.50",
        "img" => "croissant",
        "opciones" => array("Caliente", "Queso extra", "Sin jamón")
    ),
    array(
        "nombre" => "Panini",
        "descripcion" => "Pan tostado con mozzarella y tomate",
        "precio" => "$4.95",
        "img" => "panini",
        "opciones" => array("Vegetariano", "Con pesto", "Extra albahaca")
    ),
    array(
        "nombre" => "Galletas",
        "descripcion" => "Pack de 4 galletas recién horneadas",
        "precio" => "$2.95",
        "img" => "galletas",
        "opciones" => array("6 unidades", "Sin nueces", "Mix variado")
    ),
        array(
        "nombre" => "Muffin de arándano",
        "descripcion" => "Muffin esponjoso con arándanos frescos",
        "precio" => "$3.25",
        "img" => "muffinArandano",
        "opciones" => array("Caliente", "Sin azúcar añadido", "Con nueces")
    )
);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - Café Delicias</title>
    <link rel="stylesheet" href="principal.css">
</head>

<body>

    <nav>
        <div class="nav-bar">
            <div class="logo">Café y Delicias</div>
            <div class="nav-links">
                <a href="#cafes">Cafés</a>
                <a href="#bebidas">Bebidas</a>
                <a href="#postres">Postres</a>
                <a href="#snacks">Snacks</a>
            </div>
        </div>
    </nav>

    <div class="banner">
        <h1>Nuestro Menú</h1>
    </div>

    <div class="container-producto">

        <!-- Cafés -->
        <section id="cafes" class="categoria">
            <h2>Cafés</h2>
            <div class="productos">
                <?php foreach ($cafes as $item): ?>
                <div class="producto">
                    <div>
                        <img class="img"
                        src="img/items/cafes/<?php echo $item['img']?>.png"
                        alt="imagen de items"
                        >
                    </div>
                    <div class="producto-info">
                        <h3 class="producto-nombre"><?php echo $item['nombre']; ?></h3>
                        <p class="producto-descripcion"><?php echo $item['descripcion']; ?></p>
                        <div class="producto-precio"><?php echo $item['precio']; ?></div>
                        <div class="opciones">
                            <h4>Opciones</h4>
                            <div class="tags">
                                <?php foreach ($item['opciones'] as $op): ?>
                                <span class="tag"><?php echo $op; ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Bebidas Frías -->
        <section id="bebidas" class="categoria">
            <h2>Bebidas Frías</h2>
            <div class="productos">
                <?php foreach ($bebidas as $item): ?>
                <div class="producto">
                    <div>
                        <img class="img"
                        src="img/items/bebidasFrias/<?php echo $item['img']?>.png"
                        alt="imagen de items"
                        >
                    </div>
                    <div class="producto-info">
                        <h3 class="producto-nombre"><?php echo $item['nombre']; ?></h3>
                        <p class="producto-descripcion"><?php echo $item['descripcion']; ?></p>
                        <div class="producto-precio"><?php echo $item['precio']; ?></div>
                        <div class="opciones">
                            <h4>Opciones</h4>
                            <div class="tags">
                                <?php foreach ($item['opciones'] as $op): ?>
                                <span class="tag"><?php echo $op; ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Postres -->
        <section id="postres" class="categoria">
            <h2>Postres</h2>
            <div class="productos">
                <?php foreach ($postres as $item): ?>
                <div class="producto">
                    <div>
                        <img class="img"
                        src="img/items/postres/<?php echo $item['img']?>.png"
                        alt="imagen de items"
                        >
                    </div>
                    <div class="producto-info">
                        <h3 class="producto-nombre"><?php echo $item['nombre']; ?></h3>
                        <p class="producto-descripcion"><?php echo $item['descripcion']; ?></p>
                        <div class="producto-precio"><?php echo $item['precio']; ?></div>
                        <div class="opciones">
                            <h4>Opciones</h4>
                            <div class="tags">
                                <?php foreach ($item['opciones'] as $op): ?>
                                <span class="tag"><?php echo $op; ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Snacks -->
        <section id="snacks" class="categoria">
            <h2>Snacks</h2>
            <div class="productos">
                <?php foreach ($snacks as $item): ?>
                <div class="producto">
                    <div>
                        <img class="img"
                        src="img/items/snacks/<?php echo $item['img']?>.png"
                        alt="imagen de items"
                        >
                    </div>
                    <div class="producto-info">
                        <h3 class="producto-nombre"><?php echo $item['nombre']; ?></h3>
                        <p class="producto-descripcion"><?php echo $item['descripcion']; ?></p>
                        <div class="producto-precio"><?php echo $item['precio']; ?></div>
                        <div class="opciones">
                            <h4>Opciones</h4>
                            <div class="tags">
                                <?php foreach ($item['opciones'] as $op): ?>
                                <span class="tag"><?php echo $op; ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <div class="btnVolver">
            <a href="index.php" class="btn">Volver</a>
        </div>
    </div>

    <footer>
        <p>Café y Delicias © 2026</p>
    </footer>
</body>
</html>