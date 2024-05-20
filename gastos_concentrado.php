<?php
session_start();
if (!isset($_SESSION['user_login_status']) || $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}

require_once("config/db.php");
require_once("config/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_vendedor = $_POST['nombre_vendedor'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Consulta para obtener el id_vendedor a partir del nombre del vendedor
    $sql_vendedor = mysqli_query($con, "SELECT id_vendedor FROM vendedores WHERE nombre = '$nombre_vendedor'");
    $rw_vendedor = mysqli_fetch_array($sql_vendedor);

    if (!$rw_vendedor) {
        echo "No se encontró el vendedor con el nombre especificado.";
        exit;
    }

    $id_vendedor = $rw_vendedor['id_vendedor'];

    // Consulta para obtener los gastos del vendedor específico
    $sql_gastos = mysqli_query($con, "SELECT * FROM finanzas WHERE id_vendedor = '$id_vendedor' AND status = 1");

    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=Gastos_Generales_$nombre_vendedor.xls");

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

    while ($rw_gasto = mysqli_fetch_array($sql_gastos)) {
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
    }

    echo "</table>";
}
?>
