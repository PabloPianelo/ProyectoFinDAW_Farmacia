<?php

// Clase del modelo para trabajar con objetos Paciente que se almacenan en BD en la tabla pacientes
class PacienteModel
{
    // Conexión a la BD
    protected $db;

    // Atributos del objeto paciente que coinciden con los campos de la tabla pacientes
    private $id_paciente;
    private $DNI;
    private $nombre;
    private $apellidos;
    private $fecha_nacimiento;
    private $telefono_fijo;
    private $telefono_movil;
    private $correo_electronico;

    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        // Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    public function getIdPaciente()
    {
        return $this->id_paciente;
    }

    public function setIdPaciente($id_paciente)
    {
        $this->id_paciente = $id_paciente;
    }

    public function getDNI()
    {
        return $this->DNI;
    }

    public function setDNI($DNI)
    {
        $this->DNI = $DNI;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function getFechaNacimiento()
    {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento($fecha_nacimiento)
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function getTelefonoFijo()
    {
        return $this->telefono_fijo;
    }

    public function setTelefonoFijo($telefono_fijo)
    {
        $this->telefono_fijo = $telefono_fijo;
    }

    public function getTelefonoMovil()
    {
        return $this->telefono_movil;
    }

    public function setTelefonoMovil($telefono_movil)
    {
        $this->telefono_movil = $telefono_movil;
    }

    public function getCorreoElectronico()
    {
        return $this->correo_electronico;
    }

    public function setCorreoElectronico($correo_electronico)
    {
        $this->correo_electronico = $correo_electronico;
    }

    // Método para obtener todos los registros de la tabla pacientes
    // Devuelve un array de objetos de la clase PacienteModel
    public function getAll()
    {
        // Realizamos la consulta de todos los pacientes
        $consulta = $this->db->prepare('SELECT * FROM pacientes');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "PacienteModel");

        // Devolvemos la colección para que la vista la presente.
        return $resultado;
    }

    // Método que devuelve (si existe en BD) un objeto PacienteModel con un ID determinado
    public function getById($id_paciente)
    {
        $gsent = $this->db->prepare('SELECT * FROM pacientes where id_paciente = ?');
        $gsent->bindParam(1, $id_paciente);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "PacienteModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }

    

    





    public function save() {
        $consulta_verificacion = $this->db->prepare('SELECT id_paciente FROM pacientes WHERE DNI = ?');
        $consulta_verificacion->bindParam(1, $this->DNI);
        $consulta_verificacion->execute();
        $resultado = $consulta_verificacion->fetch(PDO::FETCH_ASSOC);
    
        
    
        if (!isset($this->id_paciente)) {
            $consulta = $this->db->prepare('INSERT INTO pacientes (DNI, nombre, apellidos, fecha_nacimiento, telefono_fijo, telefono_movil, correo_electronico) VALUES (?, ?, ?, ?, ?, ?, ?)');
        
            if ($resultado) {
                // Lanzar una excepción o devolver un mensaje de error en lugar de un echo
                throw new Exception('Ya existe un paciente con este DNI');
            }
        
        
        } else {
            $consulta = $this->db->prepare('UPDATE pacientes SET DNI = ?, nombre = ?, apellidos = ?, fecha_nacimiento = ?, telefono_fijo = ?, telefono_movil = ?, correo_electronico = ? WHERE id_paciente = ?');
            $consulta->bindParam(8, $this->id_paciente);
        }
        
        $consulta->bindParam(1, $this->DNI);
        $consulta->bindParam(2, $this->nombre);
        $consulta->bindParam(3, $this->apellidos);
        $consulta->bindParam(4, $this->fecha_nacimiento);
        $consulta->bindParam(5, $this->telefono_fijo);
        $consulta->bindParam(6, $this->telefono_movil);
        $consulta->bindParam(7, $this->correo_electronico);
        $consulta->execute();
    }

    // Método que elimina el PacienteModel de la BD
    public function delete($id_paciente)
    {

        $consulta_select = $this->db->prepare('SELECT codigo_tratamiento FROM tratamiento WHERE id_paciente = ?');
        $consulta_select->bindParam(1, $id_paciente);
        $consulta_select->execute();
        
        $resultados = $consulta_select->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($resultados as $resultado) {
            $codigo_tratamiento = $resultado['codigo_tratamiento'];
        
            $consulta_delete = $this->db->prepare('DELETE FROM tomas_tratamiento WHERE codigo_tratamiento = ?');
            $consulta_delete->bindParam(1, $codigo_tratamiento);
            $consulta_delete->execute();
        }


        $consulta = $this->db->prepare('DELETE FROM tratamiento WHERE id_paciente = ?');
        $consulta->bindParam(1, $id_paciente);
        $consulta->execute();
        


        $consulta = $this->db->prepare('DELETE FROM pacientes WHERE id_paciente = ?');
        $consulta->bindParam(1, $id_paciente);
        $consulta->execute();
    }
}