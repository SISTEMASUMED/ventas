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

<h1>Lista de Gastos</h1>

    <div class="container-fluid">
		<div class="panel panel-info info-tab">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
            <?php
                $session_id2 = $_SESSION["user_id"];
                $sql_usuario1 = mysqli_query($con, "SELECT * FROM users WHERE user_id ='$session_id2'");
                $rj_usuario1 = mysqli_fetch_array($sql_usuario1);
                $id_vendedor = $rj_usuario1['user_id'];

                // Verificar si el usuario es administrador
                if ($rj_usuario1['is_admin'] == 2) {
                    // El usuario es administrador
                    // echo "El usuario con ID $id_vendedor";
                } else {
                    // El usuario no es administrador
                    // echo "El usuario con ID $id_vendedor";
                }
            ?>
		
			<div>
				
			<?php 
                if ($rj_usuario1['is_admin'] == 1 || $rj_usuario1['is_admin'] == 2) {
                    echo "<a href='agregar_gasto.php' class='btn btn-info'><span class='glyphicon glyphicon-plus'></span> Nuevo Gasto</a>";
                }
            ?>
	</div>
    </div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Gasto</h4>
		</div>

        <?php

$sql = "SELECT * FROM finanzas WHERE status=1";
$result = $con->query($sql);
$sqlventas = "SELECT * FROM finanzas WHERE status = 1 AND id_vendedor = $session_id2 ";
$resultventas = $con->query($sqlventas);

if($resultventas->num_rows > 0){
    // Mostrar una tabla con las facturas
    echo "<table class='table  table-striped' id='myTable'>
    <tr>
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
    <th>Acciones</th>
    </tr>";
    // Mostrar datos de cada factura
    while($row = $resultventas->fetch_assoc()) {
        $fecha= date_create($row["fecha"]);
 
         echo "<tr>";
         echo "<td>" . date_format($fecha,"d/m/Y") . "</td>";
         echo "<td>" . $row["rfc"] . "</td>";
         echo "<td>" . $row["proveedor"] . "</td>";
         echo "<td>" . $row["uuid"] . "</td>";
         echo "<td>" . $row["folio"] . "</td>";
         echo "<td>" . $row["referencia"] . "</td>";
         echo "<td>" . $row["observacion"] . "</td>";
         echo "<td>$" . number_format($row["subtotal"],2,".",",") . "</td>";
         echo "<td>$" . number_format($row["iva"],2,".",",") . "</td>";
         echo "<td>$" . number_format($row["total"],2,".",",") . "</td>";
         // Agregar enlace de descarga para cada fila
         echo "<td>";
         if ($rj_usuario1['is_admin'] == 1) {
            // Admin todas las opciones
            echo "<a href='descargar_excel_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Descargar Excel'><i class='bx bx-download'></i></a>";
            echo "<a href='detalle_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Ver Detalle'><i class='bx bx-show'></i></a>";
            echo "<a href='editar_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Editar'><i class='bx bxs-edit-alt'></i></a>";
            echo "<a href='eliminar_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Eliminar'><i class='bx bx-trash'></i></a>";
        } elseif ($rj_usuario1['is_admin'] == 2) {
            // Ventas editar y ver
            echo "<a href='detalle_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Ver Detalle'><i class='bx bx-show'></i></a>";
            echo "<a href='editar_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Editar'><i class='bx bxs-edit-alt'></i></a>";
            echo "<a href='eliminar_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Eliminar'><i class='bx bx-trash'></i></a>";
        } elseif ($rj_usuario1['is_admin'] == 5) {
            // Finanzas ver y descargar
            echo "<a href='descargar_excel_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Descargar Excel'><i class='bx bx-download'></i></a>";
            echo "<a href='detalle_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Ver Detalle'><i class='bx bx-show'></i></a>";
        }

    echo "</td>";
}
echo "</table>";
} elseif ($result->num_rows > 0) {
    // Mostrar una tabla con las facturas
    echo "<table class='table  table-striped' id='myTable'>
    <tr>
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
    <th>Acciones</th>
    </tr>";

    // Mostrar datos de cada factura
    while($row = $result->fetch_assoc()) {
       $fecha= date_create($row["fecha"]);

        echo "<tr>";
        echo "<td>" . date_format($fecha,"d/m/Y") . "</td>";
        echo "<td>" . $row["rfc"] . "</td>";
        echo "<td>" . $row["proveedor"] . "</td>";
        echo "<td>" . $row["uuid"] . "</td>";
        echo "<td>" . $row["folio"] . "</td>";
        echo "<td>" . $row["referencia"] . "</td>";
        echo "<td>" . $row["observacion"] . "</td>";
        echo "<td>$" . number_format($row["subtotal"],2,".",",") . "</td>";
        echo "<td>$" . number_format($row["iva"],2,".",",") . "</td>";
        echo "<td>$" . number_format($row["total"],2,".",",") . "</td>";
        // Agregar enlace de descarga para cada fila
        echo "<td>";

            if ($rj_usuario1['is_admin'] == 1) {
                // Admin todas las opciones
                echo "<a href='descargar_excel_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Descargar Excel'><i class='bx bx-download'></i></a>";
                echo "<a href='detalle_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Ver Detalle'><i class='bx bx-show'></i></a>";
                echo "<a href='editar_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Editar'><i class='bx bxs-edit-alt'></i></a>";
                echo "<a href='eliminar_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Eliminar'><i class='bx bx-trash'></i></a>";
            } elseif ($rj_usuario1['is_admin'] == 2) {
                // Ventas editar y ver
                echo "<a href='detalle_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Ver Detalle'><i class='bx bx-show'></i></a>";
                echo "<a href='editar_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Editar'><i class='bx bxs-edit-alt'></i></a>";
                echo "<a href='eliminar_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Eliminar'><i class='bx bx-trash'></i></a>";
            } elseif ($rj_usuario1['is_admin'] == 5) {
                // Finanzas ver y descargar
                echo "<a href='descargar_excel_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Descargar Excel'><i class='bx bx-download'></i></a>";
                echo "<a href='detalle_gasto.php?id_finanza=" . $row["id_finanza"] . "' title='Ver Detalle'><i class='bx bx-show'></i></a>";
            }

        echo "</td>";
    }
    echo "</table>";
} else {
    echo "No hay facturas.";
}

?>


<script>
    var tabla = document.querySelector("#myTable");
    var dataTable = new DataTable(tabla);
</script>

    <?php
	    include("footer.php");
	?>

</body>
</html>

 