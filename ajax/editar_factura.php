 <?php

//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	//$id_factura= $_SESSION['id_factura'];
	/*Inicia validacion del lado del servidor*/
	echo "<script>console.log('lectura correcta')</script>";
			
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$id_factura=intval($_POST['id_factura']);
		$id_cliente=intval($_POST['id_cliente']);
		$numero_factua=($_POST['numero_factura2']);
		$id_vendedor=intval($_POST['id_vendedor']);
		if(empty($compra=$_POST['compra'])){
			$compra="";
		}
		if(empty($cotizacion=$_POST['cotizacion'])){
			$cotizacion="";
		}
		if(empty($doctor=$_POST['doctor'])){
			$doctor="";
		}
		if(empty($paciente=$_POST['paciente'])){
			$paciente="";
		}

 		$material=$_POST['material'];
		$pago=$_POST['pago'];
		$d_factura=$_POST['d_factura'];
		if (empty($observaciones=$_POST['observaciones'])){
			$observaciones="";
		}

		
		$sql="UPDATE facturas SET id_cliente ='".$id_cliente."', id_vendedor='".$id_vendedor."', compra='". $compra."',cotizacion='".$cotizacion."',doctor='".$doctor."',paciente='".$paciente."',material='".$material."',pago='".$pago."',d_factura='".$d_factura."',observaciones='".$observaciones."'  WHERE id_factura='".$id_factura."';";
		$query_update = mysqli_query($con,$sql);
		echo "<script>console.log('work_consulta: id_factura".$id_factura." ".$id_cliente." vendedor ".$id_vendedor." compra ".$compra." cotizacion ".$cotizacion." doctor ".$doctor." paciente ".$paciente."');</script>";
		
			if ($query_update){
				$messages[] = "Factura ha sido actualizada satisfactoriamente.";
				
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}
		
?>