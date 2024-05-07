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

// Obtener datos del formulario
$status = $_POST['status'];

// Verificar si ya existe un registro con el mismo UUID
$sql_check = "SELECT COUNT(*) AS count FROM finanzas WHERE uuid = '$uuid'";
$result_check = $con->query($sql_check);
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] > 0) {
    // Mostrar alerta si ya existe un registro con el mismo UUID
    echo "<script>alert('Ya existe una factura con el mismo UUID. No se puede facturar dos veces la misma factura.'); window.location.href = 'gastos.php';</script>";
} else {
    // Actualizar el estado del registro en la base de datos si no existe un registro con el mismo UUID
    $sql = "UPDATE finanzas SET status = '0'";

    if ($con->query($sql) === TRUE) {
        // Mostrar alerta de éxito
        echo "<script>alert('El gasto se ha eliminado correctamente'); window.location.href = 'gastos.php';</script>";
    } else {
        // Mostrar alerta de error
        echo "<script>alert('Error al eliminar el gasto" . $con->error . "');</script>";
    }
}

// Cerrar conexión
$con->close();
?>
