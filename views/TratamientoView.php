<?php include_once("common/autentificacion.php"); ?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tratamientos</title>
    <link rel="stylesheet" type="text/css" href="Css/tratamiento.css">

</head>
<body>
<?php include_once("common/menuUsuario.php"); ?>

    <h2><span class="label"> Listado de Tratamientos de: </span> <?php echo $pacientes->getNombre() . ' ' . $pacientes->getApellidos();?></h2>
    
    <?php if (!empty($tratamientos)): ?>
        <table>
            <thead>
            <tr>
                <th>Código de Tratamiento</th>
                <th>Nombre del Paciente</th>
                <th>Fecha de Inicio</th>
                <th>Días de Realización</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <?php foreach ($tratamientos as $tratamiento): ?>
                <tr>
                    <td><?php echo $tratamiento->getCodigoTratamiento(); ?></td>
                    <td><?php echo $pacientes->getNombre() . ' ' . $pacientes->getApellidos();?></td>
                    <td><?php echo $tratamiento->getFechaInicio(); ?></td>
                    <td><?php echo $tratamiento->getDiasRealizacion(); ?></td>
                    <td>
                        <a href="index.php?controlador=Tratamiento&accion=ver_TomasTratamiento&codigo_tratamiento=<?php echo $tratamiento->getCodigoTratamiento(); ?> "class="button_css">Ver Tomas</a>

                                    
                                    
                        <?php 
                            echo '<a href="javascript:void(0);" onclick="confirmarEliminacion(\'' . htmlspecialchars($tratamiento->getCodigoTratamiento(), ENT_QUOTES, 'UTF-8') . '\', \'' . htmlspecialchars($pacientes->getIdPaciente(), ENT_QUOTES, 'UTF-8') . '\');" class="button_css">Borrar</a>';

                        ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <h2> No hay tratamientos disponibles.</h2>
    <?php endif; ?>


     <div class="button-container">
        <a href="index.php?controlador=Tratamiento&accion=pacientes_lista" class="button_css">Volver a la lista de pacientes</a>
        <a href="index.php?controlador=Tratamiento&accion=nuevo_tratamiento&paciente_id=<?php echo $pacientes->getIdPaciente(); ?> " class="button_css">Crear Tratamiento</a>
</div>







<script type="text/javascript">
    function confirmarEliminacion(codigo,codigo2) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?controlador=Tratamiento&accion=borrarTratamiento&codigo_tratamiento="+codigo+"&id_paciente="+codigo2;
            }
        });
    }
</script>









   
<footer>
<?php include("common/footer.php"); ?>
</footer>
</body>
</html>
