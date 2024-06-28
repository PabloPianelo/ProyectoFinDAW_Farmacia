<?php include_once("views/common/autentificacionAdmin.php"); ?>
<link rel="stylesheet" type="text/css" href="Css/formulario.css">
<title>Editar Paciente</title>

<body>

    <form action="index.php" method="POST">
        <input type="hidden" name="controlador" value="Paciente">
        <input type="hidden" name="accion" value="editar_paciente">
        <input type="hidden" name="paciente_id" value="<?php echo $paciente->getIdPaciente(); ?>">

        <label for="DNI">DNI</label>
        <input type="text" name="DNI" value="<?php echo $paciente->getDNI(); ?>" maxlength="9"><br>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" value="<?php echo $paciente->getNombre(); ?>" maxlength="50"><br>
        <label for="apellidos">Apellidos</label>
        <input type="text" name="apellidos" value="<?php echo $paciente->getApellidos(); ?>" maxlength="50"><br>
        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
        <input type="date" name="fecha_nacimiento" value="<?php echo $paciente->getFechaNacimiento(); ?>"><br>
        <label for="telefono_fijo">Teléfono Fijo</label>
        <input type="text" name="telefono_fijo" value="<?php echo $paciente->getTelefonoFijo(); ?>" maxlength="9"><br>
        <label for="telefono_movil">Teléfono Móvil</label>
        <input type="text" name="telefono_movil" value="<?php echo $paciente->getTelefonoMovil(); ?>" maxlength="9"><br>
        <label for="correo_electronico">Correo Electrónico</label>
        <input type="email" name="correo_electronico" value="<?php echo $paciente->getCorreoElectronico(); ?>" maxlength="50"><br><br>

        <div class="button-wrapper">
			<input type="submit" name="submit" value="Aceptar" class="button_css"><br><br>
			<input type="button" value="Cancelar" onclick="window.location.href='index.php?controlador=Paciente&accion=paciente_lista'" class="button_css cancel-btn">
		</div>
    </form>

    <br>
    <?php
    if (isset($errores)) :
        foreach ($errores as $key => $error) :
            echo $error . "</br>";
        endforeach;
    endif;
    ?>

</body>

</html>
