<?php
// Variables
$titulo = "Café y Delicias";
$subtitulo = "Empieza el día con dulzura y alegría";
$universidad = "Universidad Dr. Andrés Bello";
$asignatura = "Desarrollo Web y Aplicaciones para Móviles";
$docente = "Mtro. Jonathan Francisco Carballo Castro";

$equipo = array(
    array("apodo" => "eli", "nombre" => "Ing. Sonia Abrego", "carnet" => "an0174032023@unab.edu.sv"),
    array("apodo" => "luis", "nombre" => "Ing. Luis Abrego", "carnet" => "as0939032023@unab.edu.sv"),
    array("apodo" => "wendy", "nombre" => "Ing. Wendy Ayala", "carnet" => "@aa0722032023unab.edu.sv"),
    array("apodo" => "alondra", "nombre" => "Ing. Alondra López", "carnet" => "ll0416032023@unab.edu.sv"),
    array("apodo" => "ivan", "nombre" => "Ing. Ivan Membreño", "carnet" => "mg093032023@unab.edu.sv"),
    array("apodo" => "alex", "nombre" => "Ing. Alex Pineda", "carnet" => "pc0791032023@unab.edu.sv")
    );
?>

<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Café y Delicias</title>
</head>

<body>

    <div class="titulo">
        <header>
            <h1><?php echo $titulo; ?></h1>
            <p class="subtitulo"><?php echo $subtitulo ?></p>
        </header>

        <div class="info-box">
            <p><strong>Universidad:</strong> <?php echo $universidad; ?></p>
            <p><strong>Asignatura:</strong> <?php echo $asignatura; ?></p>
            <p><strong>Docente:</strong> <?php echo $docente; ?></p>
        </div>

        <h2 class="titulo-seccion">Desarrolladores</h2>

        <div class="team-grid">
            <?php foreach ($equipo as $persona): ?>
            <div class="team-card">
                <img
                src="img/perfiles/<?php echo $persona['apodo']?>.png"
                alt="imagen de perfil"
                >
                <h3><?php echo $persona['nombre']; ?></h3>
                <p><?php echo $persona['carnet']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="btnVerMenu">
            <a href="principal.php" class="btn">Ver menú</a>
        </div>

        <footer>
            <p><?php echo $titulo; ?> © 2026</p>
        </footer>
    </div>
</body>
</html>