<?php
	
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();

if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['adicionales'])){$adicionales=$_POST['adicionales'];}
if(isset($_POST['lote'])){$lote=$_POST['lote'];}
if(isset($_POST['caducidad'])){$caducidad=$_POST['caducidad'];}	



//comprobacion de variable ***

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
	

if (!empty($id) and !empty($cantidad) )
{
$insert_tmp=mysqli_query($con, "INSERT INTO tmp_servicios (id_tmp_servicios,id_claves,adicionales,cantidad_tmp,lote_tmp,caducidad_tmp,session_id) VALUES (NULL,'$id','$adicionales','$cantidad','$lote','$caducidad','$session_id')");
echo "<script>console.log('estamos aquí work:".$id." ".$lote." ".$caducidad." ".$session_id."');</script>";
}
	
if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp_servicio=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM tmp_servicios WHERE id_tmp_servicios='".$id_tmp_servicio."'");
echo"<script>console.log('se borro el id: ".$id_tmp_servicio."');</script>";
}
$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);

?>
<div class="tabe-responsive">

<table class="table table-striped"id="myTable">
<tr class="info">
	<th class='hidden-xs '>Clave HRAEI</th>
	<th class='text-center'>CODIGO</th>
	<th class='text-center'>ADICIONALES</th>
	<th class='text-center'>LOTE</th>
	<th class='text-center'>CADUCIDAD</th>
	<th class='text-center'>DESCRIPCION</th>
	<th class='text-center'>CANTIDAD</th>
	<th></th>
</tr>
<?php
	$sTable="claves_servicios";
	$sumador_total=0;
	
	//$sql= mysqli_query($con, "SELECT $sTable.id_producto, $sTable.clave as SKU, $sTable.DESCR as producto, $sTable.EXIST, cves_alter01.CVE_ART, cves_alter01.CVE_ALTER, ltpd01.CVE_ART, ltpd01.LOTE, ltpd01.CVE_ALM, ltpd01.CANTIDAD, almacenes01.CVE_ALM as n_almacen, almacenes01.DESCR as nombre_almacen, tmp.id_tmp, tmp.cantidad_tmp, tmp.precio_tmp, tmp.session_id FROM $sTable INNER JOIN cves_alter01 ON $sTable.CVE_ART = cves_alter01.CVE_ART INNER JOIN ltpd01 ON $sTable.CVE_ART = ltpd01.CVE_ART INNER JOIN almacenes01 ON almacenes01.CVE_ALM = ltpd01.CVE_ALM INNER JOIN tmp ON $sTable.id_producto = tmp.id_producto WHERE tmp.id_producto = inve01.id_producto and ltpd01.lote = tmp.lote_tmp and almacenes01.CVE_ALM = cve_alm_tmp and tmp.session_id='".$session_id."'");
	
	//$sql="SELECT * FROM inve01, tmp, almacen01 WHERE inve01.id_producto = tmp.id_producto, almacen01.clave = tmp.id_producto AND tmp.session_id='".$session_id."' ";
	//$sql= "SELECT $sTable.id_producto, $sTable.clave as SKU, $sTable.descripcion as producto, almacenes01.clave as n_almacen, almacenes01.descripcion as nombre_almacen, tmp.id_tmp,tmp.lote_tmp,tmp.referencia_tmp,tmp.id_almacen_tmp,tmp.cantidad_tmp, tmp.precio_tmp, tmp.session_id FROM $sTable INNER JOIN tmp ON $sTable.id_producto = tmp.id_producto INNER JOIN almacenes01 ON almacenes01.clave = tmp.id_almacen_tmp  WHERE tmp.session_id='".$session_id."'";
	$sql="SELECT * FROM claves_servicios, tmp_servicios  WHERE claves_servicios.id_claves = tmp_servicios.id_claves  and tmp_servicios.session_id='".$session_id."'";
	$query = mysqli_query($con, $sql);
	while ($row=mysqli_fetch_array($query)) {
	$id_tmp_servicios=$row["id_tmp_servicios"];
	$clave=$row['clave_hraei'];
	$codigo=$row['clvsi'];
	$cantidad=$row['cantidad_tmp'];
	$nombre_producto=$row['descripcion'];
    $adicionales=$row['adicionales'];
	$lote=$row['lote_tmp'];
	$caducidad=$row['caducidad_tmp'];
	
	
	$precio_venta=$row['precio'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	
	?>
		<tr>
			<td class='hidden-xs text-center'><?php echo $clave;?></td>
			<td class='text-center'><?php echo $codigo;?></td>
			<td class='text-center'><?php echo $adicionales;?></td>
			<td class='text-center'><?php echo $lote;?></td>
			<td class='text-center'><?php echo $caducidad;?></td>
            <td><?php echo $nombre_producto;?></td>
			<!--<td class='text-center'><?php echo $cantidad;?></td>	
			<td class='text-right'><?php echo $precio_venta_f;?></td>
			<td class='text-right'><?php echo $precio_total_f;?></td>-->
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp_servicios ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=($subtotal * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;

?>
<!--<tr>
	
	<td></td>
	<td></td>
	<td class='text-right' colspan=4>SUBTOTAL <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($subtotal,2);?></td>
	
</tr>
<tr>
	
	
	<td></td>
	<td></td>
	<td class='text-right' colspan=4>IVA (<?php echo $impuesto;?>)% <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($total_iva,2);?></td>
	
</tr>
<tr>
	
	
	<td></td>
	<td></td>
	<td class='text-right' colspan=4>TOTAL <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($total_factura,2);?></td>
	
</tr>-->

</table>
</div>