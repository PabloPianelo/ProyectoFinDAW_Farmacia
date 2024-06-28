<?php
require 'models/UsuarioModel.php';
require 'models/PacientesModel.php';
require 'models/MedicamentoModel.php';
require 'models/TipoPresentacionModel.php';




class PacienteController
{
 
    protected $view;
    protected $usuarios;
    protected $pacientes;
    protected $medicamento;
    protected $tipo;


    
    function __construct()
    {
        
        $this->view = new View();
        $this->usuarios = new UsuarioModel();
        $this->pacientes = new PacienteModel();
        $this->medicamento = new MedicamentoModel();
        $this->tipo = new TipoPresentacionModel();

        

    }


    
    public function paciente_lista(){
        session_start();
        if (isset($_GET["usuario_admin"])) {
        $_SESSION['usuario_admin']="admin";
      }
       


        $listado_usuario = $this->usuarios->getAll();
        $listado_pacientes = $this->pacientes->getAll();
        $listado_medicamentos = $this->medicamento->getAll();
        $listado_tipos = $this->tipo->getAll();



        $data['usuarios'] = $listado_usuario;
        $data['pacientes'] = $listado_pacientes;
        $data['medicamentos'] = $listado_medicamentos;
        $data['tipos'] = $listado_tipos;



        $this->view->show("PacienteListarView.php", $data);
     


    }




    public function editar_paciente() {
        if (isset($_REQUEST['submit'])) {
            $pacienteToUpdate = $this->pacientes->getById($_REQUEST['paciente_id']);
            if ($pacienteToUpdate) {
                // Actualizar datos del paciente
                $pacienteToUpdate->setDNI($_REQUEST['DNI']);
                $pacienteToUpdate->setNombre($_REQUEST['nombre']);
                $pacienteToUpdate->setApellidos($_REQUEST['apellidos']);
                $pacienteToUpdate->setFechaNacimiento($_REQUEST['fecha_nacimiento']);
                $pacienteToUpdate->setTelefonoFijo($_REQUEST['telefono_fijo']);
                $pacienteToUpdate->setTelefonoMovil($_REQUEST['telefono_movil']);
                $pacienteToUpdate->setCorreoElectronico($_REQUEST['correo_electronico']);
                $pacienteToUpdate->save();
                // Redirigir después de la actualización
                header("Location: index.php?controlador=Paciente&accion=paciente_lista");
                exit(); // Detener la ejecución del script
            } else {
                $this->view->show("errorView.php", array("error" => "No existe paciente con ese código", "enlace" => "index.php?controlador=Paciente&accion=paciente_lista"));
            }
        } else {
            // Mostrar formulario de edición
            $pacienteToEdit = $this->pacientes->getById($_GET['paciente_id']);
            if ($pacienteToEdit) {
                $data['paciente'] = $pacienteToEdit;
                $this->view->show("CRUD/EditarPacienteView.php", $data);
            } else {
                $this->view->show("errorView.php", array("error" => "No existe paciente con ese código", "enlace" => "index.php?controlador=Paciente&accion=paciente_lista"));
            }
        }
    }
    



    public function nuevo_paciente(){
        if (isset($_REQUEST['submit'])) {
            $nuevopaciente = new PacienteModel();
            $nuevopaciente->setDNI($_REQUEST['DNI']);
            $nuevopaciente->setNombre($_REQUEST['nombre']);
            $nuevopaciente->setApellidos($_REQUEST['apellidos']);
            $nuevopaciente->setFechaNacimiento($_REQUEST['fecha_nacimiento']);
            $nuevopaciente->setTelefonoFijo($_REQUEST['telefono_fijo']);
            $nuevopaciente->setTelefonoMovil($_REQUEST['telefono_movil']);
            $nuevopaciente->setCorreoElectronico($_REQUEST['correo_electronico']);
            $nuevopaciente->save();
            header("Location: index.php?controlador=Paciente&accion=paciente_lista");
        }
        $this->view->show("CRUD/NuevoPacienteView.php");
    }




    public function borrar_paciente(){

        if (isset($_REQUEST['paciente_id'])) {
           $this->pacientes->delete($_REQUEST['paciente_id']);
           header("Location: index.php?controlador=Paciente&accion=paciente_lista");
        }
}





}

?>