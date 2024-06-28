<?php include_once("common/autentificacion.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>TomasTratamiento</title>
    <link rel="stylesheet" type="text/css" href="Css/tratamiento.css">
    <?php include_once("common/menuUsuario.php"); ?>
    <script src="js/mostrarDetalle.js"></script>
</head>
<body>

    <h2><span class="label">Tabla de Medicamentos por Día de:</span> <?php echo htmlspecialchars($paciente->getNombre() . ' ' . $paciente->getApellidos()); ?></h2>
    <h2><span class="label">Fecha inicio:</span> <?php echo htmlspecialchars($tratamiento->getFechaInicio()); ?></h2>
    <h2><span class="label">Días realización:</span> <?php echo htmlspecialchars($tratamiento->getDiasRealizacion()); ?></h2>

    <table>
        <thead>
            <tr>
                <th>Día de la Semana</th>
                <?php
                // Días de la semana
                $dias_semana = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
                foreach ($dias_semana as $dia) {
                    echo "<th>" . htmlspecialchars($dia) . "</th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // Horarios del día
            $horarios = ["Mañana", "Mediodia", "Noche"];

            // Generar la tabla
            foreach ($horarios as $horario) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($horario) . "</td>";

                foreach ($dias_semana as $dia) {
                    echo "<td>";
                    $tomas_encontradas = false;

                    foreach ($tomas as $toma_info) {
                        if (strtolower($toma_info->getDiaToma()) == strtolower($dia) && strtolower($toma_info->getHoraToma()) == strtolower($horario)) {
                            $codigo_medicamento = $toma_info->getCodigoMedicamento();
                            $nombre_medicamento = $toma_info->getNombreMedicamento($codigo_medicamento);
                            $cantidad = $toma_info->getCantidad();

                            echo htmlspecialchars("$nombre_medicamento (Cantidad: $cantidad)") . "<br>";
                            $tomas_encontradas = true;
                        }
                    }

                    if (!$tomas_encontradas) {
                        echo "-"; // Mostrar un guión si no hay tomas de tratamiento registradas
                    }
                    echo "</td>";
                }

                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="button-container">
        <a href="index.php?controlador=Tratamiento&accion=agregar_medicamento&codigo_tratamiento=<?php echo htmlspecialchars($tratamiento->getCodigoTratamiento()); ?>" class="button_css">Agregar Medicamento</a>
        <a href="index.php?controlador=Tratamiento&accion=vaciar_tabla&codigo_tratamiento=<?php echo htmlspecialchars($tratamiento->getCodigoTratamiento()); ?>" class="button_css">Vaciar la tabla</a>
        <button id="verInfoBtn" class="button_css" onclick="mostrarDetalles()">Mostrar dimensiones por celda</button><br><br>
        <a href="js/index.html" class="button_css">Ver modelo 3D</a>
        <a href="index.php?controlador=Tratamiento&accion=ver_tratamientos&id_paciente=<?php echo htmlspecialchars($paciente->getIdPaciente()); ?>" class="button_css">Volver a la lista de Tratamientos</a>
        <a href="index.php?controlador=Tratamiento&accion=pacientes_lista" class="button_css">Volver a la lista de pacientes</a>
    </div>
    

    <h2><span class="label">DIMENSIONES</span></h2>

    <?php
    $max_largo = array(0, 0, 0); // Array para largo: [mañana, mediodia, noche]
    $max_ancho = array(0, 0, 0, 0, 0, 0, 0); // Array para ancho: [Lunes, Martes, Miércoles, Jueves, Viernes, Sábado, Domingo]
    $max_alto = 0.1;
    $detalle_medicamentos = array();

    $dias_semana = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $horarios = array("Mañana", "Mediodia", "Noche");

    foreach ($horarios as $horario_idx => $horario) {
        foreach ($dias_semana as $dia_idx => $dia) {
            $largo_celda = 0;
            $ancho_celda = 0;
            $alto_celda = 0;
            $medicamentos_celda = array();

            foreach ($tomas as $toma_info) {
                if (strtolower($toma_info->getDiaToma()) == strtolower($dia) && strtolower($toma_info->getHoraToma()) == strtolower($horario)) {
                    $codigo_presentacion = $toma_info->getCodigoPresentacion($toma_info->getCodigoMedicamento());
                    $codigo_medicamento_celda = $toma_info->getCodigoMedicamento();
                    $dimensiones = $toma_info->getDimensionesMedicamento($codigo_presentacion);
                    $cantidad = $toma_info->getCantidad();

                    // Calcular la cantidad de filas necesarias para acomodar todas las pastillas
                    $cantidad_alto = $dimensiones['cantidad_alto'];
                    $filas_necesarias = ceil($cantidad / $cantidad_alto);

                    // para este medicamento en esta celda
                    $largo_requerido = $dimensiones['largo'] * $filas_necesarias;
                    $largo_celda += $largo_requerido;

                    // Ajustar el ancho del pastillero para este medicamento en esta celda
                    if ($dimensiones['ancho'] > $ancho_celda) {
                        $ancho_celda = $dimensiones['ancho'];
                    }

                    // Ajustar el alto del pastillero para este medicamento en esta celda
                    $alto_requerido = $dimensiones['alto'] * min($cantidad, $cantidad_alto);
                    if ($alto_requerido > $alto_celda) {
                        $alto_celda = $alto_requerido;
                    }

                    // Guardar detalles de este medicamento en la celda
                    $medicamentos_celda[] = array(
                        'nombre' => $toma_info->getNombreMedicamento($codigo_medicamento_celda),
                        'cantidad' => $cantidad,
                        'filas_necesarias' => $filas_necesarias
                    );
                }
            }

            // Guardar detalles de esta celda
            if (!empty($medicamentos_celda)) {
                $detalle_medicamentos[] = array(
                    'dia' => $dia,
                    'horario' => $horario,
                    'medicamentos' => $medicamentos_celda
                );
            }

            // Actualizar las dimensiones máximas globales si es necesario
            if ($largo_celda > $max_largo[$horario_idx]) {
                $max_largo[$horario_idx] = $largo_celda;
            }
            if ($ancho_celda > $max_ancho[$dia_idx]) {
                $max_ancho[$dia_idx] = $ancho_celda;
            }
            if ($alto_celda > $max_alto) {
                $max_alto = $alto_celda;
            }
        }
    }


    // Reemplazar 0 con 1 en los arrays
    $max_largo = array_map(function($value) { return $value == 0 ? 1 : $value; }, $max_largo);
    $max_ancho = array_map(function($value) { return $value == 0 ? 1 : $value; }, $max_ancho);

    $suma_largo = (array_sum($max_largo));
    $suma_ancho = (array_sum($max_ancho));

    // Convertir arrays a JSON
        $json_max_largo = json_encode($max_largo);
        $json_max_ancho = json_encode($max_ancho);
        $json_max_alto = json_encode($max_alto);

        // Almacenar en localStorage usando JavaScript
        echo "<script>
                localStorage.setItem('maxLargo', '$json_max_largo');
                localStorage.setItem('maxAncho', '$json_max_ancho');
                localStorage.setItem('maxAlto', '$json_max_alto');
            </script>";
        ?>


   
    
    <h2>Dimensiones totales del pastillero: <?php echo htmlspecialchars($suma_largo); ?> x <?php echo htmlspecialchars($suma_ancho); ?> x <?php echo htmlspecialchars($max_alto) . " cm"; ?></h2>

    <h4><span class="label">Nota:</span> Las dimensiones del pastillero se calculan en función de las dimensiones de las pastillas y la cantidad de pastillas que se deben tomar en cada toma.</h4>


       
     
         
           <div id="detallesCelda" style="display: none;">

           <h2>Largo de la columna por cada horario:</h2>
    <table>
        <tr>
            <th>Horario</th>
            <th>Largo</th>
        </tr>
        <tr>
            <td>Mañana</td>
            <td><?php echo htmlspecialchars($max_largo[0]). " cm"; ?></td>
        </tr>
        <tr>
            <td>Mediodía</td>
            <td><?php echo htmlspecialchars($max_largo[1]). " cm"; ?></td>
        </tr>
        <tr>
            <td>Noche</td>
            <td><?php echo htmlspecialchars($max_largo[2]). " cm"; ?></td>
        </tr>
    </table>

    <h2>Ancho de la columna por cada día:</h2>
    <table>
        <tr>
            <th>Día</th>
            <th>Ancho</th>
        </tr>
        <tr>
            <td>Lunes</td>
            <td><?php echo htmlspecialchars($max_ancho[0]). " cm"; ?></td>
        </tr>
        <tr>
            <td>Martes</td>
            <td><?php echo htmlspecialchars($max_ancho[1]). " cm"; ?></td>
        </tr>
        <tr>
            <td>Miércoles</td>
            <td><?php echo htmlspecialchars($max_ancho[2]). " cm"; ?></td>
        </tr>
        <tr>
            <td>Jueves</td>
            <td><?php echo htmlspecialchars($max_ancho[3]). " cm"; ?></td>
        </tr>
        <tr>
            <td>Viernes</td>
            <td><?php echo htmlspecialchars($max_ancho[4]). " cm"; ?></td>
        </tr>
        <tr>
            <td>Sábado</td>
            <td><?php echo htmlspecialchars($max_ancho[5]). " cm"; ?></td>
        </tr>
        <tr>
            <td>Domingo</td>
            <td><?php echo htmlspecialchars($max_ancho[6]). " cm"; ?></td>
        </tr>
    </table>

    <h2>Alto del pastillero: <?php echo htmlspecialchars($max_alto) . " cm"; ?></h2>

                <h3>Detalles por celda:</h3>
                <?php foreach ($detalle_medicamentos as $detalle): ?>
                    <h3><?php echo htmlspecialchars($detalle['dia']); ?> - <?php echo htmlspecialchars($detalle['horario']); ?></h3>
                    <ul>
                        <?php foreach ($detalle['medicamentos'] as $medicamento): ?>
                            <li>
                                <p><?php echo htmlspecialchars($medicamento['nombre']); ?>: <?php echo htmlspecialchars($medicamento['cantidad']); ?> pastillas, <?php echo htmlspecialchars($medicamento['filas_necesarias']); ?> fila(s)</p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </div>
      
     
         <footer>
          
         </footer>
     </body>
     </html>