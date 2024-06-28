<?php include_once("views/common/autentificacionAdmin.php"); ?>
<link rel="stylesheet" type="text/css" href="Css/formulario.css">
<title>Nuevo Paciente</title>

<body>
	<form action="index.php">
		<form action="index.php" method="POST">
    <input type="hidden" name="controlador" value="Paciente">
    <input type="hidden" name="accion" value="nuevo_paciente">


    <label for="DNI">DNI</label>
    <input type="text" name="DNI" maxlength="9" required><br>

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" maxlength="50" required><br>

    <label for="apellidos">Apellidos</label>
    <input type="text" name="apellidos" maxlength="50" required><br>

    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
    <input type="date" name="fecha_nacimiento" required><br>

    <label for="telefono_fijo">Teléfono Fijo</label>
    <input type="number" name="telefono_fijo" maxlength="9"><br>

    <label for="telefono_movil">Teléfono Móvil</label>
    <input type="number" name="telefono_movil" maxlength="9"><br>

    <label for="correo_electronico">Correo Electrónico</label>
    <input type="email" name="correo_electronico" maxlength="50"><br>

    <div class="button-wrapper">
            <input type="submit" name="submit" value="Aceptar" class="button_css"><br><br>
            <input type="button" value="Cancelar" onclick="window.location.href='index.php?controlador=Paciente&accion=paciente_lista'" class="button_css">
        </div>
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
