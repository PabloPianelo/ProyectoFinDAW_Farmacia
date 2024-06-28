<?php
// En primer lugar recuperamos la información de la sesión
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

// Si el usuario no se ha autenticado le indicamos que 
if (!isset($_SESSION['usuario_admin'])) {
   header("Location:index.php?controlador=Login&accion=login");
}