<?php

	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	$active_facturas="";
	$active_productos="";
	$active_servicios="active";
	$active_clientes="";
	$active_usuarios="";	
	$title="SUMED";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	
	$id_servicio = ($_GET['id_servicio']);
	$numero_servicio = ($_GET['numero_servicio']); 
	$id_vendedor= ($_GET['id_vendedor']); 
	
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
			<h4><i class='glyphicon glyphicon-edit'></i> <?php echo "";?>Agregar materiales de procedimientos</h4>
			
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_materiales.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
			echo "<script>console.log('vendedor ".$id_vendedor."')</script>";
		?>
		<form class="form-horizontal"  id="datos_factura">
	<input type="hidden" id="id_servicio" value="<?php echo $id_servicio; ?>">
	<input type="hidden" id="numero_servicio" value="<?php echo $numero_servicio; ?>">
	<input type="hidden" id="id_vendedor" value="<?php echo $id_vendedor;?>">


	                    <button type='button' class='btn btn-default' data-toggle='modal' data-target='#nuevoProducto'>
						 <span class='glyphicon glyphicon-plus'></span> Nuevo material
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar materiales
						 <button type="submit"  class="btn btn-default">
						  <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
						</button>
					</div>	
				</div>
			</form>	
			<div class="clearfix"></div>	
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
		</div>
	</div>		
		  <div class="row-fluid">
			<div class="col-md-12">
			
			</div>	
		 </div>
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
    <script type="text/javascript" src="js/nuevos_materiales.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$(function() {
						$("#nombre_cliente").autocomplete({
							source: "./ajax/autocomplete/clientes.php",
							minLength: 2,
							select: function(event, ui) {
								$('#id_cliente').val(ui.item.id_cliente);
								$('#nombre_cliente').val(ui.item.nombre_cliente);
								$('#rfc_cliente').val(ui.item.rfc_cliente);
								$('#calle_cliente').val(ui.item.calle_cliente);
								$('#telefono_cliente').val(ui.item.telefono_cliente);
								$('#mail').val(ui.item.emailpred);
								$('#numext_cliente').val(ui.item.numext_cliente);
								$('#colonia_cliente').val(ui.item.colonia_cliente);
							 }
						});
					});
					
	$("#nombre_cliente").on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_cliente" ).val("");
							$("#rfc_cliente" ).val("");
							$("#telefono_cliente" ).val("");
							$('#calle_cliente').val("");		
							$('#numext_cliente').val("");
							$('#colonia_cliente').val("");
							$('#mail').val("");
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_cliente" ).val("");
							$("#id_cliente" ).val("");
							$("#rfc_cliente" ).val("");
							$("#telefono_cliente" ).val("");
							$("#mail" ).val("");
							$('#calle_cliente').val("");
							$('#numext_cliente').val("");
							$('#colonia_cliente').val("");
						}
					});	
	</script>
  </body>
</html>