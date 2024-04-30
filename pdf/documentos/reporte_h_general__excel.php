<?php
	error_reporting(E_ALL ^ E_NOTICE);
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit; 
    }
	ini_set('display_errors', 1);
	
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");

	//Archivo de funciones PHP
	include("../../funciones.php");
    include("../documentos/res/encabezado_excel.php")
    
		$fecha_inicio=date("Y-m-d", strtotime($_GET['fecha_inicio']));
        $fecha_fin=date("Y-m-d", strtotime($_GET['fecha_fin']));
		$id_cliente=intval($_GET['id_cliente']);
    
        $usuario = $_SESSION['user_id'];
        
	   if( header("Content-Type: application/xls; charset=iso-8859-1" &&
	    header("Content-Disposition: attachment; filename=reporte.xls"))
        {
		$sql_reporte="SELECT * FROM  detalle_servicio INNER JOIN servicios ON  detalle_servicio.numero_servicio = servicios.numero_servicio
	 	INNER JOIN claves_servicios ON detalle_servicio.id_claves= claves_servicios.id_claves where detalle_servicio.id_vendedor=servicios.id_vendedor 
		AND servicios.id_hospital = $id_cliente AND servicios.fecha_servicio >= '$fecha_inicio' AND servicios.fecha_servicio < '$fecha_fin'";
        echo "<script>console.log('deberia descargar el excel') </script>";
        $query_servicio=mysqli_query($con,$sql_reporte);
        }
        else{
            
            echo "<script>console.log('no jalo') </script>";
        }
        include(dirname('__FILE__').'/res/ver_reporte_excel.php');
       
       ?>