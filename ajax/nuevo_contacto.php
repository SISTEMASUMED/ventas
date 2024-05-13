<?php
	session_start();
	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre'])) {
           $errors[] = "Nombre vacío";
        } else if (!empty($_POST['nombre'])){
		/* Connect To Database*/
		// require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		// require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre_contacto=$_POST["nombre"];
		$calle_contacto=$_POST["calle"];
		$numint_contacto=$_POST["numint"];
		$numext_contacto=$_POST["numext"];
		$colonia_contacto=$_POST["colonia"];
		$telefono_contacto=$_POST["telefono"];
		$postal_contacto=$_POST["postal"];
		$date_added=date("Y-m-d H:i:s");
		
		echo "<script>console.log('".$nombre_contacto."')</script>";
		//
        //$sql="INSERT INTO clientes (id_cliente,clave,nombre_cliente, rfc,calle,numint,numext,colonia,telefono, emailpred) VALUES (NULL,'A001','$nombre','$rfc','$calle','$numint','$numext','$colonia','$telefono','$email')";
		//$query_new_insert = mysqli_query($con,$sql);
			$_SESSION['nombre_contacto']=$nombre_contacto;
			$_SESSION['calle_contacto']=$calle_contacto;
			$_SESSION['numint_contacto']=$numint_contacto;
			$_SESSION['numext_contacto']=$numext_contacto;
			$_SESSION['colonia_contacto']=$colonia_contacto;
			$_SESSION['telefono_contacto']=$telefono_contacto;
			$_SESSION['postal_contacto']=$postal_contacto;

			if($_SESSION['nombre_contacto']!=""){
				$messages[] = "Datos de contacto guardados satisfactoriamente.";
				echo "<script>console.log('".$_SESSION['nombre_contacto']."')</script>";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		}

?>