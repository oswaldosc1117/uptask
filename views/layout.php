<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpTask | <?php echo $titulo ?? ''; ?></title> <!-- NG - 1. -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/363fc120a5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="build/css/app.css">
</head>
<body>

    <?php echo $contenido; ?>
    <?php echo $script ?? ''; ?>

</body>
</html>

<!-- NOTAS GENERALES

    1.- Mediante esta forma, se pueden generar titulos dinamicos. Esto se incluye en el controlador, mas especificamente en el $router->render que acompañe a la
    vista.
-->