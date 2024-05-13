<?php
	
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	$active_facturas="active-link";
	$active_servicios="";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="SUMED";
	
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include("head.php");?>
	
  </head>
  <body>
  <?php
	include("navbar.php");
	?>  
    <div class="container-fluid">
		<div class="panel panel-info info-tab">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				<?php
			$session_id2 = $_SESSION["user_id"];
		$sql_usuario1=mysqli_query($con,"select * from users where user_id ='$session_id2'");
        $rj_usuario1=mysqli_fetch_array($sql_usuario1);
		//echo "<script>console.log('work:".$rj_usuario1['is_admin']."');</script>";	
		?>		
			<div>
				
			<?php if ($rj_usuario1['is_admin'] != 3 && $rj_usuario1['is_admin'] != 4){
			echo	
				"<a  href='nueva_factura.php' class='btn btn-info'><span class='glyphicon glyphicon-plus' ></span> Nueva Remisión</a>";
			}?>
	</div>
				
			</div>
			<h4><i class='glyphicon glyphicon-search' onkeyup='load(1);'></i> Buscar Remisión</h4>
		</div>
			<div class="panel-body">
			<?php
			include("modal/estado_factura.php");
		
			include("modal/bloqueo_remision_normal.php");
			?>
		
				<form class="form-horizontal" role="form" id="datos_cotizacion" >
				
						<div class="form-group row">
							<!--<label for="q" class="col-md-2 control-label">Cliente o # de Remisión</label>-->
							<div class="col-md-5">
								<input type="hidden" class="form-control" id="q" placeholder="Nombre del cliente o # de Remisión" onkeyup='load(1);'>
							</div>
							
							<div class='col-md-3'>
								<!--<button type='button' class='btn btn-default' onclick='load(1);'>-->
									<!--<span class='glyphicon glyphicon-search' ></span> Buscar</button>-->
								<span id='loader'></span>
							</div>
							
						</div> 
				
				
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			</div>
		</div>	
		
	</div>
	
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/facturas.js"></script>
	
  </body>
</html>
<script>

// 	Push.create('Hi there!', {
//     body: 'This is a notification.',
//     icon: 'icon.png',
//     timeout: 8000,               // Timeout before notification closes automatically.
//     vibrate: [100, 100, 100],    // An array of vibration pulses for mobile devices.
//     onClick: function() {
//         // Callback for when the notification is clicked. 
//         console.log(this);
//     }  
// });


$( "#editar_estado" ).submit(function( event ) {
			$('#actualizar_estado').attr("disabled", true);
			
		   var parametros = $(this).serialize();
			   $.ajax({
					  type: "POST",
					  url: "ajax/editar_estado_factura.php",
					  data: parametros,
					   beforeSend: function(objeto){
						  $("#resultados_ajax3").html("Mensaje: Cargando...");
						},
					  success: function(datos){
					  $("#resultados_ajax3").html(datos);
					  $('#actualizar_estado').attr("disabled", false);
					  load(1);
					}
			  });
			  event.preventDefault();
			})

			$( "#bloqueo_estado" ).submit(function( event ) {
			$('#bloqueo_remision').attr("disabled", true);
			
		   var parametros = $(this).serialize();
			   $.ajax({
					  type: "POST",
					  url: "ajax/bloqueo_remision_normal.php",
					  data: parametros,
					   beforeSend: function(objeto){
						  $("#resultados_ajax4").html("Mensaje: Cargando...");
						},
					  success: function(datos){
					  $("#resultados_ajax4").html(datos);
					  $('#bloqueo_remision').attr("disabled", false);
					  load(1);
					}
			  });
			  event.preventDefault();
			})

function obtener_datos(id){
			console.log(id);
			 var clave = $("#estado"+id).val();
			console.log(clave); 
			 $("#mod_id").val(id);
			 $("#mod_estado").val(clave);
			
		 }
		 function obtener_bloqueo(id){
			console.log('ID'+id);
			 var clave = $("#estado"+id).val();
			console.log(clave); 
			 $("#mod_id2").val(id);
			 $("#mod_estado").val(clave);
			
		 }
		 
	</script>