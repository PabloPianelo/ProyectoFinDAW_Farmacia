<?php
require 'models/UsuarioModel.php';
require 'models/PacientesModel.php';
require 'models/MedicamentoModel.php';
require 'models/TipoPresentacionModel.php';
require 'models/TratamientoModel.php';
require 'models/TomaTratamientoModel.php';




class TratamientoController
{
 
    protected $view;
    protected $usuarios;
    protected $pacientes;
    protected $medicamento;
    protected $tipo;
    protected $tratamiento;
    protected $toma;


    
    function __construct()
    {
        
        $this->view = new View();
        $this->usuarios = new UsuarioModel();
        $this->pacientes = new PacienteModel();
        $this->medicamento = new MedicamentoModel();
        $this->tratamiento = new TratamientoModel();
        $this->toma = new TomaTratamientoModel();
        $this->tipo = new TipoPresentacionModel();

        

    }


    public function pacientes_lista() {

    
       
        // no se si son necesarios todos pero me da igual 

        $listado_usuario = $this->usuarios->getAll();
        $listado_pacientes = $this->pacientes->getAll();
        $listado_medicamentos = $this->medicamento->getAll();
        $listado_tratamientos = $this->tratamiento->getAll();
        $listado_tomas = $this->toma->getAll();
        $listado_tipos = $this->tipo->getAll();


        $data['tipos'] = $listado_tipos;
        $data['usuarios'] = $listado_usuario;
        $data['pacientes'] = $listado_pacientes;
        $data['medicamentos'] = $listado_medicamentos;
        $data['tratamientos'] = $listado_tratamientos;
        $data['tomas'] = $listado_tomas;




        $this->view->show("UsuarioView.php", $data);
    
    }

    public function ver_tratamientos() {

        // Ver todos los tratamientos en la vista TratamientoView
    
        $id_paciente = $_REQUEST['id_paciente'];
        $tratamientos_paciente = $this->tratamiento->getByPacienteId($id_paciente);
        $paciente_data = $this->pacientes->getById($id_paciente);
        
        $data['pacientes'] = $paciente_data;
        $data['tratamientos'] = $tratamientos_paciente;

        // Mostrar la vista TratamientoView con los tratamientos del paciente específico
        $this->view->show("TratamientoView.php", $data);
    }

    
    public function ver_TomasTratamiento() {

        // Obtener el código de tratamiento desde la solicitud
        $codigo_tratamiento = isset($_REQUEST['codigo_tratamiento']) ? $_REQUEST['codigo_tratamiento'] : null;

            // Verificar si el código de tratamiento está definido
            if ($codigo_tratamiento === null) {
                // Si no está definido, redireccionar o mostrar un mensaje de error
                echo "<script>alert('El código de tratamiento no está definido'); window.location.href = 'index.php?controlador=Tratamiento&accion=pacientes_lista';</script>";
                return;
            }

            // Obtener el paciente asociado al tratamiento
            $tratamiento = $this->tratamiento->getById($codigo_tratamiento);
            $id_paciente = $tratamiento->getIdPaciente();
            $paciente_data = $this->pacientes->getById($id_paciente);

            // Obtener todas las tomas asociadas al tratamiento específico
            $tomas = $this->toma->getByCodigoTratamiento($codigo_tratamiento);

            // Obtener nombres de medicamentos para mostrar en la vista
            $nombres_medicamentos = [];
            foreach ($tomas as $toma) {
                $medicamento = $this->medicamento->getById($toma->getCodigoMedicamento());
                $nombres_medicamentos[$toma->getCodigoMedicamento()] = $medicamento->getNombreProducto();

                
                 
            }

            // Pasar los datos a la vista
            
            $data['medicamentos'] = $nombres_medicamentos;
            $data['tratamiento'] = $tratamiento;
            $data['tomas'] = $tomas;
            $data['paciente'] = $paciente_data;

            // Mostrar la vista de las tomas del tratamiento específico
            $this->view->show("TomasTratamientoView.php", $data);
        }

    // crear tratamiento 

