<?php
	
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
    }
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	//Archivo de funciones PHP
	include("../../funciones.php");
	$id_factura= intval($_GET['id_factura']);
	$numero_factura2=($_GET['numero_factura']);
	$sql_count=mysqli_query($con,"select * from facturas where id_factura='".$id_factura."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('Factura no encontrada')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	$sql_factura=mysqli_query($con,"select * from facturas where id_factura='".$id_factura."'");
	$rw_factura=mysqli_fetch_array($sql_factura);
	$numero_factura=$rw_factura['numero_factura'];
	$id_cliente=$rw_factura['id_cliente'];
	$id_vendedor=$rw_factura['id_vendedor'];
	$fecha_factura=$rw_factura['fecha_factura'];
	$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);

	$sql_vendedor=mysqli_query($con,"select * from users where user_id='".$id_vendedor."'");
	$rw_vendedor=mysqli_fetch_array($sql_vendedor);
	$letra=$rw_vendedor['letra'];
 	
	$sql_factura2=mysqli_query($con,"SELECT * FROM detalle_factura WHERE numero_factura ='".$numero_factura2."' and id_vendedor='".$id_vendedor."'");
	$rw_factura2=mysqli_fetch_array($sql_factura2);
	$lote=$rw_factura2['lote'];
	$caducidad=$rw_factura2['caducidad'];
	$cantidad = $rw_factura2['cantidad'];
    $precio_venta = $rw_factura2['precio_venta'];
 
	 // get the HTML
	 include(dirname('__FILE__').'/res/ver_factura_cliente.php');
   
   ?>
   <input type="hidden" id="letra" value="<?php echo $letra  ?>" >
   <input type="hidden" id="numero_factura" value="<?php echo $numero_factura2  ?>" >
<script>
	letra=document.getElementById("letra").value;
	factura=document.getElementById("numero_factura").value;

	toPdf2(letra,factura);
</script>