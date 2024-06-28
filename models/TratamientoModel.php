<?php

// Clase del modelo para trabajar con objetos Tratamiento que se almacenan en BD en la tabla tratamiento
class TratamientoModel
{
    // Conexión a la BD
    protected $db;

    // Atributos del objeto tratamiento que coinciden con los campos de la tabla tratamiento
    private $codigo_tratamiento;
    private $id_paciente;
    private $fecha_inicio;
    private $dias_realizacion;
    
    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        // Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    public function getCodigoTratamiento()
    {
        return $this->codigo_tratamiento;
    }
    public function setCodigoTratamiento($codigo_tratamiento)
    {
        return $this->codigo_tratamiento = $codigo_tratamiento;
    }

    public function getIdPaciente()
    {
        return $this->id_paciente;
    }
    public function setIdPaciente($id_paciente)
    {
        return $this->id_paciente = $id_paciente;
    }

    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }
    public function setFechaInicio($fecha_inicio)
    {
        return $this->fecha_inicio = $fecha_inicio;
    }

    public function getDiasRealizacion()
    {
        return $this->dias_realizacion;
    }
    public function setDiasRealizacion($dias_realizacion)
    {
        return $this->dias_realizacion = $dias_realizacion;
    }

    
    public function getAll()
    {
        $consulta = $this->db->prepare('SELECT * FROM tratamiento');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "TratamientoModel");

        return $resultado;
    }

    public function getById($codigo)
    {
        $gsent = $this->db->prepare('SELECT * FROM tratamiento where codigo_tratamiento = ?');
        $gsent->bindParam(1, $codigo);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "TratamientoModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }
      

 // Método para obtener todos los tratamientos asociados a un paciente
 // KONRAD

 public function getByPacienteId($id_paciente) {

     $gsent = $this->db->prepare('SELECT * FROM tratamiento where id_paciente = ?');
     $gsent->bindParam(1, $id_paciente);
     $gsent->execute();

     $gsent->setFetchMode(PDO::FETCH_CLASS, "TratamientoModel");
     $resultado = $gsent->fetchAll();

     return $resultado;
 }

 // Método para obtener el último código de tratamiento insertado en la BD
 // KONRAD

 public function getUltimoCodigoInsertado()
 {
     $consulta = $this->db->prepare('SELECT MAX(codigo_tratamiento) FROM tratamiento');
     $consulta->execute();
     $resultado = $consulta->fetchColumn();

     return $resultado;
 }
    public function save()
    {
        if (!isset($this->codigo_tratamiento)) {
            $consulta = $this->db->prepare('INSERT INTO tratamiento (id_paciente, fecha_inicio, dias_realizacion) VALUES (?, ?, ?)');
            $consulta->bindParam(1, $this->id_paciente);
            $consulta->bindParam(2, $this->fecha_inicio);
            $consulta->bindParam(3, $this->dias_realizacion);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE tratamiento SET id_paciente = ?, fecha_inicio = ?, dias_realizacion = ? WHERE codigo_tratamiento = ?');
            $consulta->bindParam(1, $this->id_paciente);
            $consulta->bindParam(2, $this->fecha_inicio);
            $consulta->bindParam(3, $this->dias_realizacion);
            $consulta->bindParam(4, $this->codigo_tratamiento);
            $consulta->execute();
        }
    }

    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM tratamiento WHERE codigo_tratamiento = ?');
        $consulta->bindParam(1, $this->codigo_tratamiento);
        $consulta->execute();
    }
}
?>
