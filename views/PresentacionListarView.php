<?php include_once("common/autentificacionAdmin.php"); ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css/admin.css">
    <title>Presentacion</title>
</head>
<body>

<?php include_once("common/menu.php"); ?>



<h1>Presentación</h1>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Largo</th>
                <th scope="col">Ancho</th>
                <th scope="col">Alto</th>
                <th scope="col">Cantidad de alto</th>
                <th scope="col">Acciones</th>
                <th scope="col">Acciones</th>
                
              

            </tr>
        </thead>
        <?php

        foreach ($tipos as $tipo) {

         
              
            

        ?>
            <tbody>
                <tr>

                <td><?php echo $tipo->getNombre(); ?></td>
                    <td><?php echo $tipo->getLargo(); ?></td>
                    <td><?php echo $tipo->getAncho(); ?></td>
                    <td><?php echo $tipo->getAlto(); ?></td>
                    <td><?php echo $tipo->getCantidadAlto(); ?></td>

                    
                    <td><a href="index.php?controlador=TipoPresentacion&accion=editar_presentacion&tipo_id=<?php echo $tipo->getCodigo(); ?>"class="button_css">Editar</a>
                    </td>
                     <td>
                    <a href="javascript:void(0);" onclick="confirmarEliminacion('<?php echo htmlspecialchars( $tipo->getCodigo(), ENT_QUOTES, 'UTF-8'); ?>');" class="button_css">Eliminar</a>
                </td>
                    


                </tr>
            <?php
            
        }
            ?>
            </tbody>
    </table>
    <div class="button-container">
    <a href="index.php?controlador=TipoPresentacion&accion=nueva_presentacion" class="button_css">Nuevo</a>

    </div>
    



    <script type="text/javascript">
    function confirmarEliminacion(codigo) {
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
                window.location.href = "index.php?controlador=TipoPresentacion&accion=borrar_presentacion&tipo_id=" + codigo;
            }
        });
    }
</script>



</body>


</html>
