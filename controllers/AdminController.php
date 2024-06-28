<?php
require 'models/UsuarioModel.php';
require 'models/PacientesModel.php';
require 'models/MedicamentoModel.php';
require 'models/TipoPresentacionModel.php';




class AdminController
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


    

    public function admin_lista(){
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



        $this->view->show("AdminView.php", $data);
     


    }


   
   


    public function insertar_Excel() {
        session_start(); // Iniciar la sesión si aún no está iniciada
    
        if (isset($_FILES['fileMedicamenstos']) && $_FILES['fileMedicamenstos']['error'] === UPLOAD_ERR_OK) {
            $fileContacts = $_FILES['fileMedicamenstos'];
            $fileTmpPath = $fileContacts['tmp_name'];
            $fileType = mime_content_type($fileTmpPath);
            $fileExtension = pathinfo($fileContacts['name'], PATHINFO_EXTENSION);
    
            // $allowedMimes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            $allowedExtensions = ['csv'];
    
            if ( in_array($fileExtension, $allowedExtensions)) {
                $fileContacts = file_get_contents($fileTmpPath);
                $fileContacts = explode("\n", $fileContacts);
                $fileContacts = array_filter($fileContacts);
                $fileContacts = array_filter($fileContacts, function($line) {
                    return trim($line) !== '';
                });
                foreach ($fileContacts as $contact) {
                    $contactData = explode(";", $contact);
    
                    if (count($contactData) >= 5) {
                        $codigoNacional = $contactData[0];
                        $nombreProducto = $contactData[1];
                        $laboratorio = $contactData[2];
                        $unidades = $contactData[3];
                        $presentacion = trim($contactData[4]);
    
                        $this->medicamento->setCodigoNacional($codigoNacional);
                        $this->medicamento->setNombreProducto($nombreProducto);
                        $this->medicamento->setLaboratorio($laboratorio);
                        $this->medicamento->setUnidades($unidades);
                        $this->medicamento->setEstado("activo");
                       $presentacionID= $this->tipo->getidforNombre($presentacion);
                       if ($presentacionID==false) {
                        $_SESSION['mensaje'] = [
                            'tipo' => 'error',
                            'titulo' => 'ERROR!',
                            'texto' => 'No existe esta presentación.'
                        ];
                        header("Location: index.php?controlador=Medicamento&accion=medicamento_lista");
                        exit();
                       }else{
                        $this->medicamento->setPresentacion($presentacionID);
                       }
                        if (!$this->medicamento->insertar()) {
                            $_SESSION['mensaje'] = [
                                'tipo' => 'error',
                                'titulo' => 'ERROR!',
                                'texto' => 'Ya existen los datos.'
                            ];
                            header("Location: index.php?controlador=Medicamento&accion=medicamento_lista");
                            exit();
                        }
                    } else {
                        $_SESSION['mensaje'] = [
                            'tipo' => 'error',
                            'titulo' => 'ERROR!',
                            'texto' => 'El archivo contiene filas con datos incompletos.'
                        ];
                        header("Location: index.php?controlador=Medicamento&accion=medicamento_lista");
                        exit();
                    }
                }
    
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'titulo' => 'CORRECTO!',
                    'texto' => 'DATOS INSERTADOS'
                ];
                header("Location: index.php?controlador=Medicamento&accion=medicamento_lista");
                exit();
    
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'titulo' => 'ERROR!',
                    'texto' => 'El archivo no es un Excel válido. Solo se permiten archivos .csv.'
                ];
                header("Location: index.php?controlador=Medicamento&accion=medicamento_lista");
                exit();
            }
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'titulo' => 'ERROR!',
                'texto' => 'No has insertado ningún archivo o ha ocurrido un error durante la carga.'
            ];
            header("Location: index.php?controlador=Medicamento&accion=medicamento_lista");
            exit();
        }
    }
    

}

?>