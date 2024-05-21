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

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("head.php"); ?>
</head>
<body>

<?php include("navbar.php"); ?>

<?php
    // Verificar si se ha pasado un id_finanza en la URL
    if (isset($_GET['id_finanza'])) {
        // Obtener el id_finanza de la URL y sanitizarlo para evitar posibles ataques de inyección SQL
        $id_finanza = mysqli_real_escape_string($con, $_GET['id_finanza']);

        // Obtener el ID del usuario actual desde la sesión
        $session_user_id = $_SESSION["user_id"];

        // Consulta SQL para obtener los detalles del gasto con el id_finanza especificado y que pertenezca al usuario actual
        $sql = "SELECT * FROM finanzas WHERE id_finanza = $id_finanza";
        $result = $con->query($sql);

        // Verificar si se encontró algún resultado
        if ($result->num_rows > 0) {
            // Obtener los detalles del gasto
            $row = $result->fetch_assoc();
?>
<center>
    <h1>Detalle de Gasto</h1>

    <div class="card" style="width: 40rem;">
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($row['fecha'])); ?></li>
                <li class="list-group-item"><strong>RFC:</strong> <?php echo $row['rfc']; ?></li>
                <li class="list-group-item"><strong>Proveedor:</strong> <?php echo $row['proveedor']; ?></li>
                <li class="list-group-item"><strong>UUID:</strong> <?php echo $row['uuid']; ?></li>
                <li class="list-group-item"><strong>Folio:</strong> <?php echo $row['folio']; ?></li>
                <li class="list-group-item"><strong>Referencia:</strong> <?php echo $row['referencia']; ?></li>
                <li class="list-group-item"><strong>Observación:</strong> <?php echo $row['observacion']; ?></li>
                <li class="list-group-item"><strong>Subtotal: $</strong> <?php echo number_format($row["subtotal"], 2, ".", ","); ?></li>
                <li class="list-group-item"><strong>IVA: $</strong> <?php echo number_format($row["iva"], 2, ".", ","); ?></li>
                <li class="list-group-item"><strong>Total: $</strong> <?php echo number_format($row["total"], 2, ".", ","); ?></li>
            </ul>
        </div>

        <div class="card-body">
        <?php
            // Mostrar el enlace para descargar el PDF y/o el XML
            $pdf_path = $row["pdf_path"];
            $xml_path = $row["xml_path"];
            $autorizacion_path = $row["autorizacion_path"];
            $comprobante_path = $row["comprobante_path"];

            if ($pdf_path && $xml_path) {
                // Si tiene comprobante y autorización, mostrar y descargar ambos archivos
                echo '<a class="btn btn-success me-2" href="' . $xml_path . '" download>Descargar XML</a>';
                echo '<a class="btn btn-danger" href="' . $pdf_path . '" download>Descargar PDF</a>';
            } else {
                // Si no tiene comprobante y/o autorización, mostrar solo el enlace disponible
                if ($autorizacion_path && $comprobante_path) {
                    echo '<a class="btn btn-success me-2" href="' . $autorizacion_path . '" download>Descargar Autorización</a>';
                    echo '<a class="btn btn-danger" href="' . $comprobante_path . '" download>Descargar Comprobante</a>';
                }else {
                    echo "No hay archivos disponibles para descargar.";
                }
            }
        ?>

        </div>
    </div>
</center>

<?php
        } else {
            // Si no se encontraron resultados para el id_finanza proporcionado, muestra un mensaje de error
            echo "<div class='alert alert-danger' role='alert'>No se encontró el gasto especificado.</div>";
        }
    } else {
        // Si no se proporcionó un id_finanza en la URL, muestra un mensaje de error o redirige a otra página
        echo "<div class='alert alert-warning' role='alert'>No se ha especificado un gasto para mostrar.</div>";
    }

    // Cerrar la conexión a la base de datos
    $con->close();
?>
</body>
</html>
