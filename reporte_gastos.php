<?php
    session_start();
    if (!isset($_SESSION['user_login_status']) || $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
        exit;
    }

    $active_facturas = "";
    $active_productos = "";
    $active_servicios = "";
    $active_finanzas = "active-link";
    $active_clientes = "";
    $active_usuarios = "";    
    $title = "SUMED";

    /* Connect To Database */
    require_once("config/db.php"); // Contiene las variables de configuracion para conectar a la base de datos
    require_once("config/conexion.php"); // Contiene funcion que conecta a la base de datos
?>

