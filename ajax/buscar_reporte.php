<?php

error_reporting(0);
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	

		$fecha_inicio=date("Y-m-d", strtotime($_GET['fecha_inicio']));
        $fecha_fin=date("Y-m-d", strtotime($_GET['fecha_fin']));
		$id_cliente=intval($_GET['id_cliente']);
        

		$usuario = $_SESSION['user_id'];
		// $sql_reporte="SELECT * FROM  materiales_servicio INNER JOIN servicios ON materiales_servicio.numero_servicio=servicios.numero_servicio
		// INNER JOIN inve01 ON materiales_servicio.id_producto = inve01.id_producto where materiales_servicio.id_vendedor=servicios.id_vendedor 
		// AND fecha_servicio >= '$fecha_inicio' AND fecha_servicio < '$fecha_fin'";
		
		$sql_reporte="SELECT * FROM  detalle_servicio INNER JOIN servicios ON  detalle_servicio.numero_servicio = servicios.numero_servicio
	 	INNER JOIN claves_servicios ON detalle_servicio.id_claves= claves_servicios.id_claves where detalle_servicio.id_vendedor=servicios.id_vendedor 
		AND servicios.id_hospital = $id_cliente AND servicios.fecha_servicio >= '$fecha_inicio' AND servicios.fecha_servicio < '$fecha_fin'";

		echo "<script>console.log('fecha inicio ".$fecha_inicio."');</script>";
		echo "<script>console.log('fecha fin ".$fecha_fin."');</script>";
		echo "<script>console.log('cliente ".$id_cliente."');</script>";
      
        $query_servicio=mysqli_query($con,$sql_reporte);
		//echo "<script>console.log('sql".$sql_reporte."');</script>";
			?>
			<div class="table-responsive">
			  <table class="table  table-striped" id="myTable">
				<tr  class="info">
					<th class="" >PROGRESIVO</th>
                    <th class="">FOLIO</th>
                    <th>FECHA</th>
                    <th>MEDICO</th>
                    <th >PACIENTE</th>2707
                    <th>EXPEDIENTE</th>
                    <th>CANTIDAD</th>
                    <th>DESCRIPCION</th>
                    <th>CLAVE</th>
                    <th>COSTO </br>
				      UNITARIO</th>
						<th>SUBTOTAL</th>
				</tr>

				<?php
				$progresivo=1;
				while ($row=mysqli_fetch_array($query_servicio)){
					$id_cliente=$row['id_hospital'];
					$id_vendedor=$row['id_vendedor'];
					$numero_remision=$row['numero_servicio'];
					$fecha_servicio=$row['fecha_servicio'];
                    $medico=$row['nombre_cirujano'];
					$paciente=$row['nombre_paciente']." ".$row['paterno']." ".$row['materno'];
					$expediente=$row['expediente'];
					$cantidad=$row['cantidad'];
					$clvsi=$row['clvsi'];
					$descripcion=$row['descripcion'];
					$costo=$row['precio'];
					?>

				
					<tr>
                        <td><?php echo $progresivo; ?></td>
						<?php $sql_letra="SELECT users.user_id, users.nombre, users.letra FROM users WHERE user_id= $id_vendedor " ;
						$query_venta=mysqli_query($con,$sql_letra);
						$row_venta=mysqli_fetch_array($query_venta);
						?>
						<td><?php echo $row_venta['letra']."-".$numero_remision;  ?></td>
						
						<td><?php echo date("d/m/Y", strtotime($fecha_servicio));?></td>
						<td><?php echo $medico;?></td>
						<td><?php echo $paciente?></td>
						<td><?php echo $expediente?></td>
						<td><?php echo $cantidad?></td>
						<td><?php echo substr($descripcion,0,50);?></td>
						<td><?php echo $clvsi;?></td>
						
					<td><?php echo "$".number_format($costo,2,".",",");?></td>
					<?php 
					$total=$cantidad*$costo;
					?>
					<td><?php echo "$".number_format($total,2,".",",") ;?></td>
					</tr>
					<?php
					$progresivo++;
				}
				?>
				
			  </table>
			  <script>
	var tabla = document.querySelector("#myTable");
	var dataTable = new DataTable(tabla);
	</script>
			</div>
			<?php
		
	
?>