<?php include_once("common/autentificacion.php"); ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UserView</title>
    <link rel="stylesheet" type="text/css" href="Css/usuarios.css">

</head>
<body>

<?php include_once("common/menuUsuario.php"); ?>





<!-- Lista de pacientes -->

<h1>LISTADO DE PACIENTES</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos </th>
                <th scope="col">DNI</th>
                <th scope="col">Acciones </th>
            

            </tr>
        </thead>
        <?php



        foreach ($pacientes as $paciente) {    
        ?>
        <tbody>
            <tr>


            <td><?php echo $paciente->getNombre()?></td>

            <td><?php echo $paciente->getApellidos(); ?></td>

            <td><?php echo $paciente->getDni(); ?></td>

            <td><a href="index.php?controlador=Tratamiento&accion=ver_tratamientos&id_paciente=<?php echo $paciente->getIdPaciente(); ?>"class="button_css">Ver tratamientos</a></td>

            

            </tr>



        </tbody>
    

        
       
<?php } ?>
</table>

<footer>
<?php include("common/footer.php"); ?>
</footer>

</body>

</html>
