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

	$id_servicio = intval($_GET['id_servicio']);
	$numero_servicio=($_GET['numero_servicio']);
	$id_vendedor=($_GET['id_vendedor']);
	$session_id= session_id();
	$consulta=mysqli_query($con,"select * from tmp_materiales where session_id='".$session_id."'");
	
	while ($row = mysqli_fetch_array($consulta)) {
		
		$id_producto=$row['id_producto'];
		$lote=$row['lote_tmp'];
		$referencia=$row['referencia_tmp'];
		$almacen=$row['id_almacen_tmp'];
		$provedor=$row['id_provedor'];
		$cantidad=$row['cantidad_tmp'];
		$procedimiento=$row['procedimiento']; 

	$insert_detail = mysqli_query($con, "INSERT INTO materiales_servicio VALUES (NULL,'$numero_servicio','$id_producto','$procedimiento','$referencia','$lote','$almacen','$provedor','$cantidad','$id_vendedor')")
	or die ('la consulta fallo:'.$id_servicio.' numero_servicio '.$numero_servicio.' id_vendedor '.$id_vendedor.' lote '.$lote.mysqli_connect_error());

	$delete=mysqli_query($con,"DELETE FROM tmp_materiales WHERE session_id='".$session_id."'");

	echo "<script>alert('Matriales guardados exitosamente ');</script>";
	echo "<script>window.location.replace('../../servicios_integrales.php');</script>";
	//echo "<script>location.href = '../../servicios_integrales.php';</script>";
	
	//header("location: ../../servicios_integrales.php");
	}
	//echo "<script>alert('No hay productos agregados a la factura')</script>";
	//echo "<script>window.close();</script>";
	
	$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
    // get the HTML
    //include(dirname('__FILE__').'/res/factura_html.php');
   ?>
<script>
	
</script>


