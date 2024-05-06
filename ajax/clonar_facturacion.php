<?php
	
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
 //$id_factura= $_SESSION['id_factura'];
 //$numero_factura= $_SESSION['numero_factura'];
 $session_id= session_id();


   if (isset($_POST['id'])){$id=intval($_POST['id']);}
   if (isset($_POST['cantidad'])){$cantidad=intval($_POST['cantidad']);}
   if (isset($_POST['lote'])){$lote=$_POST['lote'];}
   if (isset($_POST['caducidad'])){$caducidad=$_POST['caducidad'];}
   if (isset($_POST['precio_venta'])){$precio_venta=floatval($_POST['precio_venta']);}
   if (isset($_POST['referencia'])){$referencia=$_POST['referencia'];}
   if (isset($_POST['almacen'])){$almacen=$_POST['almacen'];}

   
	
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");

	

 	if (!empty($id) and !empty($cantidad) and !empty($precio_venta) and !empty($lote) and !empty($referencia))
 {
 	$sql3=mysqli_query($con, "select * from inve01 where inve01.id_producto= $id");
 	while ($row=mysqli_fetch_array($sql3)){
 		$sku=$row['clave'];
		$id_producto=$row['id_producto'];
 		
 	}
	 $insert_tmp=mysqli_query($con, "INSERT INTO tmp (id_producto,lote_tmp,caducidad_tmp,referencia_tmp,id_almacen_tmp,cantidad_tmp,precio_tmp,session_id) VALUES ('$id_producto','$lote','$caducidad','$referencia','$almacen','$cantidad','$precio_venta','$session_id')");
	 echo "<script>console.log('".$referencia." ".$session_id."')</script>";
 }

 if (isset($_GET['id_detalle'])){

 	if(isset($_GET['tipo'])){

 		$tipo=$_GET['tipo'];


 	       switch ($tipo){

 			case "almacen":

 			$almacen=$_GET['item'];
 			$id_detalle=($_GET['id_detalle']);
 			$actualizar=mysqli_query($con,"UPDATE tmp SET id_almacen_tmp ='".$almacen."' where id_tmp='".$id_detalle."'");
 			//echo"<scipt>console.log('almacen ".$almacen."')</script>";
 		   break;
		
 		case "lote":

 		$lote=$_GET['item'];
 		$id_detalle=($_GET['id_detalle']);
 		$actualizar=mysqli_query($con,"UPDATE tmp SET lote_tmp ='".$lote."' where id_tmp='".$id_detalle."'");
 		//echo"<scipt>console.log('lote ".$lote."')</script>";
 		break;

 	   case "caducidad":

 		$caducidad=$_GET['item'];
 		$id_detalle=($_GET['id_detalle']);
 		echo"<scipt>console.log('caducidad ".$caducidad."')</script>";
 		$actualizar=mysqli_query($con,"UPDATE tmp SET caducidad_tmp ='".$caducidad."' where id_tmp='".$id_detalle."'");
 		break;

  	   case "precio":
  		$precio=$_GET['item'];
  		$id_detalle=($_GET['id_detalle']);
  		$actualizar=mysqli_query($con,"UPDATE tmp SET precio_tmp ='".$precio."' where id_tmp='".$id_detalle."'");
  		//echo"<scipt>console.log('precio ".$precio."')</script>";
        break;

  	    case "cantidad":

  		$cantidad=$_GET['item'];
  		$id_detalle=($_GET['id_detalle']);
  		$actualizar=mysqli_query($con,"UPDATE tmp SET cantidad_tmp ='".$cantidad."' where id_tmp='".$id_detalle."'");
  		//echo"<scipt>console.log('cantidad ".$cantidad."')</script>";
         break;

 	}
	
 	}
 }
	
 if (isset($_GET['id']))//codigo elimina un elemento del array
 {
 $id_detalle=intval($_GET['id']);	
 $delete=mysqli_query($con, "DELETE FROM tmp WHERE id_tmp='".$id_detalle."'");
 echo "<script>console.log('".$id_detalle."')</script>";
}
  $simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
 ?>
<table class="table">
<tr>
	<th class='text-center'>NO. ITEM</th>
	<th class='text-center'>REFERENCIA</th>
	<th class='text-center'>ALMACEN
	<th class='text-center'>LOTE</th>
	<th class='text-center'>CADUCIDAD</th>
	<th>DESCRIPCION</th>
	<th class='text-center'>CANT.</th>
	<th class='text-right'>PRECIO UNIT.</th>
	<th class='text-right'>PRECIO TOTAL</th>
	<th></th>
