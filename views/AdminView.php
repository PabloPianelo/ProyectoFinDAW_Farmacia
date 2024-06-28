 <?php include_once("common/autentificacionAdmin.php"); ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css/admin.css">

    <title>Admin</title>
    <?php include_once("common/menu.php"); ?>    
</head>
 

<body>

<h1>USUARIOS</h1>
<table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Usuario</th>
                <th>Editar</th>
                <th>Eliminar</th>
              

            </tr>
        </thead>
        <?php

        foreach ($usuarios as $usuario) {

            if ($usuario->getPerfil()!="administrador") {
              
            

        ?>
            <tbody>
                <tr>
                    <td><?php echo $usuario->getUsuario(); ?></td>
                    
                    <td><a href="index.php?controlador=Usuario&accion=editar_usuario&usuario_id=<?php echo $usuario->getId_usuario() ?>"class="button_css">Editar</a>
                    </td>
                    
                    
                   
                <td>
                    <a href="javascript:void(0);" onclick="confirmarEliminacion('<?php echo htmlspecialchars($usuario->getId_usuario(), ENT_QUOTES, 'UTF-8'); ?>');" class="button_css">Eliminar</a>
                </td>
                    


                </tr>
            <?php
            }
        }
            ?>
            </tbody>
    </table>
    <div class="button-container">

            <a href="index.php?controlador=Usuario&accion=nuevo_usuario" class="button_css">Nuevo</a>
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
                window.location.href = "index.php?controlador=Usuario&accion=borrar_usuario&usuario_id=" + codigo;
            }
        });
    }
</script>


</body>
</html>
