<?php	
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

if (isset($_GET['id_servicio']) && isset($_GET['numero_servicio'])){
	$id_servicio=$_GET['id_servicio'];
	$numero_servicio=$_GET['numero_servicio'];
	$_SESSION['id_servicio']=$id_servicio;
	$_SESSION['numero_servicio']=$numero_servicio;
}else{

	$id_servicio=$_SESSION['id_servicio'];
	$numero_servicio=$_SESSION['numero_servicio'];
}


if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['clave_hraei'])){$clave=$_POST['clave_hraei'];}
if (isset($_POST['codigo'])){$codigo=$_POST['codigo'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['adicionales'])){$adicionales=$_POST['adicionales'];}

else{
	$adicionales="";
}
if(isset($_POST['lote'])){$lote=$_POST['lote'];}
else{
	$lote="";
}
if(isset($_POST['caducidad'])){$caducidad=$_POST['caducidad'];}	
else {
	$caducidad="";
}

	
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
	


$sql_serv=mysqli_query($con, "select * from servicios where id_servicio='$id_servicio'");
while ($rw=mysqli_fetch_array($sql_serv)){
	$id_vendedor=$rw['id_vendedor'];
}
	if (!empty($id_servicio) and !empty($cantidad) )
{
	$sql3=mysqli_query($con, "select * from detalle_servicio where detalle_servicio.id_detalle_servicio= $id");
	echo "<script>console.log('estamos dentro del if');</script>";
	while ($row=mysqli_fetch_array($sql3)){
		$sku=$row['clave'];
		
		}
		
$insert_tmp=mysqli_query($con, "INSERT INTO detalle_servicio (id_detalle_servicio,numero_servicio,id_claves,clave_hraei,clvsi,adicionales,cantidad,precio_venta,id_vendedor,lote,caducidad) VALUES (NULL,'$numero_servicio','$id','$clave','$codigo','$adicionales','$cantidad','0','$id_vendedor','$lote','$caducidad')");
echo "<script>console.log('estamos aquí work:".$id." ".$lote." ".$adicionales." ".$cantidad." numero de servicio ".$numero_servicio."');</script>";
}
else{
	
}

	
if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_detalle=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM detalle_servicio WHERE id_detalle_servicio='".$id_detalle."'");
}
$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
?>
 <table class="table  table-striped">
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

	$sumador_total=0;
	$sql="SELECT * FROM  claves_servicios, detalle_servicio where claves_servicios.id_claves = detalle_servicio.id_claves and detalle_servicio.id_vendedor =$id_vendedor and numero_servicio=$numero_servicio";
	$query = mysqli_query($con, $sql);
	while ($row=mysqli_fetch_array($query)) {
	echo "<script>console.log('esto funciona correctamente')</script>";
	$id_detalle_servicio=$row["id_detalle_servicio"];
	$clave=$row['clave_hraei'];
	$codigo=$row['clvsi'];
	$cantidad=$row['cantidad'];
	$nombre_producto=$row['descripcion'];
    $adicionales=$row['adicionales'];
	$lote=$row['lote'];
	$caducidad=$row['caducidad'];
	
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
			<td class='text-center'><?php echo $cantidad;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_detalle_servicio ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
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
