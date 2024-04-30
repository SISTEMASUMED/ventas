<?php
	
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();

	if (isset($_GET['id_servicio']) && isset($_GET['numero_servicio']) && isset($_GET['id_vendedor'])){
		$id_servicio=$_GET['id_servicio'];
		$numero_servicio=$_GET['numero_servicio'];
		$id_vendedor=$_GET['id_vendedor'];

	}else if(isset($_POST['id_servicio']) && isset($_POST['numero_servicio']) && isset($_POST['id_vendedor'])){
		$id_servicio=$_POST['id_servicio'];
		$numero_servicio=$_POST['numero_servicio'];
		$id_vendedor=$_POST['id_vendedor'];

	}else{
		$id_servicio=$_SESSION['id_servicio'];
	$numero_servicio=$_SESSION['numero_servicio'];
	$id_vendedor=$_SESSION['id_vendedor'];
	}
	

	
/*
$id_vendedor=$_GET['id_servicio'];
$numero_servicio=$_GET['numero_servicio'];
*/
//if (isset($_POST['id_servicio'])){$id_servicio=$_POST['id_servicio'];}
//if (isset($_POST['numero_servicio'])){$numero_servicio=$_POST['numero_servicio'];}
//if (isset($_POST['id_vendedor'])){$id_vendedor=$_POST['id_vendedor'];}

if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['provedor'])){$provedor=$_POST['provedor'];}
if (isset($_POST['lote'])){$lote=$_POST['lote'];}
if (isset($_POST['referencia'])){$referencia=$_POST['referencia'];}
if (isset($_POST['procedimiento'])){$procedimiento=$_POST['procedimiento'];}
if (isset($_POST['almacen'])){$almacen=$_POST['almacen'];}

//comprobacion de variable ***

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");

if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_materiales=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM materiales_servicio WHERE id_materiales='".$id_materiales."'");
echo "<script>console.log('material eliminado correctamente');</script>";
}	

if (!empty($id) and !empty($cantidad) and !empty($lote) and !empty($referencia) and !empty($almacen) )
{
$insert_material=mysqli_query($con, "INSERT INTO materiales_servicio (id_materiales,numero_servicio,id_producto,clave_hraei,referencia,lote,almacen,id_provedor,cantidad,id_vendedor) 
VALUES (NULL,'$numero_servicio','$id','$procedimiento','$referencia','$lote','$almacen','$provedor','$cantidad','$id_vendedor')");
//echo "<script>console.log('estamos aquí work:".$id." ".$procedimiento." ".$cantidad." ".$provedor." ".$lote." ".$referencia." almacen ".$almacen." sesion".$session_id."');</script>";
}
	

$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);

?>
<div class="tabe-responsive">

<table class="table table-striped"id="myTable">
<tr class="info">
	<th class='text-center'>PROCEDIMIENTO</th>
	<th class='text-center'>REFERENCIA</th>
	<th class='hidden-xs text-center'>ALMACÉN</th>
	<th class='hidden-xs text-center'>LOTE</th>
	<th class='text-center'>CANT.</th>
	<th class='hidden-xs text-center'>PROVEDOR</th>
	<th class= 'hidden-xs text-left'>DESCRIPCION</th>
	
	<th></th>
</tr>
<?php
	
	$sumador_total=0;
	
	//$sql= mysqli_query($con, "SELECT $sTable.id_producto, $sTable.clave as SKU, $sTable.DESCR as producto, $sTable.EXIST, cves_alter01.CVE_ART, cves_alter01.CVE_ALTER, ltpd01.CVE_ART, ltpd01.LOTE, ltpd01.CVE_ALM, ltpd01.CANTIDAD, almacenes01.CVE_ALM as n_almacen, almacenes01.DESCR as nombre_almacen, tmp.id_tmp, tmp.cantidad_tmp, tmp.precio_tmp, tmp.session_id FROM $sTable INNER JOIN cves_alter01 ON $sTable.CVE_ART = cves_alter01.CVE_ART INNER JOIN ltpd01 ON $sTable.CVE_ART = ltpd01.CVE_ART INNER JOIN almacenes01 ON almacenes01.CVE_ALM = ltpd01.CVE_ALM INNER JOIN tmp ON $sTable.id_producto = tmp.id_producto WHERE tmp.id_producto = inve01.id_producto and ltpd01.lote = tmp.lote_tmp and almacenes01.CVE_ALM = cve_alm_tmp and tmp.session_id='".$session_id."'");
	
	//$sql="SELECT * FROM inve01, tmp, almacen01 WHERE inve01.id_producto = tmp.id_producto, almacen01.clave = tmp.id_producto AND tmp.session_id='".$session_id."' ";
	//$sql= "SELECT $sTable.id_producto, $sTable.clave as SKU, $sTable.descripcion as producto, almacenes01.clave as n_almacen, almacenes01.descripcion as nombre_almacen, tmp.id_tmp,tmp.lote_tmp,tmp.referencia_tmp,tmp.id_almacen_tmp,tmp.cantidad_tmp, tmp.precio_tmp, tmp.session_id FROM $sTable INNER JOIN tmp ON $sTable.id_producto = tmp.id_producto INNER JOIN almacenes01 ON almacenes01.clave = tmp.id_almacen_tmp  WHERE tmp.session_id='".$session_id."'";
	$sql=mysqli_query($con,"SELECT * FROM inve01, materiales_servicio  WHERE inve01.id_producto = materiales_servicio.id_producto  
    and materiales_servicio.numero_servicio= '$numero_servicio' and materiales_servicio.id_vendedor='$id_vendedor' ");
	while ($row=mysqli_fetch_array($sql)) {
	$id_tmp=$row["id_materiales"];
	$codigo_producto=$row['clave_hraei'];
	$almacen=$row['almacen'];
	$referencia=$row['referencia'];
	$lote=$row['lote'];
	$cantidad=$row['cantidad'];
	$provedor=$row['id_provedor'];
	$nombre_producto=$row['descripcion'];
	
	
	
	
	?>
		<tr>
		<td class='text-center'><?php echo $codigo_producto;?></td>
			<td class='text-center'><?php echo $referencia;?></td>
			<td class='hidden-xs text-center'><?php echo $almacen;?></td>
			<td class='hidden-xs text-center'><?php echo $lote;?></td>
				<td class='text-center'><?php echo $cantidad;?></td>
			<td class='hidden-xs text-center'><?php echo $provedor;?></td>
				<td class='hidden-xs text-center'><?php echo $nombre_producto;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=($subtotal * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;

?>


</table>
</div>