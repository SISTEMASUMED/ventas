<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueadov
	/*Inicia validacion del lado del servidor*/
	
			
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		
		$id_cliente=intval($_POST['id_cliente']);
		$id_servicio=($_POST['id_servicio']);
		$id_vendedor=intval($_POST['id_vendedor']);
		$derechoh=intval($_POST['derechoh']);
		$fecha_cirugia=($_POST['fecha_cirugia']);
		$paterno=($_POST['paterno']);
		$materno=($_POST['materno']);
		$nombre_paciente=($_POST['nombre_paciente']);
		$fecha_nacimiento=($_POST['fecha_nacimiento']);
	    $expediente=($_POST['expediente']);
		$sexo=intval($_POST['sexo']);
		$edad=($_POST['edad']);
		$sala=($_POST['sala']);
		$h_inicio=($_POST['h_inicio']);
		$h_termino=($_POST['h_termino']);
		$turno=($_POST['turno']);
		$diagnostico=($_POST['diagnostico']);
		$nombre_cirugia=($_POST['nombre_cirugia']);
		$nombre_cirujano=($_POST['nombre_cirujano']);

		//$letra_ventas=$("#letra_ventas").val();
	    //$diagnostico=$("#diagnostico").val();s
	    //echo "<script>console.log('work:".$id_factura." ".$id_cliente." ".$id_vendedor." ".$compra."".$cotizacion."".$doctor."".$paciente."');</script>";
		echo "<script>console.log('".$id_vendedor."')</script>";
		$sql="UPDATE servicios SET id_servicio ='".$id_servicio."', id_hospital='".$id_cliente."',id_vendedor='".$id_vendedor."',
		derecho_habiente='".$derechoh."',fecha_cirugia='".$fecha_cirugia."',paterno='".$paterno."',
		materno='".$materno."',nombre_paciente='".$nombre_paciente."',fecha_nacimiento='".$fecha_nacimiento."', expediente='".$expediente."',
		sexo='".$sexo."', edad='".$edad."', sala='".$sala."', hora_inicio='".$h_inicio."', hora_termino='".$h_termino."', turno='".$turno."',
		diagnostico='".$diagnostico."',nombre_cirugia='".$nombre_cirugia."', nombre_cirujano='".$nombre_cirujano."'   WHERE id_servicio='".$id_servicio."' and id_vendedor='".$id_vendedor."'";
		$query_update = mysqli_query($con,$sql);

			if ($query_update){
				$messages[] = "Remisión actualizada satisfactoriamente.";
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