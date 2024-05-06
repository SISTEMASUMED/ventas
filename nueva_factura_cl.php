<?php
	
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
		
	$active_facturas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="SUMED";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	$session_id= session_id();
	$id_vendedor=$_SESSION['user_id'];
	
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
			<h4><i class='glyphicon glyphicon-edit'></i> Editar Remisión</h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
		?>
			<form class="form-horizontal" role="form" id="datos_factura" name="datos_factura">
				<div class="form-group row">
				  <label for="nombre_cliente" class="col-md-1 control-label">Cliente</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" placeholder="Selecciona un cliente" required value="">
					  <input id="id_cliente" name="id_cliente" type='hidden' >
					  	
				  </div>
				 <label for="direccion" class="col-md-1 control-label">Calle</label>
				  <div class="col-md-2">
					  <input type="text" class="form-control input-sm" name="calle" id="calle_cliente" value="" placeholder="Calle" readonly >
				  </div>
				  <label for="numext" class="col-md-1 control-label">No.EXT</label>
				  <div class="col-md-1">
					  <input type="text" class="form-control input-sm" name="numext" id="numext_cliente" value="" placeholder="No. EXT" readonly>
				  </div>
				  <label for="colonia" class="col-md-1 control-label">Colonia</label>
				  <div class="col-md-2">
					  <input type="text" class="form-control input-sm" name="colonia" id="colonia_cliente" value="" placeholder="Colonia" readonly>
				  </div>
				</div>
				<div class="form-group row">
				  <label for="rfc" class="col-sm-1 control-label">RFC</label>
							<div class="col-md-2">
								<input type="text" name="rfc" class="form-control input-sm" id="rfc_cliente" value="" placeholder="RFC" readonly>
							</div>
				  <label for="telefono_cliente" class="col-md-1 control-label">Teléfono</label>
							<div class="col-md-2">
								<input type="text" name="telefono_cliente" class="form-control input-sm" id="telefono_cliente" value="" placeholder="Teléfono" readonly>
							</div>
					<label for="mail" class="col-md-1 control-label">Email</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" name="mail" id="mail" value="" placeholder="Email" readonly>
							</div>
							<label for="tel2" class="col-md-1 control-label">Fecha</label>
							<div class="col-md-1">
								<input type="text" class="form-control input-sm" name="fecha" id="fecha" value="<?php echo date("d/m/Y");?>" readonly>
							</div>
				 </div>
						<div class="form-group row">
						<label for="compra" class="col-md-1 control-label">Orden de compra</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" name="compra" id="compra" value="" placeholder="Orden de compra:">
							</div>
							<label for="cotizacion" class="col-md-1 control-label">Cotización no.</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" name="cotizacion" id="cotizacion" value="" placeholder="Cotización" >
							</div>

							<label for="doctor" class="col-md-1 control-label">Doctor</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" name="doctor" id="doctor" value="" placeholder="Nombre del Doctor" >
							</div>

							<label for="paciente" class="col-md-1 control-label">Paciente</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" name="paciente" id="paciente" value="" placeholder="Paciente" >
							</div>
					</div>

					<div class="form-group row">
							<label for="empresa" class="col-md-1 control-label">Vendedor</label>
							<div class="col-md-2">	
							<?php
							$sql_vendedor=mysqli_query($con,"select * from users where user_id = $id_vendedor");
							$rw = mysqli_fetch_array($sql_vendedor);
							$nombre_vendedor=$rw["nombre"];
							$letra = $rw['letra'];
							?>
							<input type="hidden" class="form-control input-sm" name="id_vendedor" id="id_vendedor" value="<?php echo $id_vendedor?>" >
							<input type="text" class="form-control input-sm" name="vendedor" id="vendedor" value="<?php echo $nombre_vendedor?>" readonly>
							
							</div>

								<label for="letra" class="col-md-1 control-label">LETRA</label>
								<div class="col-sm-1" id="letras">
								<input type='text' class='form-control input-sm' name='letra_ventas ' id='letra_ventas' readonly value="<?php echo $letra?>" >
								
									</div>
									<label for="material" class="col-md-1 control-label">Material de:</label>
									<div class="col-sm-1">
										<select class='form-control input-sm ' id="material" name="material">
											<option selected>Selecciona el tipo de Material</option>
											<option value="Consignación" >Consignación</option>
											<option value="Donación" >Donación</option>
											<option value="Venta" >Venta</option>
											<option value="Reposición de consigna" >Reposición de consigna</option>
											<option value="Prestamo" >Prestamo</option>
										</select>
									</div>
									<label for="pago" class="col-sm-1 control-label">Condiciones de pago</label>
									<div class="col-sm-1">
										<select class='form-control input-sm ' id="pago" name="pago">
										<option selected>Selecciona el tipo de pago</option>
											<option value="Efectivo" >Efectivo</option>
											<option value="Transferencia" >Transferencia</option>
											<option value="Crédito" >Crédito</option>
											</option>
										</select>
									</div>
									
									<label for="d_factura" class="col-sm-1 control-label">Factura</label>
									<div class="col-sm-1">
										<select class='form-control input-sm ' id="d_factura" name="d_factura">
										
											<option value="SI" >SI</option>
											<option value="PUBLICO EN GENERAL" >PUBLICO EN GENERAL</option>
											</option>
										</select>
										</div>
									</div>
									<div class="form-group row">
									<label for="letra" class="col-md-1 control-label">Observaciones</label>
								<div class="col-sm-2" id="letras">
								<textarea name="observaciones" id="observaciones" rows="3" cols="25" value=""></textarea>
								</div>	
							</div>
			</div>
			</div>
				
				<div class="col-md-12">
					<div class="pull-right">
						
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoProducto">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo producto
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoCliente">
						 <span class="glyphicon glyphicon-user"></span> Nuevo cliente
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
						</button>
					</div>	
				</div>
			</form>	
			<div class="clearfix"></div>
				<div class="editar_factura" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
			
		</div> 
	</div>		
		 
	</div>         
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/clonar_factura.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$(function() {
						$("#nombre_cliente").autocomplete({
							source: "./ajax/autocomplete/clientes.php",
							minLength: 2,
							select: function(event, ui) {
								event.preventDefault();
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
					
	$("#nombre_cliente" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_cliente" ).val("");
							$("#rfc_cliente" ).val("");
							$("#telefono_cliente" ).val("");
							$('#calle_cliente').val("");		
							$('#numext_cliente').val("");
							$('#colonia_cliente').val("");				
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_cliente" ).val("");
							$("#id_cliente" ).val("");
							$("#rfc_cliente" ).val("");
							$("#telefono_cliente" ).val("");
							$('#calle_cliente').val("");
							$('#numext_cliente').val("");
							$('#colonia_cliente').val("");
						}
			});	
			

		/*function imprimir_factura(id_factura, numero_factura){
			VentanaCentrada('./pdf/documentos/ver_factura2.php?id_factura='+id_factura+'&numero_factura='+numero_factura);
		}*/

	</script>

  </body>
</html>