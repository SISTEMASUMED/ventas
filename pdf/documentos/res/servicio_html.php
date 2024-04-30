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
	
	color:white;
	font-weight:bold;
	font-size:12px;
}
.midnight-gray{
	background:#ffffff;
	color:black;
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
.break-after {
    display: block;
    page-break-after: always;
}

.break-before {
    display: block;
    page-break-before: always;
   
}
</style>
<page  backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
<div class="container">  
    <?php include("encabezado_servicio.php");?>
    <br>

	<div class=""  style="">
	<div style="width:100%; height:10px; background:#084599;"></div>

    <table id="" cellspacing="0" style="width:100%; text-align: left; font-size: 11pt;"> 
		<tr>
           <td style="width:55%;font-size:11px; " class="midnight-gray" >
			<?php 
				$sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente'");
				echo "<br><span class='midnight-blue'> Hospital:</span>";
				$rw_cliente=mysqli_fetch_array($sql_cliente);
				echo " <span style:'font-size:10px;'>".$rw_cliente['nombre_cliente']."</span>";
				echo "<br><span class='midnight-blue'>  RFC: </span>";
				echo "&nbsp &nbsp &nbsp ".$rw_cliente['rfc'];
				echo "<br><span class='midnight-blue'>  Dirección:</span>";
				echo "&nbsp &nbsp &nbsp ".$rw_cliente['calle'],$rw_cliente['numint'],$rw_cliente['numext'];
				echo "<br> <span class='midnight-blue'> Teléfono:</span> ";
				echo "&nbsp &nbsp &nbsp ".$rw_cliente['telefono'];
				echo "<br><span class='midnight-blue'>  Email: </span>";
				echo "&nbsp &nbsp &nbsp ".$rw_cliente['emailpred'];
			?>
		   </td>
           <td style="width:90%; "class="midnight-gray" >
			<?php 
			    $sql_user=mysqli_query($con,"select * from users where user_id='$id_vendedor'");
				$rw_user=mysqli_fetch_array($sql_user);
				echo "<br><span style:'padding-right:2%;' class='midnight-blue'> Técnico de Servicio:   </span>";
				echo " &nbsp ".$rw_user['nombre'];
				$nombre_vendedor=$rw_user['nombre'];
				echo "<br><span class='midnight-blue'>Derechohabiente:     </span>";
			   if($derecho_habiente=1){
					echo "&nbsp &nbsp &nbsp NO";
				   }else{
					echo " &nbsp &nbsp &nbsp   SI";
				   }
				echo "<br> <span class='midnight-blue'> Fecha de Cirugía:    </span> ";
				echo "&nbsp &nbsp &nbsp ".date("d/m/Y", strtotime($fecha_cirugia));
				echo "<br><span class='midnight-blue'>No. Expediente</span>";
				echo "&nbsp &nbsp &nbsp &nbsp&nbsp&nbsp&nbsp&nbsp ".$expediente;
				echo "<br><span class='midnight-blue'>Nombre del Cirujano: </span>";
				echo "&nbsp &nbsp &nbsp ".$nombre_cirujano;
				echo "<br><span class='midnight-blue'>Nombre del procedimiento: </span>";
				echo "&nbsp &nbsp &nbsp ".$nombre_cirugia;
			?>
			
		   </td>
		</tr>
    </table>
    </div>
	<br>
    <table id="" cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt; margin-top: -1%;">
    <tr>
        <td style="width:25%;font-size:9px;" class='midnight-blue'>Nombre</td>
		   <td style="width:20%;font-size:9px;" class='midnight-blue'>Appellido Paterno</td>
		   <td style="width:20%;font-size:9px;" class='midnight-blue'>Apellido Materno</td>
           <td style="width:20%;font-size:9px;" class='midnight-blue'>Fecha de Nacimiento</td>
           <td style="width:20%;font-size:9px;" class='midnight-blue'>Sexo</td>
           <td style="width:20%;font-size:9px;" class='midnight-blue'>Edad</td>
        </tr>
        <tr>
             <td style="width:20%;font-size:12px"><?php echo $nombre_paciente;?></td>
             <td style="width:20%;font-size:12px"><?php echo $paterno;?></td>
             <td style="width:20%;font-size:12px"><?php echo $materno;?></td>
             <td style="width:20%;font-size:12px"><?php echo date("d/m/Y", strtotime($fecha_nacimiento));?></td>
             <td style="width:20%;font-size:12px"><?php 
			 switch ($sexo){
			 case 0:
				echo "Hombre";
				break;
			case 1:
				echo "Mujer";
				break;
			case 3:
				echo "Otro";
				break;
			 }?></td>
             <td style="width:20%;"><?php echo $edad;?></td>

        </tr>
    </table>
       <br>
	   <table id="" cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt; margin-top:-2%;">
    <tr>
        <td style="width:25%; font-size:10px;" class='midnight-blue'>Sala</td>
		   <td style="width:15%; font-size:10px;" class='midnight-blue'>Hora de inicio</td>
		   <td style="width:15%; font-size:10px;" class='midnight-blue'>Hora de termino</td>
           <td style="width:15%; font-size:10px;" class='midnight-blue'>Turno</td>
           <td style="width:15%; font-size:10px;" class='midnight-blue'>Diagnostico</td>
		   <td style="width:15%; font-size:10px;" class='midnight-blue'>Fecha de Servicio</td>
        </tr>
        <tr>
             <td style="width:20%;font-size:11px;"><?php echo $sala;?></td>
             <td style="width:20%;font-size:11px;"><?php echo date("H:i:s", strtotime($hora_inicio));?></td>
			 <td style="width:20%;font-size:11px;"><?php echo date("H:i:s", strtotime($hora_termino));?></td>
             <td style="width:20%;font-size:11px;"><?php echo $turno;?></td>
             <td style="width:20%;font-size:11px;"><?php echo $diagnostico;?></td> 
			 <td style="width:20%;font-size:11px;"><?php echo date("d/m/Y", strtotime($fecha_servicio));?></td>

        </tr>
    </table>
<br>

    <table id="myTable" cellspacing="0" style="width: 100%; text-align: center; font-size: 10pt; margin-top:-2%;">
        <tr>
            
            <th style="width: 10%;text-align:center" class='midnight-blue'>CLAVE</th>
			<th style="width: 10%;text-align:center" class='midnight-blue'>CODIGO</th>
			<th style="text-align:center" class='midnight-blue'>ADICIONALES</th>
			<th style="width: 20%"text-align:center  class='midnight-blue'>LOTE</th>
			<th style="width: 20%"text-align:center  class='midnight-blue'>CADUCIDAD</th>
            <th style="width: 20%"text-align:center  class='midnight-blue'>DESCRIPCION</th>
			<th style="width: 20%;text-align:center" class='midnight-blue'>CANTIDAD</th>
        </tr>
		
<?php



$nums=1;
$sumador_total=0;
$sql=mysqli_query($con, "select * from claves_servicios, tmp_servicios where claves_servicios.id_claves = tmp_servicios.id_claves  and tmp_servicios.session_id='".$session_id."'");

while ($row = mysqli_fetch_array($sql)) {
$id_tmp = $row["id_tmp_servicios"];
	$adicionales = $row["adicionales"];
	$lote_tmp = $row["lote_tmp"];
	$caducidad_tmp = $row["caducidad_tmp"];	
	$id_producto = $row["id_claves"];
	$codigo_producto = $row['clave_hraei'];
	$referencia = $row['clvsi'];
	$nombre_producto = $row['descripcion'];
	$cantidad=$row['cantidad_tmp'];
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
			<td class='<?php echo $clase; ?>' style="width: 10%; text-align: center; font-size:10px;"><?php echo $adicionales; ?></td>
			<td class='<?php echo $clase; ?>' style="width: 10%; text-align: center; font-size:10px;"><?php echo $lote_tmp; ?></td>
			<td class='<?php echo $clase; ?>' style="width: 10%; text-align: center; font-size:10px;"><?php echo $caducidad_tmp; ?></td>
            <td class='<?php echo $clase; ?>' style="width: 25%; text-align: left; font-size:8px;"><?php echo $nombre_producto; ?></td>
			<td class='<?php echo $clase; ?>' style="width: 10%; text-align: center; font-size:10px;"><?php echo $cantidad; ?></td>
            
        </tr>

	<?php
	//Insert en la tabla detalle_cotizacion

	//$id_venta=intval($_SESSION['user_id']);
	$id_venta=1;
	$insert = mysqli_query($con, "INSERT INTO detalle_servicio VALUES (NULL,'$numero_servicio','$id_producto','$codigo_producto','$referencia','$adicionales','$cantidad','$precio_total_r','$id_vendedor','$lote_tmp','$caducidad_tmp')");
	$nums++;
	//echo "<script>console.log('INSERT INTO detalle_servicio VALUES (NULL,".$numero_servicio.",".$id_producto.",".$codigo_producto.",".$referencia.",".$adicionales.",".$cantidad.",".$precio_total_r.",".$id_vendedor.",".$lote_tmp.",".$caducidad_tmp."');</script>";
}
$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=($subtotal * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;
	
?>

    </table>
	
	
	<br>
	</div>
	<?php
$date=date("Y-m-d H:i:s");
$valor_x=1;
$insert = mysqli_query($con, "INSERT INTO servicios VALUES (NULL,'$numero_servicio','$id_cliente','$id_vendedor','$derecho_habiente','$fecha_cirugia','$paterno','$materno','$nombre_paciente','$fecha_nacimiento','$expediente','$sexo','$edad','$sala','$h_inicio','$h_termino','$turno','$diagnostico',1,'$date','$nombre_cirugia','$nombre_cirujano',0,1,0)");	
$delete=mysqli_query($con,"DELETE FROM tmp_servicios WHERE session_id='".$session_id."'");
//echo "<script>console.log('INSERT INTO servicios VALUES (NULL,".$numero_servicio.",".$id_cliente.",".$id_vendedor.",".$derecho_habiente.",".$fecha_cirugia.",".$paterno.",".$materno.",".$nombre_paciente.",".$fecha_nacimiento.",".$expediente.",".$sexo.",".$edad.",".$sala.",".$h_inicio.",".$h_termino.",".$turno.",".$diagnostico.",1,".$date."');</script>";
echo "<script>console.log('INSERT INTO servicios VALUES (NULL,".$nombre_cirujano.",".$nombre_cirugia."');</script>";

//echo "<script>console.log('work: la hora de inicio es ".$numero_servicio.$id_cliente.$id_vendedor.$derecho_habiente.$fecha_cirugia.$paterno.$materno.$nombre.$fecha_nacimiento.$expediente.$edad.$sexo.$sala.$h_inicio.$h_termino.$turno.$diagnostico.$date."');</script>";	
?>

<div  class="container" style="width:90%; border-width:2px; border-style: solid; border-color: #084599; padding-top:4%;  ">

	<div style="width:30%; display: inline-block;font-size:14px;">
		
		<p style="text-decoration: overline; ">Nombre y firma del jefe de Servicio</p>
	</div>
	<div style="width:30%;  display: inline-block;font-size:14px; ">
		
		<p style="text-decoration: overline; ">Nombre y firma del Técnico de Servicio</p>
	</div>
	<div style="width:30%;  display: inline-block;font-size:14px; ">
		<p style="text-decoration: overline; ">Nombre y firma del Intervencionista y Cirujano</p>
	</div>
	<div style="width:30%;  display: inline-block;font-size:14px; ">
		<p style="text-decoration: overline; ">Nombre y firma de quien <br>realizará el cargo al paciente</p>
	</div>
	<div>

	<?php
	if($id_cliente==162 || $id_vendedor==18){

		
	include("cliente_ixta.php");
	} 
?>

 
</div>

</div>

	</page>
	
<page class="break-before">	
<div style="margin-top:5%;">
<?php
$nums2=1;
$consulta=mysqli_query($con, "select * from materiales_servicio where materiales_servicio.numero_servicio = $numero_servicio and id_vendedor = $id_vendedor  order by materiales_servicio.clave_hraei ASC");
$cuenta=mysqli_num_rows($consulta);
if($cuenta==0){

}else{
	include("encabezado_servicio.php");
echo "	
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


<footer>	
</footer>
	
</page>

</body  >
<!--<button type="button" class="btn btn-success" id="btnPdf" >DESCARGAR</button>-->

                                                                                                      
<script>

	function toPdf(){

		const $elementoParaConvertir = document.body; // <-- Aquí puedes elegir cualquier elemento del DOM
        html2pdf()
            .set({
                margin: .3,
                filename: 'Servicio.pdf',
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


