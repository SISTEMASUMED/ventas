<?php
    session_start();
    if (!isset($_SESSION['user_login_status']) || $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
        exit;
    }

    /* Connect To Database */
    require_once("config/db.php");
    require_once("config/conexion.php");

    if (isset($_POST['vendedor'])) {
        $vendedor = mysqli_real_escape_string($con, $_POST['vendedor']);

        // Consultar datos de gastos junto con el nombre del vendedor
        $sql_gasto = mysqli_query($con, "SELECT f.fecha, f.rfc, f.proveedor, f.uuid, f.folio, f.referencia, f.observacion, u.nombre AS vendedor, f.subtotal, f.iva, f.total 
                                         FROM finanzas f 
                                         JOIN users u ON f.id_vendedor = u.user_id
                                         WHERE f.status = 1 AND u.nombre = '$vendedor'");

        // Crear un archivo Excel
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: attachment; filename=Reporte_Gastos_Generales.xls");

        // Inicio del documento HTML para el archivo Excel
        echo "<table border='1' class='table table-striped' id='myTable'>";
        echo    "<tr>
                    <th>Fecha</th>
                    <th>RFC</th>
                    <th>Nombre del Proveedor</th>
                    <th>UUID</th>
                    <th>Folio</th>
                    <th>Referencia</th>
                    <th>Observación</th>
                    <th>Vendedor</th>
                    <th>Subtotal</th>
                    <th>IVA</th>
                    <th>Total</th>
                </tr>";

        // Iterar sobre los resultados y escribir las filas en el documento Excel
        while ($rw_gasto = mysqli_fetch_array($sql_gasto)) {
            echo "<tr>";
                echo "<td>" . $rw_gasto["fecha"] . "</td>";
                echo "<td>" . $rw_gasto["rfc"] . "</td>";
                echo "<td>" . $rw_gasto["proveedor"] . "</td>";
                echo "<td>" . $rw_gasto["uuid"] . "</td>";
                echo "<td>" . $rw_gasto["folio"] . "</td>";
                echo "<td>" . $rw_gasto["referencia"] . "</td>";
                echo "<td>" . $rw_gasto["observacion"] . "</td>";
                echo "<td>" . $rw_gasto["vendedor"] . "</td>";
                echo "<td>$" . number_format($rw_gasto["subtotal"], 2, ".", ",") . "</td>";
                echo "<td>$" . number_format($rw_gasto["iva"], 2, ".", ",") . "</td>";
                echo "<td>$" . number_format($rw_gasto["total"], 2, ".", ",") . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
?>
