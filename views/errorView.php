<!-- Vista para generar los errores. Si recibe una variable error la muestra -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Microframework MVC - Modelo, Vista, Controlador</title>
</head>

<body>
    <p>Se ha producido un error</p></br>

    <?php
    if (isset($error))
        echo $error . "</br>";
    ?>

    <a href="index.php">Inicio</a>
</body>

</html>