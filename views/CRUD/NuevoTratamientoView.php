<?php include_once("views/common/autentificacion.php"); ?> 
<link rel="stylesheet" type="text/css" href="Css/Formulario_Medicamento.css">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Tratamiento</title>
    <?php include_once("views/common/menuUsuario.php"); ?>
</head>
<body>
   
    <h1><span class="label">Nuevo Tratamiento para el Paciente: </span> <?php echo $paciente_id->getNombre() ?></h1>
    
    <?php if (!empty($errores)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form id="formularioTratamiento" action="index.php?controlador=Tratamiento&accion=nuevo_tratamiento" method="POST">

        <label id="fecha_inicio" for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" required><br><br>
        
        <label for="dias_realizacion">Días de Realización:</label>
        <input type="number" name="dias_realizacion" placeholder="Número de días" min="1" required><br><br>
       
        <input type="hidden" name="id_paciente" value="<?php echo $paciente_id->getIdPaciente(); ?>"><br><br>
        

        <div class="button-wrapper"> 
        <input type="submit" name="submit" value="Guardar" class="button_css">
       
        <a href="index.php?controlador=Tratamiento&accion=ver_tratamientos&id_paciente=<?php echo $paciente_id->getIdPaciente() ?>"class="button_css">Cancelar</a>
        </div>
    </form>
    
    
</body>
</html>
