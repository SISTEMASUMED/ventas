<?php


?>
<div class="table-responsive">
			  <table class="table  table-striped" id="myTable">
				<tr  class="info">
					<th class="" >ITEM</th>
                    <th class="">FOLIO</th>
                    <th>FECHA</th>
                    <th>MEDICO</th>
                    <th >PACIENTE</th>
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

