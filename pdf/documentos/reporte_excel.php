<?php
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}

include("../../config/db.php");
include("../../config/conexion.php");

//Archivo de funciones PHP
include("../../funciones.php");


		$fecha_inicio=date("Y-m-d", strtotime($_GET['fecha_inicio']));
        $fecha_fin=date("Y-m-d", strtotime($_GET['fecha_fin']));
		$id_cliente=intval($_GET['id_cliente']);


		$usuario = $_SESSION['user_id'];
		// $sql_reporte="SELECT * FROM  materiales_servicio INNER JOIN servicios ON materiales_servicio.numero_servicio=servicios.numero_servicio
		// INNER JOIN inve01 ON materiales_servicio.id_producto = inve01.id_producto where materiales_servicio.id_vendedor=servicios.id_vendedor
		// AND fecha_servicio >= '$fecha_inicio' AND fecha_servicio < '$fecha_fin'";

        $sql_reporte="SELECT * FROM  detalle_servicio INNER JOIN servicios ON  detalle_servicio.numero_servicio = servicios.numero_servicio
        INNER JOIN claves_servicios ON detalle_servicio.id_claves= claves_servicios.id_claves where detalle_servicio.id_vendedor=servicios.id_vendedor
       AND servicios.id_hospital = $id_cliente AND servicios.fecha_servicio >= '$fecha_inicio' AND servicios.fecha_servicio < '$fecha_fin'";

       echo "<script>console.log('fecha inicio ".$fecha_inicio."');</script>";
       echo "<script>console.log('fecha fin ".$fecha_fin."');</script>";
       echo "<script>console.log('cliente ".$id_cliente."');</script>";

       $query_servicio=mysqli_query($con,$sql_reporte);
       //echo "<script>console.log('sql".$sql_reporte."');</script>";
       $file="exportar.xls";
       header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
       header("Content-Disposition: attachment; filename=$file");
       

       include(dirname('__FILE__').'/res/reporte_excel_html.php');

			?>
			
			<?php
            ?>