<?php
require 'models/UsuarioModel.php';
require 'models/PacientesModel.php';
require 'models/MedicamentoModel.php';
require 'models/TipoPresentacionModel.php';




class UsuarioController
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


    public function cifrar_contrasena($contraseña){

        $password_encrypt = sha1($contraseña);
        return $password_encrypt;
    }


    public function editar_usuario(){
        
       
        
        if (isset($_REQUEST['submit'])) {
           
                $usuarioToUpdate = $this->usuarios->getById($_REQUEST['usuario_id']);
                $usuarioToUpdate->setUsuario($_REQUEST['usuario']);
                $cifrado = $this->cifrar_contrasena($_REQUEST['contraseña']);
                $usuarioToUpdate->setContraseña($cifrado );
                $usuarioToUpdate->setPerfil("dependiente");
                $usuarioToUpdate->save();
                header("Location: index.php?controlador=Admin&accion=admin_lista");
           
        } else {
            

            $usuarioToEdit = $this->usuarios->getById($_GET['usuario_id']);

            $data['usuario'] = $usuarioToEdit;
            if ($usuarioToEdit != false)
                $this->view->show("CRUD/EditarUsuariosView.php", $data);
            else
                $this->view->show("errorView.php", array("error" => "No existe codigo", "enlace" => "index.php?controlador=Admin&accion=admin_lista"));
        }


     


    }





    public function nuevo_usuario(){
        // $errores = array();
        if (isset($_REQUEST['submit'])) {
            // if (!isset($_REQUEST['equipo']) || empty($_REQUEST['equipo']))
            //     $errores['equipo'] = "* Equipo: Hay que indicar un nombre de equipo";
            // if (empty($errores)) {
                $this->usuarios->setUsuario($_REQUEST['usuario']);
                $cifrado = $this->cifrar_contrasena($_REQUEST['contraseña']);
                $this->usuarios->setContraseña($cifrado);
                $this->usuarios->setPerfil("dependiente");
                $this->usuarios->save();
                header("Location: index.php?controlador=Admin&accion=admin_lista");
            //}
        }
        // $listausuario = $this->usuario->getAll();
        // $data['usuarios'] = $listausuario;
        $this->view->show("CRUD/NuevoUsuarioView.php");


    }

   
    public function borrar_usuario(){

            if (isset($_REQUEST['usuario_id'])) {
               $this->usuarios->delete($_REQUEST['usuario_id']);
               header("Location: index.php?controlador=Admin&accion=admin_lista");
            }
    }


}

?>