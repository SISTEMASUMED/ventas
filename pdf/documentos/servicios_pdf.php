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
	$session_id= session_id();
	$sql_count=mysqli_query($con,"select * from tmp_servicios where session_id='".$session_id."'");
	$count=mysqli_num_rows($sql_count);
	/*if ($count==0)
	{
	echo "<script>alert('No hay productos agregados a la remision')</script>";
	echo "<script>window.close();</script>";
	exit;
	}*/
	//FIn Variables POST
	$id_cliente=intval($_GET['id_cliente']);
	$derecho_habiente=intval($_GET['derecho_habiente']);
	$fecha_cirugia=($_GET['fecha_cirugia']);
	$nombre_cirugia=($_GET['nombre_cirugia']);
	$nombre_cirujano=($_GET['nombre_cirujano']);
	$paterno=($_GET['paterno']);
	$materno=($_GET['materno']);
	$nombre_paciente=($_GET['nombre_paciente']);
	$fecha_nacimiento=($_GET['fecha_nacimiento']);
	$expediente=($_GET['expediente']);
	$sexo=intval(($_GET['sexo']));
	$edad=($_GET['edad']);
	$sala=($_GET['sala']);
	$h_inicio=($_GET['h_inicio']);
	$h_termino=($_GET['h_termino']);
	$turno=($_GET['turno']);
	$id_vendedor=intval($_GET['id_vendedor']);
	$letra_ventas=($_GET['letra_ventas']);
	$diagnostico=($_GET['diagnostico']);
	if($diagnostico==''){
		$diagnostico='Sin Diagnostico';
	}

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------$condiciones=mysqli_real_escape_string($con,(strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));
	//Fin de variables por GET
	$sql=mysqli_query($con,"SELECT LAST_INSERT_ID(numero_servicio) as last FROM servicios WHERE id_vendedor = $id_vendedor order by id_servicio desc limit 0,1");
	$rw=mysqli_fetch_array($sql);
	$numero_servicio=$rw['last']+1;
	echo "<script>console.log('work: la hora de inicio es ".$h_inicio."');</script>";	
	$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
    // get the HTML
    include(dirname('__FILE__').'/res/servicio_html.php');
   ?>
<script>
location.href = 'https://sumed-store.com/ventas/servicios_integrales.php';
</script>


