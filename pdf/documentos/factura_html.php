<style type="text/css">
<!--
@page {
		margin-left: 0.5cm;
		margin-right: 0;
	}
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }

.reglamento{
font-size:12;
}
.reglamento h3{
	color:#084599; 
	font-weight: bold;
	font-size: 15px;
}
.reglamento h4{
	color:#084599; 
	font-weight: bold;
	font-size: 16px;
	text-align: center;
}
.firma{
	text-decoration: overline;
	margin-top: 20%;
}

.midnight-blue{
	background:#084599;
	padding: 4px 4px 4px;
	color:white;
	font-weight:bold;
	font-size:12px;
}
.silver{
	background:white;
	padding: 3px 4px 3px;
}
.clouds{
	background:#bdc3c7;
	padding: 3px 4px 3px;
}
.border-top{
	border-top: solid 1px #bdc3c7;
	
}
.border-left{
	border-left: solid 1px #bdc3c7;
}
.border-right{
	border-right: solid 1px #bdc3c7;
}
.border-bottom{
	border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;
}

</style>
<page  backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        
    <?php include("encabezado_factura.php");?>
    <br>
    

	
    <table id="" cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:50%;" class='midnight-blue'>En atención a:</td>
        </tr>
		<tr>
           <td style="width:50%;" >
			<?php 
				$sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente'");
				echo "<br><span> Nombre:</span>";
				$rw_cliente=mysqli_fetch_array($sql_cliente);
				echo $rw_cliente['nombre'];
				echo "<br><span>  RFC: </span>";
				echo $rw_cliente['rfc'];
				echo "<br><span>  Dirección:</span>";
				echo $rw_cliente['calle'],$rw_cliente['numint'],$rw_cliente['numext'];
				echo "<br> <span> Teléfono:</span> ";
				echo $rw_cliente['telefono'];
				echo "<br><span>  Email: </span>";
				echo $rw_cliente['emailpred'];
				echo "<br><span>  RFC: </span>";
				echo $rw_cliente['rfc'];
			?>
			
		   </td>
        </tr>
        
   
    </table>
    
       <br>
		<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:25%;" class='midnight-blue'>Vendedor</td>
		   <td style="width:20%;" class='midnight-blue'>Orden de compra</td>
		   <td style="width:20%;" class='midnight-blue'>Cotización</td>
		   <td style="width:20%;" class='midnight-blue'>Doctor</td>
		   <td style="width:20%;" class='midnight-blue'>Paciente</td>
		   <td style="width:20%;" class='midnight-blue'>Fecha</td>

		 
        </tr>
		<tr>
           <td style="width:20%;">
			<?php 
		
				$sql_user=mysqli_query($con,"select * from users where user_id='$id_vendedor'");
				$rw_user=mysqli_fetch_array($sql_user);
				echo $rw_user['nombre'];

				
			?>
		   </td>
		   		   	  <td style="width:20%;"><?php echo $compra;?></td>
					  <td style="width:20%;"><?php echo $cotizacion;?></td>
					  <td style="width:20%;"><?php echo $doctor;?></td>
					  <td style="width:20%;"><?php echo $paciente;?></td>
					  <td style="width:20%;"><?php echo date("d/m/Y", strtotime($fecha_factura));?></td>
        </tr>
	 </table>
	<br>
  
    <table id="myTable" cellspacing="0" style="width: 100%; text-align: center; font-size: 10pt;">
        <tr>
            <th style="width: 10%;text-align:center" class='midnight-blue'>CANT.</th>
            <th style="width: 10%;text-align:center" class='midnight-blue'>SKU</th>
			<th style="width: 10%;text-align:center" class='midnight-blue'>REFERENCIA</th>
			<th style="width: 10%;text-align:center" class='midnight-blue'>LOTE</th>
            <th style="width: 20%"text-align:center  class='midnight-blue'>DESCRIPCION	</th>
            <th style="width: 20%;text-align:center" class='midnight-blue'>PRECIO UNIT.</th>
            <th style="width: 20%;text-align: center" class='midnight-blue'>PRECIO TOTAL</th>
            
        </tr>
		
