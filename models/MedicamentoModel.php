<?php


class MedicamentoModel
{
    // Conexión a la BD
    protected $db;

    
    private $codigo_nacional;
    private $nombre_producto;
    private $laboratorio;
    private $unidades;
    private $estado;
    private $presentacion;

    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    // Getters and Setters
    public function getCodigoNacional()
    {
        return $this->codigo_nacional;
    }

    public function setCodigoNacional($codigo_nacional)
    {
        $this->codigo_nacional = $codigo_nacional;
    }

    public function getNombreProducto()
    {
        return $this->nombre_producto;
    }

    public function setNombreProducto($nombre_producto)
    {
        $this->nombre_producto = $nombre_producto;
    }

    public function getLaboratorio()
    {
        return $this->laboratorio;
    }

    public function setLaboratorio($laboratorio)
    {
        $this->laboratorio = $laboratorio;
    }

    public function getUnidades()
    {
        return $this->unidades;
    }

    public function setUnidades($unidades)
    {
        $this->unidades = $unidades;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getPresentacion()
    {
        return $this->presentacion;
    }

    public function setPresentacion($presentacion)
    {
        $this->presentacion = $presentacion;
    }



    public function getAll()
    {
        //realizamos la consulta de todos los items
        $consulta = $this->db->prepare('SELECT * FROM medicamento');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "MedicamentoModel");

        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }




    
    public function getById($codigo_nacional)
    {
        $gsent = $this->db->prepare('SELECT * FROM medicamento where codigo_nacional = ?');
        $gsent->bindParam(1, $codigo_nacional);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "MedicamentoModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }

     // Método para obtener el nombre de un medicamento // KONRAD NUEVO

     public function getCodigoPresentacion($codigo_medicamento)
     {
         $gsent = $this->db->prepare('SELECT presentacion FROM medicamento WHERE codigo_nacional = ?');
         $gsent->bindParam(1, $codigo_medicamento);
         $gsent->execute();
     
         $resultado = $gsent->fetch(PDO::FETCH_ASSOC); // Usamos FETCH_ASSOC para obtener un array asociativo
     
         if ($resultado) {
             return $resultado['presentacion']; // Devolvemos solo codigo de presentacion
         } else {
             return "Presentacion no encontrada"; // O cualquier otro mensaje de error adecuado
         }
     }

       //get nombre de medicamento segun su codigo nacional 
    // KONRAD

    public function getNombreMedicamento($codigo_medicamento)
    {
        $gsent = $this->db->prepare('SELECT nombre_producto FROM medicamento WHERE codigo_nacional = ?');
        $gsent->bindParam(1, $codigo_medicamento);
        $gsent->execute();
    
        $resultado = $gsent->fetch(PDO::FETCH_ASSOC); // Usamos FETCH_ASSOC para obtener un array asociativo
    
        if ($resultado) {
            return $resultado['nombre_producto']; // Devolvemos solo el nombre del medicamento
        } else {
            return "Nombre no encontrado"; // O cualquier otro mensaje de error adecuado
        }
    }
     

    public function actualizar()
    {
         
        $consulta = $this->db->prepare('UPDATE medicamento SET nombre_producto = ?, laboratorio = ?, unidades = ?, estado = ?, presentacion = ? WHERE codigo_nacional = ?');
        $consulta->bindParam(1, $this->nombre_producto);
        $consulta->bindParam(2, $this->laboratorio);
        $consulta->bindParam(3, $this->unidades);
        $consulta->bindParam(4, $this->estado);
        $consulta->bindParam(5, $this->presentacion);
        $consulta->bindParam(6, $this->codigo_nacional);
        $consulta->execute();
        
    }



    public function insertar(){

        $consultaExiste = $this->db->prepare('SELECT COUNT(*) FROM medicamento WHERE codigo_nacional = ?');
        $consultaExiste->bindParam(1, $this->codigo_nacional);
        $consultaExiste->execute();
        $existe = $consultaExiste->fetchColumn();
    
        // Si el medicamento ya existe, retornar false
        if ($existe) {
            return false;
        }
        $consulta = $this->db->prepare('INSERT INTO medicamento ( codigo_nacional, nombre_producto, laboratorio, unidades, estado, presentacion ) values ( ?,?,?,?,?,?)');

        $consulta->bindParam(1, $this->codigo_nacional);
        $consulta->bindParam(2, $this->nombre_producto);
        $consulta->bindParam(3, $this->laboratorio);
        $consulta->bindParam(4, $this->unidades);
        $consulta->bindParam(5, $this->estado);
        $consulta->bindParam(6, $this->presentacion);
        return  $consulta->execute();
    }

    // Método que elimina el ItemModel de la BD
    public function delete($codigo_nacional)
    {
        $consulta = $this->db->prepare('DELETE FROM tomas_tratamiento WHERE codigo_medicamento =  ?');
        $consulta->bindParam(1, $codigo_nacional);
        $consulta->execute();


        $consulta = $this->db->prepare('DELETE FROM medicamento WHERE codigo_nacional =  ?');
        $consulta->bindParam(1, $codigo_nacional);
        $consulta->execute();
    }

        
    }

?>