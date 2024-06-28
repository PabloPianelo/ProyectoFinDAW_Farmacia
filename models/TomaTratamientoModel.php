<?php

// Clase del modelo para trabajar con objetos TomaTratamiento que se almacenan en BD en la tabla tomas_tratamiento
class TomaTratamientoModel
{
    // Conexión a la BD
    protected $db;

    // Atributos del objeto toma_tratamiento que coinciden con los campos de la tabla tomas_tratamiento
    private $codigo_toma;
    private $codigo_tratamiento;
    private $dia_toma;
    private $hora_toma;
    private $codigo_medicamento;
    private $cantidad;
    
    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        // Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    public function getCodigoToma()
    {
        return $this->codigo_toma;
    }
    public function setCodigoToma($codigo_toma)
    {
        return $this->codigo_toma = $codigo_toma;
    }

    public function getCodigoTratamiento()
    {
        return $this->codigo_tratamiento;
    }
    public function setCodigoTratamiento($codigo_tratamiento)
    {
        return $this->codigo_tratamiento = $codigo_tratamiento;
    }

    public function getDiaToma()
    {
        return $this->dia_toma;
    }
    public function setDiaToma($dia_toma)
    {
        return $this->dia_toma = $dia_toma;
    }

    public function getHoraToma()
    {
        return $this->hora_toma;
    }
    public function setHoraToma($hora_toma)
    {
        return $this->hora_toma = $hora_toma;
    }

    public function getCodigoMedicamento()
    {
        return $this->codigo_medicamento;
    }
    public function setCodigoMedicamento($codigo_medicamento)
    {
        return $this->codigo_medicamento = $codigo_medicamento;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }
    public function setCantidad($cantidad)
    {
        return $this->cantidad = $cantidad;
    }

    // Método para obtener todos los registros de la tabla tomas_tratamiento
    // Devuelve un array de objetos de la clase TomaTratamientoModel

    public function getAll()
    {
        // Realizamos la consulta de todas las tomas de tratamiento
        $consulta = $this->db->prepare('SELECT * FROM tomas_tratamiento');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "TomaTratamientoModel");

        // Devolvemos la colección para que la vista la presente.
        return $resultado;
    }

    // Método que devuelve (si existe en BD) un objeto TomaTratamientoModel con un código determinado

    public function getById($codigo)
    {
        $gsent = $this->db->prepare('SELECT * FROM tomas_tratamiento WHERE codigo_toma = ?');
        $gsent->bindParam(1, $codigo);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "TomaTratamientoModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }

    // Método que devuelve todas las tomas de tratamiento asociadas a un código de tratamiento
    // KONRAD

    public function getByCodigoTratamiento($codigo_tratamiento)
    {
        $gsent = $this->db->prepare('SELECT * FROM tomas_tratamiento WHERE codigo_tratamiento = ?');
        $gsent->bindParam(1, $codigo_tratamiento);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "TomaTratamientoModel");
        $resultado = $gsent->fetchAll();

        return $resultado;
    }

    
    // Método para obtener el nombre de un medicamento
     public function getNombreMedicamento($codigo_medicamento)
     {
        $medicamentoModel = new MedicamentoModel();
        return $medicamentoModel->getNombreMedicamento($codigo_medicamento);

     }

      // Método para obtener las dimensiones del medicamento
      public function getDimensionesMedicamento($codigo_presentacion)
      {
          $tipoPresentacionModel = new TipoPresentacionModel();
          return $tipoPresentacionModel->getDimensionesMedicamento($codigo_presentacion);
      }

        // Método para obtener el código de presentación de un medicamento
      public function getCodigoPresentacion($codigo_medicamento) 
      { 
        $medicamentoModel = new MedicamentoModel();
        return $medicamentoModel->getCodigoPresentacion($codigo_medicamento);
      }
  

    public function save()
    {
        if (!isset($this->codigo_toma)) {
            $consulta = $this->db->prepare('INSERT INTO tomas_tratamiento (codigo_tratamiento, dia_toma, hora_toma, codigo_medicamento, cantidad) VALUES (?, ?, ?, ?, ?)');
            $consulta->bindParam(1, $this->codigo_tratamiento);
            $consulta->bindParam(2, $this->dia_toma);
            $consulta->bindParam(3, $this->hora_toma);
            $consulta->bindParam(4, $this->codigo_medicamento);
            $consulta->bindParam(5, $this->cantidad);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE tomas_tratamiento SET codigo_tratamiento = ?, dia_toma = ?, hora_toma = ?, codigo_medicamento = ?, cantidad = ? WHERE codigo_toma = ?');
            $consulta->bindParam(1, $this->codigo_tratamiento);
            $consulta->bindParam(2, $this->dia_toma);
            $consulta->bindParam(3, $this->hora_toma);
            $consulta->bindParam(4, $this->codigo_medicamento);
            $consulta->bindParam(5, $this->cantidad);
            $consulta->bindParam(6, $this->codigo_toma);
            $consulta->execute();
        }
    }

    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM tomas_tratamiento WHERE codigo_toma = ?');
        $consulta->bindParam(1, $this->codigo_toma);
        $consulta->execute();
    }

    // KONRAD
    public function deleteByCodigoTratamiento($codigo_tratamiento)
    {
        $consulta = $this->db->prepare('DELETE FROM tomas_tratamiento WHERE codigo_tratamiento = ?');
        $consulta->bindParam(1, $codigo_tratamiento);
        $consulta->execute();
    }


}
?>
