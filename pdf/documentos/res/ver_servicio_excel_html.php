
    <table id="myTable" cellspacing="0" style="width: 100%; text-align: center; font-size: 10pt; margin-top:-1%;">
        <tr>
            
            <th style="width: 10%;text-align:center" class='midnight-blue'>CLAVE</th>
			<th style="width: 10%;text-align:center" class='midnight-blue'>CODIGO</th>
			<th style="text-align:center" class='midnight-blue'>ADICIONALES</th>
			<th style="width: 20%"text-align:center  class='midnight-blue'>LOTE</th>
			<th style="width: 20%"text-align:center  class='midnight-blue'>CADUCIDAD</th>
            <th style="width: 20%"text-align:center  class='midnight-blue'>DESCRIPCION</th>
			<th style="width: 20%;text-align:center" class='midnight-blue'>CANTIDAD</th>
			<th style="width: 20%;text-align:center" class='midnight-blue'>UNIDAD</th>
        </tr>
		
<?php

$nums=1;
$sumador_total=0;
$sql=mysqli_query($con, "select * from claves_servicios, detalle_servicio where claves_servicios.id_claves = detalle_servicio.id_claves and detalle_servicio.numero_servicio='".$numero_servicio."' and detalle_servicio.id_vendedor='".$id_vendedor."'");

while ($row = mysqli_fetch_array($sql)) {
$id_tmp = $row["id_detalle_servicio"];
	$id_producto = $row["id_claves"];
	$codigo_producto = $row['clave_hraei'];
	$referencia = $row['clvsi'];
	$adicionales =$row['adicionales'];
	$lote =$row['lote'];
	$caducidad =$row['caducidad'];
	$nombre_producto = $row['descripcion'];
	$cantidad=$row['cantidad'];
	$unidad=$row['unidad'];
	$precio_venta = $row['precio_venta'];
	$precio_venta_f = number_format($precio_venta, 2); //Formateo variables
	$precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
	$precio_total = $precio_venta_r * $cantidad;
	$precio_total_f = number_format($precio_total, 2); //Precio total formateado
	$precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
	$sumador_total += $precio_total_r; //Sumador
	
	if ($nums%2==0) {
		$clase = "clouds";
	} else {
		$clase = "silver";
	}
	
	?>
	
        <tr>
            <td class='<?php echo $clase; ?>' style="width: 10%; text-align: center; font-size:10px;"><?php echo $codigo_producto; ?></td>
			<td class='<?php echo $clase; ?>' style="width: 10%; text-align: center; font-size:10px;"><?php echo $referencia; ?></td>  
			<td class='<?php echo $clase; ?>' style="width: 10%; text-align: left; font-size:10px;"><?php echo $adicionales; ?></td> 
			<td class="<?php echo $clase; ?>" style="width: 10%; text-align: center; font-size:10px;"><?php echo $lote; ?></td>
			<td class="<?php echo $clase; ?>" style="width: 10%; text-align: center; font-size:10px;"><?php echo $caducidad; ?></td>
            <td class='<?php echo $clase; ?>' style="width: 25%; text-align: left; font-size:8px;"><?php echo substr($nombre_producto,0,150); ?></td>
			<td class='<?php echo $clase; ?>' style="width: 10%; text-align: center; font-size:10px;"><?php echo $cantidad; ?></td>
			<td class='<?php echo $clase; ?>' style="width: 10%; text-align: center; font-size:10px;"><?php echo $unidad; ?></td>
            
        </tr>

	<?php
	//Insert en la tabla detalle_cotizacion

	//$id_venta=intval($_SESSION['user_id']);
	$id_venta=1;
	$nums++;
}
	
?>

    </table>
	
</page>

<page class="break-before">	
<div class="container" style="margin-top:5%;">
<?php
$nums2=1;
$consulta=mysqli_query($con, "select * from materiales_servicio where materiales_servicio.numero_servicio = $numero_servicio and id_vendedor = $id_vendedor  order by materiales_servicio.clave_hraei ASC");
$cuenta=mysqli_num_rows($consulta);
if($cuenta==0){

}else{
	
echo "	
<br>
<br>
<br>
<br>
<table id='myTable' cellspacing='0'style='margin-top:10px; width: 100%; text-align: center; font-size: 10pt;'>
        <tr>
           
		<th class='hidden-xs midnight-blue'>Procedimiento</th>
					<th class='midnight-blue'>Referencia</th>
					<th class='midnight-blue'>Producto</th>
					<th class='midnight-blue'>Almacén</th>
					<th class='midnight-blue'>Lote</th>
					<th class='midnight-blue'>Provedor</th>
					<th class='midnight-blue'>Cantidad</th>
				
        </tr>
";

while ($row = mysqli_fetch_array($consulta)) {
   
	$id_producto = $row["id_producto"];
	$codigo_producto = $row['clave_hraei'];
	$referencia = $row['referencia'];
	$lote =$row['lote'];			
	$almacen = $row['almacen'];
	$provedor = $row['id_provedor'];
	$cantidad=$row['cantidad'];
	$producto=mysqli_query($con,"select descripcion from inve01 where id_producto = $id_producto");	
			$row3=mysqli_fetch_array($producto);
			if ($nums2%2==0) {
				$clase = "clouds";
			} else {
				$clase = "silver";
			}
	?>
	
        <tr>
			
            <td class='table-striped' style="width: 10%; text-align: center"><?php echo $codigo_producto; ?></td>
			<td class='table-striped' style="width: 10%; text-align: center"><?php echo $referencia; ?></td>  
            <td class='table-striped' style="width: 25%; text-align: left"><?php echo $row3['descripcion']; ?></td>
			<td class='table-striped' style="width: 10%; text-align: center"><?php echo $almacen; ?></td>
			<td class='table-striped' style="width: 10%; text-align: center"><?php echo $lote; ?></td>
			<td class='table-striped' style="width: 10%; text-align: center"><?php echo $provedor; ?></td>
			<td class='table-striped' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
        </tr>
		<?php 
	$nums++;
	}?>
</table>
<?php } ?>
</div>

</page>
</body  >
<!--<button type="button" class="btn btn-success" id="btnPdf" >DESCARGAR</button>-->
<?php
$date=date("Y-m-d H:i:s");
$valor_x=1;

?>                                                                                           
<script>	

</script>


