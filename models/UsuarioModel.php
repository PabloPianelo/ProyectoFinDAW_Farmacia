<?php

// Clase del modelo para trabajar con objetos Item que se almacenan en BD en la tabla ITEMS
class UsuarioModel
{
    // Conexión a la BD
    protected $db;

    // Atributos del objeto item que coinciden con los campos de la tabla ITEMS
    private $id_usuario;
    private $usuario;
    private $contraseña;
    private $perfil;
    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    public function getId_usuario()
    {
        return $this->id_usuario;
    }
    public function setId_usuario($id_usuario)
    {
        return $this->id_usuario = $id_usuario;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setUsuario($usuario)
    {
        return $this->usuario = $usuario;
    }

    public function getContraseña()
    {
        return $this->contraseña;
    }
    public function setContraseña($contraseña)
    {
        return $this->contraseña = $contraseña;
    }

    public function getPerfil()
    {
        return $this->perfil;
    }
    public function setPerfil($perfil)
    {
        return $this->perfil = $perfil;
    }






    // Método para obtener todos los registros de la tabla ITEMS
    // Devuelve un array de objetos de la clase ItemModel
    public function getAll()
    {
        //realizamos la consulta de todos los items
        $consulta = $this->db->prepare('SELECT * FROM usuario');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "UsuarioModel");

        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }


    // Método que devuelve (si existe en BD) un objeto ItemModel con un código determinado
    public function getById($codigo)
    {
        $gsent = $this->db->prepare('SELECT * FROM usuario where id_usuario = ?');
        $gsent->bindParam(1, $codigo);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "UsuarioModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }

    public function getByNombre($nombre)
{
    $gsent = $this->db->prepare('SELECT * FROM usuario where usuario = ?');
    
    $gsent->bindParam(1, $nombre);
    
    $gsent->execute();

    $gsent->setFetchMode(PDO::FETCH_CLASS, "UsuarioModel");
    
    $resultado = $gsent->fetch();

    return $resultado;
}

   
   
public function ComprobarUser_Password($user, $password)
{
    
        $gsent = $this->db->prepare('SELECT * FROM usuario WHERE usuario = ?  AND contraseña=?');
        $gsent->bindParam(1, $user);
            $password_encrypt = sha1($password);
            $gsent->bindParam(2, $password_encrypt);
            $gsent->execute();

            $gsent->setFetchMode(PDO::FETCH_CLASS, "UsuarioModel");
            $resultado = $gsent->fetch();

        if (!$resultado) {
            return false;
        } else {
            return true;
        }
    }

 



    public function save()
    {
        if (!isset($this->id_usuario)) {
            $consulta = $this->db->prepare('INSERT INTO usuario ( usuario , contraseña,perfil ) values ( ?,?,? )');
            $consulta->bindParam(1, $this->usuario);
            $consulta->bindParam(2, $this->contraseña);
            $consulta->bindParam(3, $this->perfil);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE usuario SET usuario = ?, contraseña = ?, perfil = ? WHERE id_usuario =  ? ');
            $consulta->bindParam(1, $this->usuario);
            $consulta->bindParam(2, $this->contraseña);
            $consulta->bindParam(3, $this->perfil);
            $consulta->bindParam(4, $this->id_usuario);
            $consulta->execute();
        }
    }

    //REVISAR
    public function delete($codigo)
    {
        $consulta = $this->db->prepare('DELETE FROM  usuario WHERE id_usuario =  ?');
        $consulta->bindParam(1, $codigo);
        $consulta->execute();
    }
}
?>