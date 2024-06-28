<?php include_once("views/common/autentificacionAdmin.php"); ?>
<link rel="stylesheet" type="text/css" href="Css/formulario.css">
<title>Nuevo Tipo</title>

<body>
	<form action="index.php">
		<input type="hidden" name="controlador" value="TipoPresentacion">
		<input type="hidden" name="accion" value="nueva_presentacion">

		<label for="nombre">Nombre*</label>
        <input type="text" name="nombre" value="" required><br>
        <label for="largo">Largo*</label>
        <input type="float" name="largo" value="" required><br>
        <label for="ancho">Ancho*</label>
        <input type="float" name="ancho" value=""required><br>
		<label for="alto">Alto*</label>
        <input type="float" name="alto" value=""required><br>
        <label for="cantidadAlto">Cantidad Alto*</label>
        <input type="float" name="cantidadAlto" value=""required><br>

		

		<div class="button-wrapper">
            <input type="submit" name="submit" value="Aceptar" class="button_css"><br><br>
            <input type="button" value="Cancelar" onclick="window.location.href='index.php?controlador=TipoPresentacion&accion=presentacion_lista'" class="button_css">
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
