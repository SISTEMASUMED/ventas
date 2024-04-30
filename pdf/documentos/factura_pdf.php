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
	$sql_count=mysqli_query($con,"select * from tmp where session_id='".$session_id."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('No hay productos agregados a la factura')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	
	//FIn Variables POST
	
	//Variables por GET
	$id_cliente=intval($_GET['id_cliente']);
	$id_vendedor=intval($_GET['id_vendedor']);
	$letra_ventas=($_GET['letra_ventas']);
	$compra=($_GET['compra']);
	$cotizacion=($_GET['cotizacion']);
	$doctor=($_GET['doctor']);
	$paciente=($_GET['paciente']);
	$material=($_GET['material']);
	$pago=($_GET['pago']);
	$d_factura=($_GET['d_factura']);
	$observaciones=($_GET['observaciones']);
	
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------$condiciones=mysqli_real_escape_string($con,(strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));
	//Fin de variables por GET
	
	$sql=mysqli_query($con,"SELECT LAST_INSERT_ID(numero_factura) as last FROM facturas WHERE id_vendedor = $id_vendedor order by id_factura desc limit 0,1");
	$rw=mysqli_fetch_array($sql);
	$numero_factura=$rw['last']+1;	
	$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
    // get the HTML
    include(dirname('__FILE__').'/res/factura_html.php');
   ?>
   <input type="hidden" id="letra" value="<?php echo $letra_ventas  ?>" >
   <input type="hidden" id="numero_factura" value="<?php echo $numero_factura  ?>" >
<script>
	letra=document.getElementById("letra").value;
	factura=document.getElementById("numero_factura").value;
	toPdf(letra,factura)
</script>


