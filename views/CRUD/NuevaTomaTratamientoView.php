<?php include_once("views/common/autentificacion.php"); ?> 
<link rel="stylesheet" type="text/css" href="Css/Formulario_Medicamento.css">
<title>Nueva Toma</title>
<?php include_once("views/common/menuUsuario.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Tratamiento</title>
</head>
<body>
    
    <?php if (!empty($errores)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form id="formularioTratamiento" action="index.php?controlador=Tratamiento&accion=agregar_medicamento" method="POST">
        
        <label for="medicamentos">Medicamento:</label>
        <select name="medicamentos" required>
            <option value="">Selecciona un medicamento</option>
            <?php foreach ($medicamentos as $m): ?>
                <option value="<?php echo $m->getCodigoNacional(); ?>"><?php echo $m->getNombreProducto(); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="dia_toma">Días de Toma:</label><br>
        <input type="checkbox" name="dia_toma[]" value="Lunes"> Lunes<br>
        <input type="checkbox" name="dia_toma[]" value="Martes"> Martes<br>
        <input type="checkbox" name="dia_toma[]" value="Miércoles"> Miércoles<br>
        <input type="checkbox" name="dia_toma[]" value="Jueves"> Jueves<br>
        <input type="checkbox" name="dia_toma[]" value="Viernes"> Viernes<br>
        <input type="checkbox" name="dia_toma[]" value="Sabado"> Sabado<br>
        <input type="checkbox" name="dia_toma[]" value="Domingo"> Domingo<br>
        <!-- Agrega más checkboxes según los días necesarios -->

        <br>

        <label for="hora_toma">Horas de Toma:</label><br>
        <input type="checkbox" name="hora_toma[]" value="Mañana"> Mañana<br>
        <input type="checkbox" name="hora_toma[]" value="Mediodía"> Mediodía<br>
        <input type="checkbox" name="hora_toma[]" value="Noche"> Noche<br>
        <!-- Agrega más checkboxes según las horas necesarias -->

        <br>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" min="1" required><br><br>

        <input type="hidden" name="codigo_tratamiento" value="<?php echo $tratamiento->getCodigoTratamiento(); ?>"><br><br>

        <div class="button-wrapper"> 
                <input type="submit" name="submit" value="Guardar" class="button_css">
                <a href="index.php?controlador=Tratamiento&accion=ver_TomasTratamiento&codigo_tratamiento=<?php echo $tratamiento->getCodigoTratamiento() ?>" class="button_css">Cancelar</a>
        </form>
        </div>
        
       
    </form>
</body>
</html>