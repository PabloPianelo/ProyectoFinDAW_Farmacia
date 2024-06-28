<?php include_once("views/common/autentificacionAdmin.php"); ?>
<link rel="stylesheet" type="text/css" href="Css/formulario.css">
<title>Editar Medicamento</title>

<body>
    <form action="index.php" method="POST">
        <input type="hidden" name="controlador" value="Medicamento">
        <input type="hidden" name="accion" value="editar_medicamento">
        <input type="hidden" name="medicamento_id" value="<?php echo $medicamento->getCodigoNacional(); ?>">

        <label for="nombre_producto">Nombre Producto</label>
        <input type="text" name="nombre_producto" value="<?php echo $medicamento->getNombreProducto(); ?>" maxlength="50"><br>
        <label for="laboratorio">Laboratorio</label>
        <input type="text" name="laboratorio" value="<?php echo $medicamento->getLaboratorio(); ?>" maxlength="50"><br>
        <label for="unidades">Unidades</label>
        <input type="text" name="unidades" value="<?php echo $medicamento->getUnidades(); ?>" maxlength="50"><br>

        <label for="select_estado">Estado</label>
        <select name="estado" id="select_estado">
            <option value="activo" <?php echo ($medicamento->getEstado() == "activo") ? "selected" : ""; ?>>activo</option>
            <option value="anulado" <?php echo ($medicamento->getEstado() == "anulado") ? "selected" : ""; ?>>anulado</option>
        </select><br>
        
        <label for="tipo">Dimensiones</label>
        <select name="tipo">
            <?php 
            foreach($tipos as $tipo) {
                $selected = ($tipo->getCodigo() == $medicamento->getPresentacion()) ? 'selected' : '';
                echo "<option value='".$tipo->getCodigo()."' $selected>" . $tipo->getNombre() . "</option>";
            }
            ?>
        </select>

        <!-- Botones dentro del mismo formulario -->
        <div class="button-wrapper">
			<input type="submit" name="submit" value="Aceptar" class="button_css"><br><br>
			<input type="button" value="Cancelar" onclick="window.location.href='index.php?controlador=Medicamento&accion=medicamento_lista'" class="button_css cancel-btn">
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
