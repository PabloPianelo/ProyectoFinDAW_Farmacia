<?php

// Clase del modelo para trabajar con objetos TipoPresentacion que se almacenan en BD en la tabla tipo_presentacion
class TipoPresentacionModel
{
    // Conexión a la BD
    protected $db;

    // Atributos del objeto TipoPresentacion que coinciden con los campos de la tabla tipo_presentacion
    private $codigo;
    private $largo;
    private $ancho;
    private $alto;
    private $cantidad_alto;
    private $nombre;

    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        // Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function getLargo()
    {
        return $this->largo;
    }

    public function setLargo($largo)
    {
        $this->largo = $largo;
    }

    public function getAncho()
    {
        return $this->ancho;
    }

    public function setAncho($ancho)
    {
        $this->ancho = $ancho;
    }

    public function getAlto()
    {
        return $this->alto;
    }

    public function setAlto($alto)
    {
        $this->alto = $alto;
    }

    public function getCantidadAlto()
    {
        return $this->cantidad_alto;
    }

    public function setCantidadAlto($cantidad_alto)
    {
        $this->cantidad_alto = $cantidad_alto;
    }

    
    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    // Método para obtener todos los registros de la tabla tipo_presentacion
    // Devuelve un array de objetos de la clase TipoPresentacionModel
    public function getAll()
    {
        // Realizamos la consulta de todos los tipos de presentacion
        $consulta = $this->db->prepare('SELECT * FROM tipo_presentacion');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "TipoPresentacionModel");

        // Devolvemos la colección para que la vista la presente.
        return $resultado;
    }

    // Método que devuelve (si existe en BD) un objeto TipoPresentacionModel con un código determinado
    public function getById($codigo)
    {
        $gsent = $this->db->prepare('SELECT * FROM tipo_presentacion where codigo = ?');
        $gsent->bindParam(1, $codigo);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "TipoPresentacionModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }


    public function getBytipo()
    {
        $gsent = $this->db->prepare('SELECT codigo FROM tipo_presentacion where largo = ? and ancho = ? and cantidad_alto = ?');
        $gsent->bindParam(1, $this->largo);
        $gsent->bindParam(2, $this->ancho);
        $gsent->bindParam(3, $this->cantidad_alto);

        $gsent->execute();

    
        $resultado = $gsent->fetch();

        return $resultado;
    }

     // Método para obtener las dimensiones de un medicamento // KONRAD NUEVO

     public function getDimensionesMedicamento($codigo_nacional)
     {
            $gsent = $this->db->prepare('SELECT largo, ancho, alto, cantidad_alto FROM tipo_presentacion WHERE codigo = ?');
            $gsent->bindParam(1, $codigo_nacional);
            $gsent->execute();
        
            $resultado = $gsent->fetch(PDO::FETCH_ASSOC); // Usamos FETCH_ASSOC para obtener un array asociativo
        
            if ($resultado) {
                return $resultado; // Devolvemos las dimensiones del medicamento
            } else {
                return "Dimensiones no encontradas"; // O cualquier otro mensaje de error adecuado
            }

     }


     public function getidforNombre($nombre)
     {
            $gsent = $this->db->prepare('SELECT codigo FROM tipo_presentacion WHERE nombre = ?');
            $gsent->bindParam(1, $nombre);
            $gsent->execute();
        
            $resultado = $gsent->fetch(PDO::FETCH_ASSOC); // Usamos FETCH_ASSOC para obtener un array asociativo
        
            if ($resultado) {
                return $resultado['codigo']; // Devolvemos las dimensiones del medicamento
            } else {
                return false; // O cualquier otro mensaje de error adecuado
            }

     }
       


    // Método que almacena en BD un objeto TipoPresentacionModel
    // Si tiene ya un código actualiza el registro y si no tiene lo inserta
    public function save()
    {
        if (!isset($this->codigo)) {
            $consulta = $this->db->prepare('INSERT INTO tipo_presentacion (largo, ancho, cantidad_alto,nombre,alto) VALUES ( ?, ?, ?,?,?)');
            $consulta->bindParam(1, $this->largo);
            $consulta->bindParam(2, $this->ancho);
            $consulta->bindParam(3, $this->cantidad_alto);
            $consulta->bindParam(4, $this->nombre);
            $consulta->bindParam(5, $this->alto);


            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE tipo_presentacion SET largo = ?, ancho = ?, cantidad_alto = ?, nombre = ?, alto = ? WHERE codigo = ?');
            $consulta->bindParam(1, $this->largo);
            $consulta->bindParam(2, $this->ancho);
            $consulta->bindParam(3, $this->cantidad_alto);
            $consulta->bindParam(4, $this->nombre);
            $consulta->bindParam(5, $this->alto);
            $consulta->bindParam(6, $this->codigo);

            $consulta->execute();
        }
    }

    // Método que elimina el TipoPresentacionModel de la BD
    public function delete($codigo)
    {
            //hazer una  presentacion que no se pueda borra llamado nulo
        $consulta = $this->db->prepare('DELETE FROM medicamento WHERE presentacion  =  ?');
        $consulta->bindParam(1, $codigo);
        $consulta->execute();
        $consulta = $this->db->prepare('DELETE FROM tipo_presentacion WHERE codigo = ?');
        $consulta->bindParam(1, $codigo);
        $consulta->execute();
    }
}
