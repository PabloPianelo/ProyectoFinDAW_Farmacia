<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Medicamentos</title>
</head>
<body>

<?php include_once("common/menu.php"); ?>

<h1>MEDICAMENTOS</h1>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Codigo</th>
            <th scope="col">nombre</th>
            <th scope="col">laboratorio</th>
            <th scope="col">unidades</th>
            <th scope="col">estado</th>
            <th scope="col">nombre Presentación</th>
            <th scope="col">Acciones</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($medicamentos as $medicamento) { ?>
            <tr>
                <td><?php echo htmlspecialchars($medicamento->getCodigoNacional(), ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($medicamento->getNombreProducto(), ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($medicamento->getLaboratorio(), ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($medicamento->getUnidades(), ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($medicamento->getEstado(), ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <?php foreach ($tipos as $tipo) {
                        if ($medicamento->getPresentacion() == $tipo->getCodigo()) {
                            echo htmlspecialchars($tipo->getNombre(), ENT_QUOTES, 'UTF-8');
                        }
                    } ?>
                </td>
                <td>
                    <a href="index.php?controlador=Medicamento&accion=editar_medicamento&medicamento_id=<?php echo htmlspecialchars($medicamento->getCodigoNacional(), ENT_QUOTES, 'UTF-8'); ?>" class="button_css">Editar</a>
                </td>
                <td>
                    <a href="javascript:void(0);" onclick="confirmarEliminacion('<?php echo htmlspecialchars($medicamento->getCodigoNacional(), ENT_QUOTES, 'UTF-8'); ?>');" class="button_css">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<div class="button-container">
    <form action="index.php" method="post" enctype="multipart/form-data" id="filesForm">
        <input type="hidden" name="controlador" value="Admin">
        <input type="hidden" name="accion" value="insertar_Excel">
        <div class="col-md-4 offset-md-4">
            <input class="form-control" type="file" name="fileMedicamenstos">
            <button type="submit" id="uploadBtn" class="btn btn-primary form-control button_css">Cargar</button>
        </div>
    </form>

    <a href="index.php?controlador=Medicamento&accion=nuevo_medicamento" class="button_css">Nuevo</a><br><br>
</div>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    echo "<script type='text/javascript'>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '{$mensaje['titulo']}',
                text: '{$mensaje['texto']}',
                icon: '{$mensaje['tipo']}',
                confirmButtonText: 'OK'
            });
        });
    </script>";
    unset($_SESSION['mensaje']);
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
    function confirmarEliminacion(codigo) {
        console.log("Intentando eliminar medicamento con código:", codigo); // Línea de debug
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
                window.location.href = "index.php?controlador=Medicamento&accion=borrar_medicamento&medicamento_id=" + codigo;
            }
        });
    }
</script>

</body>
</html>