    public function nuevo_tratamiento() {
        $errores = array();
      
        if (isset($_REQUEST['submit'])) {
          // Validar los datos
          if (empty($_REQUEST['fecha_inicio'])) {
            $errores[] = "La fecha de inicio es requerida.";
          }
          // Agregar más validaciones si es necesario...
      
          // Si no hay errores, guardar el tratamiento
          if (empty($errores)) {
            $this->tratamiento->setFechaInicio($_REQUEST['fecha_inicio']);
            $this->tratamiento->setDiasRealizacion($_REQUEST['dias_realizacion']);
            $this->tratamiento->setIdPaciente($_REQUEST['id_paciente']);
            $this->tratamiento->save(); // Save the treatment record and get the ID
            
      
            header("Location: index.php?controlador=Tratamiento&accion=ver_tratamientos&id_paciente=".$_REQUEST['id_paciente']);
            exit; // Es importante detener la ejecución después de redireccionar
          }
        }
      
        // Obtener todos los medicamentos y datos del paciente
        $listado_medicamentos = $this->medicamento->getAll();
        $id_paciente = $_REQUEST['paciente_id'];
        $paciente_data = $this->pacientes->getById($id_paciente);
      
        // Mostrar el formulario de creación de tratamiento
        $data['medicamentos'] = $listado_medicamentos;
        $data['paciente_id'] = $paciente_data;
        $data['errores'] = $errores; // Pasar los errores a la vista, si los hay
        $this->view->show("CRUD/NuevoTratamientoView.php", $data);
      }

      
      public function BorrarTratamiento() {
        // Obtener el ID del paciente y el código del tratamiento desde la solicitud
        $id_paciente = $_REQUEST['id_paciente'];
        $codigo_tratamiento = $_REQUEST['codigo_tratamiento'];
    
        // Obtener detalles del tratamiento por su código
        $tratamiento = $this->tratamiento->getById($codigo_tratamiento);
    
        // Verificar si el tratamiento existe antes de intentar eliminarlo
        if ($tratamiento) {
            // Establecer el código del tratamiento
            $this->tratamiento->setCodigoTratamiento($codigo_tratamiento);
    
            // Borrar las tomas asociadas al tratamiento 
            $this->toma->deleteByCodigoTratamiento($codigo_tratamiento);
    
            // Borrar el tratamiento
            $this->tratamiento->delete();
        }
    
        // Redireccionar al usuario a la página de visualización de tratamientos
        header("Location: index.php?controlador=Tratamiento&accion=ver_tratamientos&id_paciente=$id_paciente");
        exit;
    }

    // Agregar medicamento al tratamiento

    public function agregar_medicamento() {

        $errores = array();
      
        if (isset($_REQUEST['submit'])) {
          
          // Agregar más validaciones si es necesario...
          // Si no hay errores, guardar el tratamiento
          if (empty($errores)) {

            $codigo_tratamiento = $_REQUEST['codigo_tratamiento'];
            // Obtener los días y horas seleccionados
            $dias_toma = isset($_REQUEST['dia_toma']) ? $_REQUEST['dia_toma'] : array();
            $horas_toma = isset($_REQUEST['hora_toma']) ? $_REQUEST['hora_toma'] : array();
            
            // Crear tomas para cada combinación de día y hora seleccionados
            foreach ($dias_toma as $dia) {
                foreach ($horas_toma as $hora) {
                    $toma = new TomaTratamientoModel();
                    $toma->setCodigoTratamiento($codigo_tratamiento);
                    $toma->setDiaToma($dia);
                    $toma->setHoraToma($hora);
                    $toma->setCodigoMedicamento($_REQUEST['medicamentos']);
                    $toma->setCantidad($_REQUEST['cantidad']);
                    $toma->save();
                }
            }
      
            header("Location: index.php?controlador=Tratamiento&accion=ver_TomasTratamiento&codigo_tratamiento=$codigo_tratamiento");
            exit; // Es importante detener la ejecución después de redireccionar
          }
        }
      
        // Obtener todos los medicamentos y datos del tratamiento específico

        $codigo_tratamiento = $_REQUEST['codigo_tratamiento'];
        $listado_medicamentos = $this->medicamento->getAll();


        $tratamiento_data = $this->tratamiento->getById($codigo_tratamiento);
    
      
        // Mostrar el formulario de creación de tratamiento

        $data['tratamiento']= $tratamiento_data; 
        $data['medicamentos'] = $listado_medicamentos;
       
        $data['errores'] = $errores; // Pasar los errores a la vista, si los hay
        $this->view->show("CRUD/NuevaTomaTratamientoView.php", $data);

    }

        public function vaciar_tabla() {
            // Obtener el código de tratamiento desde la solicitud
            $codigo_tratamiento = isset($_REQUEST['codigo_tratamiento']) ? $_REQUEST['codigo_tratamiento'] : null;
        
            // Verificar si el código de tratamiento está definido
            if ($codigo_tratamiento === null) {
                // Si no está definido, redireccionar o mostrar un mensaje de error
                echo "<script>alert('El código de tratamiento no está definido'); window.location.href = 'index.php?controlador=Tratamiento&accion=pacientes_lista';</script>";
                return;
            }
        
            // Borrar todas las tomas asociadas al tratamiento
            $this->toma->deleteByCodigoTratamiento($codigo_tratamiento);
        
            // Redireccionar al usuario a la página de visualización de tomas
            header("Location: index.php?controlador=Tratamiento&accion=ver_TomasTratamiento&codigo_tratamiento=$codigo_tratamiento");
            exit;
        }
}