<?php

$nums=1;
$sumador_total=0;
$sql=mysqli_query($con, "select * from inve01, tmp where inve01.id_producto=tmp.id_producto and tmp.session_id='".$session_id."'");

while ($row = mysqli_fetch_array($sql)) {
$id_tmp = $row["id_tmp"];
	$id_producto = $row["id_producto"];
	$codigo_producto = $row['clave'];
	$referencia = $row['referencia_tmp'];
	$lote = $row['lote_tmp'];
	$cantidad = $row['cantidad_tmp'];
	$nombre_producto = $row['descripcion'];
	$precio_venta = $row['precio_tmp'];
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
		    <td class='<?php echo $clase; ?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase; ?>' style="width: 10%; text-align: center"><?php echo $codigo_producto; ?></td>
			<td class='<?php echo $clase; ?>' style="width: 10%; text-align: center"><?php echo $referencia; ?></td>
			<td class='<?php echo $clase; ?>' style="width: 05%; text-align: center"><?php echo $lote; ?></td>           
            <td class='<?php echo $clase; ?>' style="width: 50%; text-align: left"><?php echo $nombre_producto; ?></td>
            <td class='<?php echo $clase; ?>' style="width: 40%; text-align: center"><?php echo $precio_venta_f; ?></td>
            <td class='<?php echo $clase; ?>' style="width: 10%; text-align: center"><?php echo $precio_total_f; ?></td>
        </tr>

	<?php

   
	//Insert en la tabla detalle_cotizacion

	$insert_detail = mysqli_query($con, "INSERT INTO detalle_factura VALUES (NULL,'$numero_factura','$id_producto','$codigo_producto','$referencia','$lote','$cantidad','$precio_venta_r')");
	$nums++;
}
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=($subtotal * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;
	
?>
<tr style="padding-top: 20%;width:auto; height:10px; background:#084599;">
		<td></td>	
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
</tr>
        <tr
        style="padding-top: 20%; ">
		<td></td>
		<td></td>
		<td></td>
            <td colspan="3" style="color: #084599; font-weight: bold; width:25%; text-align:right;"><span>SUBTOTAL <?php echo $simbolo_moneda;?></span> </td>
          
            <td style="width: 15%; text-align: right;"> <?php echo number_format($subtotal,2);?></td>
        </tr>
		<tr>
		<td></td>
		<td></td>
		<td></td>
            <td colspan="3" style="color: #084599; font-weight: bold; width: 25%; text-align: right;">IVA (<?php echo $impuesto; ?>)% <?php echo $simbolo_moneda;?> </td>
           
            <td style="width: 15%; text-align: right;"> <?php echo number_format($total_iva,2);?></td>
        </tr><tr>
		<td></td>
		<td></td>
		<td></td>
            <td colspan="3" style="color: #084599; font-weight: bold; width: 25%; text-align: right;">TOTAL <?php echo $simbolo_moneda;?> </td>
            <td style="width: 15%; text-align: right;"> <?php echo number_format($total_factura,2);?></td>
        </tr>
    </table>
	
	
	<br>
<footer>	
<!--<img src="res/img/footer.png" alt="" style="width: 100%; height: auto; margin-top:3%;" >-->
</footer>
	
</page>

</body  >
<!--<button type="button" class="btn btn-success" id="btnPdf" >DESCARGAR</button>-->
<?php
$date=date("Y-m-d H:i:s");
$insert = mysqli_query($con, "INSERT INTO facturas VALUES (NULL,'$numero_factura','$date','$id_cliente','$id_vendedor','$total_factura','1','$compra','$cotizacion','$doctor','$paciente')");
	
$delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");
?>


<script>
	  



	function toPdf(){

		const $elementoParaConvertir = document.body; // <-- Aquí puedes elegir cualquier elemento del DOM
        html2pdf()
            .set({
                margin: .3,
                filename: 'remision.pdf',
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


