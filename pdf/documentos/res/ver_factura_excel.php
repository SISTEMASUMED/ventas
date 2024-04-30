		
    </table>
	<br>
	
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
        <tr>
		<th style="width: 10%;text-align:center" class='midnight-blue'>NO. ITEM</th>
            <!--<th style="width: 10%;text-align:center" class='midnight-blue'>SKU</th>-->
			<th style="width: 10%;text-align:center" class='midnight-blue'>REFERENCIA</th>
			<th style="width: 10%;text-align:center" class='midnight-blue'>LOTE</th>
            <th style="width: 20%"text-align:center  class='midnight-blue'>DESCRIPCION	</th>
			<th style="width: 10%;text-align:center" class='midnight-blue'>CANT.</th>
            <th style="width: 20%;text-align:center" class='midnight-blue'>PRECIO UNIT.</th>
            <th style="width: 20%;text-align: center" class='midnight-blue'>PRECIO TOTAL</th>
            
        </tr>

<?php
$nums=1;
$item=1;
$sumador_total=0;
$sql=mysqli_query($con, "select * from inve01, detalle_factura, facturas where inve01.id_producto=detalle_factura.id_producto and detalle_factura.numero_factura=facturas.numero_factura and facturas.id_factura='".$id_factura."' and detalle_factura.id_vendedor='".$id_vendedor."'  ORDER BY detalle_factura.precio_venta desc");
/*$cuenta = mysqli_query($con, "SELECT COUNT(*) as total FROM inve01, detalle_factura, facturas WHERE inve01.id_producto=detalle_factura.id_producto AND detalle_factura.numero_factura=facturas.numero_factura AND facturas.id_factura='".$id_factura."'");
$data=mysql_fetch_array($cuenta);
$filas = $data['total'];*/

while ($row = mysqli_fetch_array($sql)) {
	  
		$id_producto = $row["id_producto"];
		$codigo_producto = $row['sku'];
		$lote = $row['lote'];
		$referencia=$row['referencia'];
		$almacen=$row['almacen'];
		$cantidad = $row['cantidad'];
		$nombre_producto = $row['descripcion'];
		$precio_venta = $row['precio_venta'];
		$precio_venta_f = number_format($precio_venta, 2); //Formateo variables
		$precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
		$precio_total = $precio_venta_r * $cantidad;
		$precio_total_f = number_format($precio_total, 2); //Precio total formateado
		$precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
		$sumador_total += $precio_total_r; //Sumador
		$no_item=$item++;

	if ($nums%2==0){
		$clase="clouds";
	} else {
		$clase="silver";
	}
	?>

        <tr>
		<td class='<?php echo $clase; ?>' style="width: 10%; text-align: center"><?php echo $no_item; ?></td>
          	
            <!--<td class='<?php echo $clase; ?>' style="width: 10%; text-align: center"><?php echo $codigo_producto; ?></td>-->
			<td class='<?php echo $clase; ?>' style="width: 10%; text-align: center"><?php echo $referencia; ?></td>
			<td class='<?php echo $clase; ?>' style="width: 05%; text-align: center"><?php echo $lote; ?></td>
            <td class='<?php echo $clase; ?>' style="width: 30%; text-align: left"><?php echo $nombre_producto; ?></td>
			<td class='<?php echo $clase; ?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase; ?>' style="width: 40%; text-align: center"><?php echo $precio_venta_f; ?></td>
            <td class='<?php echo $clase; ?>' style="width: 10%; text-align: center"><?php echo $precio_total_f; ?></td>
            
        </tr>

	<?php 

	
	$nums++;
	}
	
?>
		
    </table>
	
	
	
	
	<br>
	<footer>	
<?php 
/*if ($filas<5){
 $margin=45;
}	else if($filas>5 & $filas<10){
	$margin=25;
}	*/
?>
</footer>
</page>

</body  >
<script>
	function toPdf2(letra,factura){
	
		const $elementoParaConvertir = document.body; // <-- Aquí puedes elegir cualquier elemento del DOM
        html2pdf()
            .set({
                margin: .3,
                
                filename:  'remision DIG/'+letra+'-'+factura+'.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 3, // A mayor escala, mejores gráficos, pero más peso
                    letterRendering: true,
                },
                jsPDF: {
                    unit: "in",
                    format: "letter",
                    orientation: 'portrait' // landscape o portrait
                }
            })
            .from($elementoParaConvertir)
            .save()
            .catch(err => console.log(err));
   
	}
</script>
