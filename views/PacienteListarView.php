<?php include_once("common/autentificacionAdmin.php"); ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css/admin.css">

    <title>Pacientes</title>
</head>
<body>

<?php include_once("common/menu.php"); ?>


    <h1>PACIENTES</h1>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">DNI</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Fecha de nacimiento</th>
                <th scope="col">Telefono fijo</th>
                <th scope="col">Telefono  movil</th>
                <th scope="col">Correo electronico</th>
                <th scope="col">Acciones</th>
                <th scope="col">Acciones</th>
                
              

            </tr>
        </thead>
        <?php

        foreach ($pacientes as $paciente) {

         
              
            

        ?>
            <tbody>
                <tr>
                    <td><?php echo $paciente->getDNI(); ?></td>

                    <td><?php echo $paciente->getNombre(); ?></td>

                    <td><?php echo $paciente->getApellidos(); ?></td>

                    <td><?php echo $paciente->getFechaNacimiento(); ?></td>

                    <td><?php echo $paciente->getTelefonoFijo(); ?></td>

                    <td><?php echo $paciente->getTelefonoMovil(); ?></td>

                    <td><?php echo $paciente->getCorreoElectronico(); ?></td>
                    
                    <td><a href="index.php?controlador=Paciente&accion=editar_paciente&paciente_id=<?php echo $paciente->getIdPaciente(); ?>"class="button_css">Editar</a>
                    </td>
                    <td>
                    <a href="javascript:void(0);" onclick="confirmarEliminacion('<?php echo htmlspecialchars($paciente->getIdPaciente(), ENT_QUOTES, 'UTF-8'); ?>');" class="button_css">Eliminar</a>
                </td>
                    
                    


                </tr>
            <?php
            
        }
            ?>
            </tbody>
    </table>
    <div class="button-container">
        <a href="index.php?controlador=Paciente&accion=nuevo_paciente" class="button_css">Nuevo</a>
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
                window.location.href = "index.php?controlador=Paciente&accion=borrar_paciente&paciente_id=" + codigo;
            }
        });
    }
</script>




</html>
