<?php
require 'models/UsuarioModel.php';
require 'models/PacientesModel.php';
require 'models/MedicamentoModel.php';
require 'models/TipoPresentacionModel.php';




class TipoPresentacionController
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



    public function presentacion_lista(){
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



        $this->view->show("PresentacionListarView.php", $data);
     


    }


   


    public function editar_presentacion(){
        
       
        
        if (isset($_REQUEST['submit'])) {
           
                $tipoToUpdate = $this->tipo->getById($_REQUEST['tipo_id']);
                $tipoToUpdate->setLargo($_REQUEST['largo']);
                $tipoToUpdate->setAncho($_REQUEST['ancho']);
                $tipoToUpdate->setAlto($_REQUEST['alto']);
                $tipoToUpdate->setCantidadAlto($_REQUEST['cantidadAlto']);
                $tipoToUpdate->setNombre($_REQUEST['nombre']);

                $tipoToUpdate->save();
                header("Location: index.php?controlador=TipoPresentacion&accion=presentacion_lista");
           
        } else {
            

            $tipoToEdit = $this->tipo->getById($_GET['tipo_id']);

            $data['tipo'] = $tipoToEdit;
            if ($tipoToEdit != false)
                $this->view->show("CRUD/EditarTipoView.php", $data);
            else
                $this->view->show("errorView.php", array("error" => "No existe codigo", "enlace" => "index.php?controlador=Medicamento&accion=medicamento_lista"));
        }


     


    }





    public function nueva_presentacion(){
        if (isset($_REQUEST['submit'])) {
            $this->tipo->setNombre($_REQUEST['nombre']);
            $this->tipo->setLargo($_REQUEST['largo']);
            $this->tipo->setAncho($_REQUEST['ancho']);
            $this->tipo->setAlto($_REQUEST['alto']);
            $this->tipo->setCantidadAlto($_REQUEST['cantidadAlto']);
            $this->tipo->save();
                header("Location: index.php?controlador=TipoPresentacion&accion=presentacion_lista");
            //}
        }
        // $listausuario = $this->usuario->getAll();
        // $data['usuarios'] = $listausuario;
        $this->view->show("CRUD/NuevoTipoView.php");


    }

    public function borrar_presentacion(){

        if (isset($_REQUEST['tipo_id'])) {
           $this->tipo->delete($_REQUEST['tipo_id']);
           header("Location: index.php?controlador=TipoPresentacion&accion=presentacion_lista");
        }
}
   


}

?>