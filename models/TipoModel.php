<?php

// Clase del modelo para trabajar con objetos TipoPresentacion que se almacenan en BD en la tabla tipo_presentacion
class TipoModel
{
    // Conexión a la BD
    protected $db;

    // Atributos del objeto TipoPresentacion que coinciden con los campos de la tabla tipo_presentacion
    private $codigo;
    private $largo;
    private $ancho;
    private $cantidad_alto;

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

    public function getCantidadAlto()
    {
        return $this->cantidad_alto;
    }

    public function setCantidadAlto($cantidad_alto)
    {
        $this->cantidad_alto = $cantidad_alto;
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

    // Método que almacena en BD un objeto TipoPresentacionModel
    // Si tiene ya un código actualiza el registro y si no tiene lo inserta
    public function save()
    {
        if (!isset($this->codigo)) {
            $consulta = $this->db->prepare('INSERT INTO tipo_presentacion (codigo, largo, ancho, cantidad_alto) VALUES (?, ?, ?, ?)');

            $consulta->bindParam(1, $this->codigo);
            $consulta->bindParam(2, $this->largo);
            $consulta->bindParam(3, $this->ancho);
            $consulta->bindParam(4, $this->cantidad_alto);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE tipo_presentacion SET largo = ?, ancho = ?, cantidad_alto = ? WHERE codigo = ?');
            $consulta->bindParam(1, $this->largo);
            $consulta->bindParam(2, $this->ancho);
            $consulta->bindParam(3, $this->cantidad_alto);
            $consulta->bindParam(4, $this->codigo);
            $consulta->execute();
        }
    }

    // Método que elimina el TipoPresentacionModel de la BD
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM tipo_presentacion WHERE codigo = ?');
        $consulta->bindParam(1, $this->codigo);
        $consulta->execute();
    }
}
