<?php
	
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	$active_concentrado="active-link";
	$active_facturas="";
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
				
	</div>
				
			</div>
			<h4><i class='glyphicon glyphicon-search' onkeyup='load(1);'></i> Reporte Remisión</h4>
		</div>
			<div class="panel-body">
			
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
                <div class="form-group row">
                    <label for="q" class="col-md-2 control-label">Fecha de inicio</label>
                    <div class="col-md-2">
                        <input type="date" class="form-control" id="fecha_inicio" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="q" class="col-md-2 control-label">Fecha final</label>
                    <div class="col-md-2">
                        <input type="date" class="form-control" id="fecha_fin" >
                    </div>
                </div>
				
                  
				<div class="form-group row">
				  <label for="nombre" class="col-md-2 control-label">Cliente</label>
				  <div class="col-md-2">
					  <input type="text" class="form-control input-sm" name="nombre" id="nombre_cliente" placeholder="Selecciona un cliente" required>
					  <input type='hidden' id="id_cliente" >	
				  </div>	
				</div>

				<!--BOTONES DE BUSCAR Y DESCARGA-->

				  <div class="form-group row">
                    <div class="col-md-1" >
                        <button type="button" class="btn btn-lg btn-default" onclick='load();'>
                            <span class="glyphicon glyphicon-search" ></span> Buscar</button>
                        
                    </div>
				
					
                
                    <div class="col-md-2" >
                        <button type="button" class="btn btn-lg btn-success" onclick='descargar_excel();'>
                            <span class="glyphicon glyphicon-download" ></span> Descargar Excel</button>
                        <span id="loader"></span>
                    </div>
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
	<script type="text/javascript" src="js/reporte.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
  </body>
</html>
<script>
	$(function() {
			$("#nombre_cliente").autocomplete({
							source: "./ajax/autocomplete/clientes.php",
							minLength: 2,
							select: function(event, ui) {
								$('#id_cliente').val(ui.item.id_cliente);
								$('#nombre_cliente').val(ui.item.nombre_cliente);
								
							 }
						});
						 
						
					});
								
	$("#nombre_cliente").on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_cliente" ).val("");
							
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_cliente" ).val("");
							$("#id_cliente" ).val("");
							
						}
			});	


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

// 

		 
	</script>