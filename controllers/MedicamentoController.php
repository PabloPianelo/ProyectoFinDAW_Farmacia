<?php
require 'models/UsuarioModel.php';
require 'models/PacientesModel.php';
require 'models/MedicamentoModel.php';
require 'models/TipoPresentacionModel.php';




class MedicamentoController
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

    public function medicamento_lista(){
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



        $this->view->show("MedicamentoListarView.php", $data);
     


    }

    

    
   
   
    public function editar_medicamento(){
        if (isset($_REQUEST['submit'])) {
            $medicamentoToUpdate=$this->medicamento->getById($_REQUEST['medicamento_id']);
            $medicamentoToUpdate->setNombreProducto($_REQUEST['nombre_producto']);
            $medicamentoToUpdate->setLaboratorio($_REQUEST['laboratorio']);
            $medicamentoToUpdate->setUnidades($_REQUEST['unidades']);
            $medicamentoToUpdate->setEstado($_REQUEST['estado']);
            $medicamentoToUpdate->setPresentacion($_REQUEST['tipo']);
            $medicamentoToUpdate->actualizar();
            header("Location: index.php?controlador=Medicamento&accion=medicamento_lista");
        } else {
            $tipo= $this->tipo->getAll(); 
            $medicamentoToEdit = $this->medicamento->getById($_GET['medicamento_id']);
            if ($medicamentoToEdit) {
                $data['tipos'] = $tipo;
                $data['medicamento'] = $medicamentoToEdit;
                $this->view->show("CRUD/EditarMedicamentoView.php", $data);
            } else {
                $this->view->show("errorView.php", array("error" => "No existe código", "enlace" => "index.php?controlador=Medicamento&accion=medicamento_lista"));
            }
        }
    }


    public function nuevo_medicamento(){
        if (isset($_REQUEST['submit'])) {
            
                

               $this->medicamento->setCodigoNacional($_REQUEST['codigo']);
               $this->medicamento->setNombreProducto($_REQUEST['nombre_producto']);
               $this->medicamento->setLaboratorio($_REQUEST['laboratorio']);
               $this->medicamento->setUnidades($_REQUEST['unidades']);
               $this->medicamento->setEstado($_REQUEST['estado']);
               $this->medicamento->setPresentacion($_REQUEST['tipo']);
               $this->medicamento->insertar();
                header("Location: index.php?controlador=Medicamento&accion=medicamento_lista");
            
        }
       $tipo= $this->tipo->getAll();

       $data["tipos"]=$tipo;

        $this->view->show("CRUD/NuevoMedicamentoView.php",$data);


    }

    
    public function borrar_medicamento(){

        if (isset($_REQUEST['medicamento_id'])) {
           $this->medicamento->delete($_REQUEST['medicamento_id']);
           header("Location: index.php?controlador=Medicamento&accion=medicamento_lista");
        }
}

}

?>