<?php
require 'models/UsuarioModel.php';


class LoginController
{
 
    protected $view;
    protected $usuario;


    
    function __construct()
    {
        
        $this->view = new View();
        $this->usuario = new UsuarioModel();
        

    }


    public function login(){

        $errores = array();


        if (isset($_REQUEST['Login'])) {
            if (!isset($_REQUEST['username']) || empty($_REQUEST['username']))
            $errores['username'] = "* Usuario: Error";
        if (!isset($_REQUEST['password']) || empty($_REQUEST['password']))
            $errores['password'] = "* Contraseña: Error";
            if (empty($errores)) {


                $user = $_REQUEST['username'];
                $password = $_REQUEST['password'];


                $resultado = $this->usuario->ComprobarUser_Password($user, $password);
               
                if ($resultado) {

                        $user=$this->usuario->getByNombre($user);

                           

                           if ($user->getPerfil()=="administrador") {
                            session_start();
                            $_SESSION['usuario_admin']="admin";

                                header("Location: index.php?controlador=Admin&accion=admin_lista");
                            exit();

                           } else {
                           
                            session_start();
                            $_SESSION['usuario'] = "usuario";
                           
                            header("Location: index.php?controlador=Tratamiento&accion=pacientes_lista");
                            exit();

                            //  header("Location: index.php?controlador=Fichar&accion=fichar);
                            //  exit();
                            
                           }
                       
                      
                   

                    
                }else{
                   
                    echo '<script type="text/javascript">
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "ERROR!",
                            text: "Usuario o contraseña incorrectos!",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    });
                </script>';
                  //  echo "<script>alert('Usuario o contraseña incorrectos');</script>";


                }

            }

        }

        $this->view->show("LoginView.php", array('errores' => $errores));

    }

   

    
    public function logout()
    {
        session_start();
        session_unset(); // Elimina todas las variables de sesión
        session_destroy(); // Destruye la sesión
        header("Location: index.php"); // Redirige al usuario a la página principal
        exit();
    }



}

?>