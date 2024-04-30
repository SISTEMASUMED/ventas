<?php
	
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_servicios="";
	$active_almacen="";
	$active_productos="active-link";
	$active_clientes="";
	$active_usuarios="";	
	$title="SUMED";
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
	
    <div class="container-fluid">
	<div class="panel panel-info">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
			<?php
			$session_id2 = $_SESSION["user_id"];
		$sql_usuario1=mysqli_query($con,"select * from users where user_id ='$session_id2'");
        $rj_usuario1=mysqli_fetch_array($sql_usuario1);
		echo "<script>console.log('work:".$rj_usuario1['is_admin']."');</script>";	
		
		if ($rj_usuario1['is_admin'] != 3 && $rj_usuario1['is_admin'] != 4){
			echo		

				"<button type='button' class='btn btn-info' data-toggle='modal' id='nuevoproducto' data-target='#nuevoProducto'><span class='glyphicon glyphicon-plus' ></span> Nuevo Producto</button>";
			}?>
	
			</div>
			

			<h4><i class='glyphicon glyphicon-search'></i> Buscar Productos</h4>
			
		</div>
		<div class="panel-body">
		
			
			
			<?php
			include("modal/registro_productos.php");
			include("modal/editar_productos.php");
			include("modal/registro_almacen.php");
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						
							<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Código o nombre</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Código o nombre del producto" onkeyup='load(1);'>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>
				
				
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->		
  			</div>
		</div>	 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/productos.js"></script>
  </body>
</html>
<script>
$( "#guardar_producto" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_producto.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax_productos").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax_productos").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_producto" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_producto.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	function obtener_datos(id){
		   console.log(id);
			var clave = $("#clave"+id).val();
			var referencia = $("#referencia"+id).val();
			var nombre_producto = $("#descripcion"+id).val();
			var lote = $("#lote"+id).val();
			var existencia = $("#existencias"+id).val();
			$("#mod_id").val(id);
			$("#mod_clave").val(clave);
			$("#mod_referencia").val(referencia);
			$("#mod_descripcion").val(nombre_producto);
			$("#mod_exist").val(existencia);
		}

	function enviar_valores(valor){
		//Pasa los parámetros a la pagina buscar
  		location.href='ajax/buscar_productos.php?valor=' + valor;
}

</script>