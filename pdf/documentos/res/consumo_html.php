
<page  backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        
    <?php include("encabezado_consumo.php");
   
    ?>

    <br>
   <?php 
  
        ?>
    <div class="container" style="margin-top: -1.3%;">
    <table class="table table-bordered" style="width:100%;page-break-inside: avoid;font-size:6px; border-spacing:1px;" >
        <tr>
            <th style="">CLAVE</th>
            <th style="">CANTIDAD</th>
            <th style="">CNIS</th>
            <th style="width:8%;">UNIDAD DE MEDIDA</th>
            <th style="">DESCRIPCIÓN</th>
            <th style="">LOTE</th>
            <th style="">CADUCIDAD</th>
            <th style="">PRECIO UNITARIO</th>
            <th style="">TOTAL</th>
            <th style="">OBSERVACIONES</th>
        </tr>
        <?php
        $nums=1;
        $sumador_total=0;
        $sql=mysqli_query($con, "select * from claves_servicios, detalle_servicio where claves_servicios.id_claves = detalle_servicio.id_claves and detalle_servicio.numero_servicio='".$numero_servicio."' and detalle_servicio.id_vendedor='".$id_vendedor."'");

				while ($row=mysqli_fetch_array($sql)){
                    $id_servicio=$row['id_claves'];
                    $clave=$row['clave_hraei'];
                    $codigo=$row['clvsi'];
                    $descripcion=$row['descripcion'];
                    $lote=$row['lote'];
                    $caducidad=$row['caducidad'];   
                    $unidad=$row['unidad'];
                    $cantidad = intval($row['cantidad']);
                    $precio_venta=intval($row['precio']);
                    $precio_venta_f = number_format($precio_venta, 2); //Formateo variables
                    $precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
                    $precio_total = $precio_venta_r * $cantidad;
                    $precio_total_f = number_format($precio_total, 2); //Precio total formateado
                    $precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
                    $sumador_total += $precio_total_r; //Sumador
                   // $total = $cantidad * $precio;
                ?>
            <tr >
                	 
						<td  style="font-size:9px; height:2%;"><?php echo $clave; ?></td>
                        <td style="font-size:9px; height:2%;"><?php echo $cantidad; ?></td>
						<td  style="font-size:9px; height:2%;"><?php echo $codigo; ?></td>
                        <td style="font-size:9px; height:2%;" ><?php echo $unidad; ?></td>
						<td style="font-size:8px; height:2%;" ><?php echo $descripcion; ?></td>
                        <td style="font-size:9px;height:2%;" ><?php echo $lote; ?></td>
                        <td style="font-size:9px; height:2%;" ><?php echo $caducidad; ?></td>
						<td class="font-size:9px; height:2%;" style="text-align: right;"><?php echo $precio_venta_f; ?></td>
                        <td class="font-size:9px; height:2%;" style="text-align: right;"><?php echo $precio_total_f; ?></td>
						<td class=''></td>
						
						
					</tr>
                    
                  <?php
                 $nums++;
                }
                $impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
                $subtotal=number_format($sumador_total,2,'.','');
                $total_iva=($subtotal * $impuesto )/100;
                $total_iva=number_format($total_iva,2,'.','');
                   $total_factura=$subtotal+$total_iva;
                  ?>  
		     <tr style="font-size: 11px;">
		    <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
              <td></td>
			  <td colspan="3" style="font-size:8px; font-weight: bold; width:25%; text-align:right;"><span>SUBTOTAL <?php echo $simbolo_moneda;?></span> </td>
		    <td style="font-size:8px;width: 15%; text-align: right;"> <?php echo number_format($subtotal,2);?></td>
            <td></td>
	  </tr>
	  <tr style="font-size: 11px;">
	  <td></td>
	  <td></td>
	  <td></td>
	  <td></td>
      <td></td>
		  <td colspan="3" style="font-size:8px; font-weight: bold; width: 25%; text-align: right;">IVA (<?php echo $impuesto; ?>)% <?php echo $simbolo_moneda;?> </td>
		  <td style="font-size:8px;width: 15%; text-align: right;"> <?php echo number_format($total_iva,2);?></td>
          <td></td>
	  </tr>
      <tr style="font-size: 11px;">
	  <td></td>
	  <td></td>
	  <td></td>
	  <td></td>
      <td></td>
		  <td colspan="3" style="font-size:8px; font-weight: bold; width: 25%; text-align: right;">TOTAL <?php echo $simbolo_moneda;?> </td>
		  <td style="font-size:8px;width: 15%; text-align: right;"> <?php echo number_format($total_factura,2);?></td>
          <td></td>
       </tr>   
    </table>
    <table style="width:100%; font-size:7px; margin-top:-.7%;">
    <td style=""><?php echo "<b>NOMBRE DEL TÉCNICO:</b> ".strtoupper($tecnico)." <br> <br> 
                <b>NOMBRE DEL CIRUJANO:_________________________"."</b><br><br> 
                <b>NOMBRE DE QUIEN REALIZARÁ <br>
                EL CARGO AL PACIENTE:___________________________</b><br><br> 
                "?></td>
    <td style="">
    <?php   echo "<b>FIRMA DEL TÉCNICO:________________________</b><br><br> 
                <b>FIRMA DEL CIRUJANO:_____________________</b><br><br> 
                <b>FIRMA DE QUIEN REALIZARÁ EL CARGO AL PACIENTE:__________</b><br><br> 
                "?>
    </td>
    <td>
    <?php   echo "<b>HORA DE INICIO:________________________</b><br><br> 
                <b>HORA DE TÉRMINO:_____________________</b><br><br> 
                <b>HORA DE RECIBO DE REMISION:__________</b><br><br> 
                "?>
    </td>
    </table>
    <div style="width:100%; display:flex; flex-direction: row; font-size:7px; margin-top:-1.5%;">
        <div style="width:80%; display:flex; flex-direction:row;margin-top:2%;align-items:center;">
            <p style="padding-right:1%; margin-top:3%;">SELLO DE CAJAS(S.R.F.)</p>
            <div style="width:25%;height:38px; border-style:solid; border-color:black; border-width:thin;"></div>
           
        </div>
        <div style="width:60%; display:flex; flex-direction:row;  margin-top:2%;align-items:center;">
            <p style="padding-right:1%; padding-left:2%; margin-top:3%;">SELLO DE ALMACÉN</p>
            <div style="width:30%;height:38px; border-style:solid; border-color:black; border-width:thin;"></div>
        </div>
    </div>  
    <p style="display:inline; margin-left:10%;font-size:8px;">NOMBRE Y FIRMA</p>
    <p style="display:inline; margin-left:53%;font-size:8px;">NOMBRE Y FIRMA</p> 
</div>
<footer>
    <div>
        <img src="res/img/footer_2024.png" style="margin-left:2%; width:96%; height:70px;" alt="">
    </div>
</footer>
<div class="page_break"></div>
<script>
    function toPdf2(){

const $elementoParaConvertir = document.body; // <-- Aquí puedes elegir cualquier elemento del DOM
html2pdf()
	.set({
		margin: .3,
		filename: 'hoja de consumo.pdf',
		image: {
			type: 'jpeg',
			quality: 0.98
		},
		html2canvas: {
			scale: 2, // A mayor escala, mejores gráficos, pero más peso
			letterRendering: true,
		},
		jsPDF: {
			unit: "in",
			format: "letter",
			orientation: 'landscape' // landscape o portrait
		}
	})
	.from($elementoParaConvertir)
	.save()
	.catch(err => console.log(err));

}

</script>
