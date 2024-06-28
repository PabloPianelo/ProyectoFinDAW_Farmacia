<?php include_once("views/common/autentificacionAdmin.php"); ?>
<link rel="stylesheet" type="text/css" href="Css/formulario.css">
<title>Nuevo Medicamento</title>



<body>
    <form action="index.php">
        <input type="hidden" name="controlador" value="Medicamento">
        <input type="hidden" name="accion" value="nuevo_medicamento">

		<?php echo isset($errores["codigo"]) ? "*" : "" ?>
        <label for="codigo">Codigo del Producto</label>
        <input type="text" name="codigo" required>

        <?php echo isset($errores["nombre_producto"]) ? "*" : "" ?>
        <label for="nombre_producto">Nombre del Producto</label>
        <input type="text" name="nombre_producto" required>

        <?php echo isset($errores["laboratorio"]) ? "*" : "" ?>
        <label for="laboratorio">Laboratorio</label>
        <input type="text" name="laboratorio" required>

        <?php echo isset($errores["unidades"]) ? "*" : "" ?>
        <label for="unidades">Unidades</label>
        <input type="number" name="unidades" required>

        <?php echo isset($errores["estado"]) ? "*" : "" ?>
		<label for="estado">Estado</label>
		<select name="estado" required>
			<option value="activo">Activo</option>
			<option value="anulado">Anulado</option>
		</select>



        <label for="tipo">Dimensiones</label>
		<select name="tipo" required>
        <?php foreach($tipos as $tipo): ?>
            <option value="<?php echo $tipo->getCodigo(); ?>"><?php echo $tipo->getNombre(); ?></option>
        <?php endforeach; ?>

        <!-- Botones dentro del mismo formulario -->
        <div class="button-wrapper">
			<input type="submit" name="submit" value="Aceptar" class="button_css"><br><br>
			<input type="button" value="Cancelar" onclick="window.location.href='index.php?controlador=Medicamento&accion=medicamento_lista'" class="button_css cancel-btn">
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