</tr>
<?php
	$item=1;
	$sumador_total=0;
	//$sql=mysqli_query($con, "select * from inve01, facturas, detalle_factura where facturas.numero_factura=detalle_factura.numero_factura and  facturas.id_factura='$id_factura' and inve01.id_producto=detalle_factura.id_producto and facturas.id_vendedor='$id_vendedor' and detalle_factura.id_vendedor='$id_vendedor'  ORDER BY detalle_factura.precio_venta DESC ");
	$sql=mysqli_query($con, "SELECT * FROM inve01, tmp  WHERE inve01.id_producto = tmp.id_producto  and tmp.session_id='".$session_id."'");
	
	while ($row=mysqli_fetch_array($sql))
	{
			$id_detalle=$row['id_tmp'];
			$id_producto=$row["id_producto"];
			//$codigo_producto=$row['clave'];
			$referencia=$row['referencia_tmp'];
			$almacen=$row['id_almacen_tmp'];
			$cantidad=$row['cantidad_tmp'];
			$lote=$row['lote_tmp'];
			$caducidad=$row['caducidad_tmp'];
			$nombre_producto=$row['descripcion'];
			$no_item=$item++;
			$precio_venta=$row['precio_tmp'];

	//$insert_tmp=mysqli_query($con, "INSERT INTO tmp (id_producto,lote_tmp,caducidad_tmp,referencia_tmp,id_almacen_tmp,cantidad_tmp,precio_tmp,session_id) VALUES ('$id','$lote','$caducidad','$referencia','$almacen','$cantidad','$precio_venta','$session_id')");

	
	
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	
		?>
		<tr>
			<td class='text-center'><?php echo $no_item;?></td>
			<td class='text-center'><?php echo $referencia;?></td>
			<td>
			<select class='form-control input-sm' id='almacen_<?php echo $id_detalle; ?>'    ondblclick="edit_item('<?php echo $id_detalle ;?>','almacen_<?php echo $id_detalle ;?>')" onchange="save_item('<?php echo $id_detalle ;?>',0)">
			<option selected><?php echo $almacen;?></option>
				<?php $sql_almacen="SELECT * FROM almacenes01"; $query= mysqli_query($con, $sql_almacen);
						while($row_alm=mysqli_fetch_array($query))
								{
								?>
								<option value='<?php echo $row_alm['descripcion'];?>'><?php echo  $row_alm['clave']."--".$row_alm['descripcion'];?></option>
								<?php
								}
							?></select>
			</td>
			<!--<td><input class="form-control" type='text' id='almacen_<?php echo $id_detalle; ?>' value='<?php echo $almacen;?>' readonly  ondblclick="edit_item('<?php echo $id_detalle ;?>','almacen_<?php echo $id_detalle ;?>')" onfocusout="save_item('<?php echo $id_detalle ;?>',0)" ></td>-->
			<td><input class="form-control" type='text' id='lote_<?php echo $id_detalle; ?>' value='<?php echo $lote;?>' readonly  ondblclick="edit_item('<?php echo $id_detalle ;?>','lote_<?php echo $id_detalle ;?>')" onfocusout="save_item('<?php echo $id_detalle ;?>',1)" ></td>	
		    <td><input class="form-control" type='date' id='caducidad_<?php echo $id_detalle; ?>' value='<?php echo $caducidad;?>' readonly  ondblclick="edit_item('<?php echo $id_detalle ;?>','caducidad_<?php echo $id_detalle ;?>')" onfocusout="save_item('<?php echo $id_detalle ;?>',4)" ></td>	
			<td><?php echo $nombre_producto;?></td>
			<td><input class="form-control" type='text' id='cantidad_<?php echo $id_detalle; ?>' value='<?php echo $cantidad;?>' readonly  ondblclick="edit_item('<?php echo $id_detalle ;?>','cantidad_<?php echo $id_detalle ;?>')" onfocusout="save_item('<?php echo $id_detalle ;?>',2)"></td>
			<td><input class="form-control" type='text' id='precio_<?php echo $id_detalle; ?>' value='<?php echo $precio_venta_r;?>' readonly  ondblclick="edit_item('<?php echo $id_detalle ;?>','precio_<?php echo $id_detalle ;?>')" onfocusout="save_item('<?php echo $id_detalle ;?>',3)"></td>
			<td class='text-right'><?php echo $precio_total_f;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_detalle ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
			<!--<input type="hidden" id="id_producto" name="id_producto" value="<?php echo $id_producto; ?>">-->
		</tr>		
		<?php
	}
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=($subtotal * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;
	//$update=mysqli_query($con,"update facturas set total_venta='$total_factura' where id_factura='$id_factura'");
?>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td class='text-right' colspan=4>SUBTOTAL <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($subtotal,2);?></td>
	
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td class='text-right' colspan=4>IVA (<?php echo $impuesto;?>)% <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($total_iva,2);?></td>
	
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td class='text-right' colspan=4>TOTAL <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($total_factura,2);?></td>
	
</tr>

</table>
