<?php include_once("views/common/autentificacionAdmin.php"); ?>
<link rel="stylesheet" type="text/css" href="Css/formulario.css">
<title>Nuevo Usuario</title>

<body>
    <form action="index.php" method="POST">
        <input type="hidden" name="controlador" value="Usuario">
        <input type="hidden" name="accion" value="nuevo_usuario">

        <?php echo isset($errores["usuario"]) ? "*" : "" ?>
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" maxlength="50" required>

        <label for="contraseña">Contraseña</label>
        <input type="password" name="contraseña" required>

        <input type="submit" name="submit" value="Aceptar" class="button_css"><br><br>
        <input type="button" value="Cancelar" onclick="window.location.href='index.php?controlador=Admin&accion=admin_lista'" class="button_css">
    </form>

    <br>
    <?php
    if (isset($errores)):
        foreach ($errores as $key => $error):
            echo $error . "<br>";
        endforeach;
    endif;
    ?>
</body>
