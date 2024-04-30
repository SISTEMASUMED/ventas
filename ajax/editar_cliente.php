<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/

		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
		$rfc=mysqli_real_escape_string($con,(strip_tags($_POST["mod_rfc"],ENT_QUOTES)));
		$calle=mysqli_real_escape_string($con,(strip_tags($_POST["mod_calle"],ENT_QUOTES)));
		$numint=mysqli_real_escape_string($con,(strip_tags($_POST["mod_numint"],ENT_QUOTES)));
		$numext=mysqli_real_escape_string($con,(strip_tags($_POST["mod_numext"],ENT_QUOTES)));
		$colonia=mysqli_real_escape_string($con,(strip_tags($_POST["mod_colonia"],ENT_QUOTES)));
		$telefono=mysqli_real_escape_string($con,(strip_tags($_POST["mod_telefono"],ENT_QUOTES)));
		$email=mysqli_real_escape_string($con,(strip_tags($_POST["mod_emailpred"],ENT_QUOTES)));
		$id_cliente=intval($_POST['mod_id']);
		//echo "<script>console.log('work:".$nombre." ".$rfc." ".$calle." ".$numint." ".$numext."".$colonia."".$telefono."".$email."".$id_cliente."');</script>";
		$sql="UPDATE clientes SET nombre_cliente='".$nombre."',rfc='".$rfc."',calle='".$calle."',numint='".$numint."',numext='".$numext."',colonia='".$colonia."',telefono='".$telefono."', emailpred='".$email."' WHERE id_cliente='".$id_cliente."';";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Cliente ha sido actualizado satisfactoriamente.";
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