<?php
session_start();
if (!isset($_SESSION['user_login_status']) || $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}

require_once("config/db.php"); // Contiene las variables de configuracion para conectar a la base de datos
require_once("config/conexion.php"); // Contiene funcion que conecta a la base de datos

if ($con->connect_error) {
    die("Error de conexión a la base de datos: " . $con->connect_error);
}

// Checa si el id_finanza se obtiene
if (isset($_GET['id_finanza']) && !empty($_GET['id_finanza'])) {
    $id_finanza = $_GET['id_finanza'];
    // Prepara la consulta SQL
    $sql = "UPDATE finanzas SET status = 0 WHERE id_finanza = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id_finanza);

    if ($stmt->execute()) {
        echo "<script>alert('El gasto se ha eliminado correctamente'); window.location.href = 'gastos.php';</script>";
        
    } else {
        // Mostrar alerta de error
        echo "<script>alert('Error al eliminar el gasto: " . $con->error . "');</script>";
    }

    // Cerrar statement
    $stmt->close();
} else {
    // Handle case when id_finanza is not set or empty
    echo "<script>alert('ID de gasto no válido');</script>";
}

// Cerrar conexión
$con->close();
?>
