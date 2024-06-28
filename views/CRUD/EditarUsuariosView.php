<?php include_once("views/common/autentificacionAdmin.php"); ?>
<link rel="stylesheet" type="text/css" href="Css/formulario.css">


<html>
<body>

	<form action="index.php" method="POST">

		<input type="hidden" name="controlador" value="Usuario">
		<input type="hidden" name="accion" value="editar_usuario">
        <input type="hidden" name="usuario_id" value="<?php echo $usuario->getId_usuario(); ?>">

		<?php echo isset($errores["equipo"]) ? "*" : "" ?>
		<label for="equipo">Usuario</label>
		<input type="text" name="usuario" maxlength="10" value="<?php echo $usuario->getUsuario(); ?>">
		<br>

		<label for="presupuesto">Contraseña</label>
		<input type="password" name="contraseña" value="<?php echo $usuario->getContraseña(); ?>">

		<div class="button-wrapper">
			<input type="submit" name="submit" value="Aceptar" class="button_css"><br><br>
			<input type="button" value="Cancelar" onclick="window.location.href='index.php?controlador=Admin&accion=admin_lista'" class="button_css cancel-btn">
		</div>
	</form>
	
	<br>
	<?php
	if (isset($errores)) :
		foreach ($errores as $key => $error) :
			echo $error . "<br>";
		endforeach;
	endif;
	?>

</body>
</html>