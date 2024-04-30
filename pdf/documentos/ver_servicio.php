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
	$id_servicio=intval($_GET['id_servicio']);
    $numero_servicio2=($_GET['numero_servicio']);
	$sql_count=mysqli_query($con,"select * from servicios where id_servicio='".$id_servicio."'");
	$count=mysqli_num_rows($sql_count);
	echo "<script>console.log('inicio ".$id_servicio."--".$numero_servicio2."');</script>";
	if ($count==0)
	{
	echo "<script>console.log('hay resultados".$id_servicio.$numero_servicio2."');</script>";
	//exit;
	}
	//FIn Variables POST
    $sql_servicio=mysqli_query($con,"select * from servicios where id_servicio='".$id_servicio."'");
	$rw_servicio=mysqli_fetch_array($sql_servicio);
	$numero_servicio=$rw_servicio['numero_servicio'];
	$id_cliente=$rw_servicio['id_hospital'];
	$id_vendedor=$rw_servicio['id_vendedor'];
	$derecho_habiente=$rw_servicio['derecho_habiente'];
	$fecha_cirugia=$rw_servicio['fecha_cirugia'];
	$fecha_nacimiento=$rw_servicio['fecha_nacimiento'];
	$paterno=$rw_servicio['paterno'];
	$materno=$rw_servicio['materno'];
	$nombre_paciente=$rw_servicio['nombre_paciente'];
	$edad=$rw_servicio['edad'];
	$expediente=$rw_servicio['expediente'];
	$sala=$rw_servicio['sala'];
	$hora_inicio=$rw_servicio['hora_inicio'];
	$hora_termino=$rw_servicio['hora_termino'];
	$turno=$rw_servicio['turno'];
	$diagnostico=$rw_servicio['diagnostico'];
	$fecha_servicio=$rw_servicio['fecha_servicio'];
	$simbolo_moneda=get_row('perfil','moneda','id_perfil',1);
	$nombre_cirujano=$rw_servicio['nombre_cirujano'];
	$nombre_cirugia=$rw_servicio['nombre_cirugia'];
	$sexo=$rw_servicio['sexo'];

	//Fin de variables por GET
	$sql_servicio2=mysqli_query($con,"SELECT * FROM detalle_servicio WHERE numero_servicio = $numero_servicio and id_vendedor= $id_vendedor");
	$rw_servicio2=mysqli_fetch_array($sql_servicio2);
	if(empty($rw_servicio2)){
		echo "<script>alert('No hay procedimientos añadidos a esta remisión')</script>";
	}
	else{
	$adicionales=$rw_servicio2['adicionales'];
	$cantidad=$rw_servicio2['cantidad']; 
	$precio_venta=$rw_servicio2['precio_venta'];
	echo "<script>console.log('final ".$precio_venta."--".$expediente."');</script>";}
	include(dirname('__FILE__').'/res/ver_servicio_html.php');

   ?>
<script>

</script>


