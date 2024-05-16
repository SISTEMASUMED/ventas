<?php
    session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
        $id_vendedor = $_SESSION['user_id'];
		exit;
        }
    $active_facturas="";
    $active_productos="";
    $active_servicios="";
    $active_finanzas="active-link";
    $active_clientes="";
    $active_usuarios="";	
    $title="SUMED";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos


    ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("head.php");?>
</head>
<body>

<?php
	include("navbar.php");
?> 

<?php
    // Verificar si se ha pasado un id_finanza en la URL
    if(isset($_GET['id_finanza'])) {
        // Obtener el id_finanza de la URL y sanitizarlo para evitar posibles ataques de inyección SQL
        $id_finanza = mysqli_real_escape_string($con, $_GET['id_finanza']);

        // Consulta SQL para obtener los detalles del gasto con el id_finanza especificado
        $sql = "SELECT * FROM finanzas WHERE id_finanza = $id_finanza";
        $result = $con->query($sql);

        // Verificar si se encontró algún resultado
        if($result->num_rows > 0) {
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
            <li class="list-group-item"><strong>Subtotal: $</strong> <?php echo number_format($row["subtotal"],2,".",","); ?></li>
            <li class="list-group-item"><strong>IVA: $</strong> <?php echo number_format($row["iva"],2,".",","); ?></li>
            <li class="list-group-item"><strong>Total: $</strong> <?php echo number_format($row["total"],2,".",","); ?></li>
        </ul>
    </div>

    <div class="card-body">
    <?php

        // Consultar la base de datos para obtener la ruta del PDF y del XML
        $sql = "SELECT * FROM finanzas WHERE id_finanza = $id_finanza";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            // Mostrar el enlace para descargar el PDF y el XML
            $row = $result->fetch_assoc();
            $pdf_path = $row["pdf_path"];
            $xml_path = $row["xml_path"];
            
            echo '<a href="' . $xml_path . '" class="card-link" download>Descargar XML</a>';
            echo '<a href="' . $pdf_path . '" class="card-link" download>Descargar PDF</a>';
            
        } else {
            echo "No se encontraron archivos en la base de datos.";
        }

        $con->close();
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
?>



<?php

// Consultar la base de datos para obtener la ruta del PDF
$sql = "SELECT * FROM finanzas WHERE id_finanza = 45";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Mostrar el enlace para descargar el PDF
    $row = $result->fetch_assoc();
    $file_path = $row["pdf_path"];
    echo '<a href="' . $file_path . '" download>Descargar PDF</a>';
} else {
    echo "No se encontró ningún PDF en la base de datos.";
}

$con->close();
?>
