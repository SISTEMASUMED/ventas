<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	/*if (empty($_POST['clave'])) {
           $errors[] = "Código vacío";
        } else if (empty($_POST['referencia'])){
			$errors[] = "Referencia de producto vacía";
		} else if (empty($_POST['descripcion'])){
			$errors[] = "Descripción del producto vacío";
		} else if (empty($_POST['exist'])){
			$errors[] = "Coloca la existencia que utilizarás";
		} else if (
			!empty($_POST['clave']) &&
			!empty($_POST['referencia']) &&
			!empty($_POST['descripcion']) &&
			!empty($_POST['lote']) &&
			!empty($_POST['exist'])
		){
		/* Connect To Database*/
		
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$codigo=mysqli_real_escape_string($con,(strip_tags($_POST["clave"],ENT_QUOTES)));
		$referencia=mysqli_real_escape_string($con,(strip_tags($_POST["referencia"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["descripcion"],ENT_QUOTES)));
		$existencia=$_POST['exist'];
		$date_added=date("Y-m-d H:i:s");
		
		$sql1 = "SELECT * FROM inve01 WHERE clave_alterna = '".$referencia."'";
		$query_check_referencia = mysqli_query($con,$sql1);
		$query_check_clave=mysqli_num_rows($query_check_referencia);
		if ($query_check_clave >=1){
			$errors[] = "Lo sentimos , esta referencia ya estan en uso.";
		echo "<script>console.log('work:estamos en un error');</script>";
		}else{
		$sql="INSERT INTO inve01 (id_producto,clave,clave_alterna,descripcion,ultima_venta,existencia,status) VALUES (NULL,'$codigo','$referencia','$nombre',NULL,$existencia,'A')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				
						$messages[] = "Producto ha sido ingresado satisfactoriamente.";
						echo "<script>console.log('work: se realizo el insert');</script>";
					}else{
						//echo "<script>console.log('work: hay un error en el insert".$query_check_clave."');</script>";
						echo "<script>console.log('work: hay un error en el insert');</script>";
						$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
					
		} 
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