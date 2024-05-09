<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
if (!isset($_SESSION['user_login_status']) || $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
ini_set('display_errors', 1);

/* Connect To Database */
include("config/db.php");
include("config/conexion.php");

// Verificar si se ha proporcionado un ID válido
if (!isset($_GET['id_finanza']) || !is_numeric($_GET['id_finanza'])) {
    die("ID de gasto no válido.");
}

$id_gasto = intval($_GET['id_finanza']);

// Obtener los datos del gasto
$sql_gasto = mysqli_query($con, "SELECT * FROM finanzas WHERE id_finanza = $id_gasto");
$rw_gasto = mysqli_fetch_array($sql_gasto);

// Crear un archivo Excel
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=gasto_$id_gasto.xls");

// Inicio del documento HTML
echo "<table border='1'>";
echo    "<tr>
            <th>Fecha</th>
            <th>RFC</th>
            <th>Nombre del Proveedor</th>
            <th>UUID</th>
            <th>Folio</th>
            <th>Referencia</th>
            <th>Observación</th>
            <th>Subtotal</th>
            <th>IVA</th>
            <th>Total</th>
        </tr>";

// Datos del gasto
echo "<tr>";
echo "<td>" . $rw_gasto["fecha"] . "</td>";
echo "<td>" . $rw_gasto["rfc"] . "</td>";
echo "<td>" . $rw_gasto["proveedor"] . "</td>";
echo "<td>" . $rw_gasto["uuid"] . "</td>";
echo "<td>" . $rw_gasto["folio"] . "</td>";
echo "<td>" . $rw_gasto["referencia"] . "</td>";
echo "<td>" . $rw_gasto["observacion"] . "</td>";
echo "<td>$" . number_format($rw_gasto["subtotal"], 2, ".", ",") . "</td>";
echo "<td>$" . number_format($rw_gasto["iva"], 2, ".", ",") . "</td>";
echo "<td>$" . number_format($rw_gasto["total"], 2, ".", ",") . "</td>";
echo "</tr>";

echo "</table>";
?>
