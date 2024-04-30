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
$usuario = $_SESSION['user_id'];

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
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-edit'></i> <?php echo $usuario;?>Nueva Remisión de Servicios</h4>
			
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_servicios.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
		?>
			<form onkeydown="return event.key != 'Enter';"  class="form-horizontal"  id="datos_servicio">
				
		<div class="form-group row">
				<label for="hospital" class="col-md-1 control-label">Hospital</label>
					<div class="col-md-4">
						<input type="text" class="form-control input-sm" name="nombre_cliente" id="nombre_cliente" placeholder="Selecciona un hospital" required>
						<input id="id_cliente" type='hidden'>	
					</div>
			
				<label for="" class="col-md-1 control-label">Derecho Habiente?</label>
					<div class="col-md-2">
						<select class='form-control input-md-2' id="derechoh" name="derechoh">
							<option value="0" >SI</option>
							<option value="1" >NO</option>
							</option>
						</select>
				</div>
		
				<label for="fechaCirugia" class="col-md-1 control-label">Fecha de Cirugía</label>
							<div class="col-md-2">
								<input type="date" class="form-control input-md" name="fecha_cirugia" id="fecha_cirugia" value="" >
							</div>
		</div>
				<div class="form-group row">
					<label for="nombre_cirujano" class="col-md-1 control-label">Nombre del cirujano</label>
						<div class="col-md-4">
							<input type="text" class="form-control input-sm" name="nombre_cirujano" id="nombre_cirujano" placeholder="Nombre del Cirujano" >
						</div>
					<label for="nombre_cirugia" class="col-md-1 control-label">Nobre de procedimiento</label>
					<div>
						<div class="col-md-4">
							<input type="text" class="form-control input-sm" name="nombre_cirugia" id="nombre_cirugia" placeholder="Nombre de procedimiento" required>
						</div>
					</div>
				</div>
		<div class="form-group row">
				<label for="paterno" class="col-md-1 control-label">Apellido Paterno</label>
						<div class="col-md-2">
							<input type="text" name="paterno" class="form-control input-sm" id="paterno" placeholder="Apellido Paterno" required>
						</div>	
				<label for="materno" class="col-md-1 control-label">Apellido Materno</label>
							<div class="col-md-2">
								<input type="text" name="materno" class="form-control input-sm" id="materno" placeholder="Apellido Materno" required>
							</div>
				<label for="nombre" class="col-md-1 control-label">Nombre</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" name="nombre_paciente" id="nombre_paciente" placeholder="Nombre"required >
							</div>

					 </div>
						<div class="form-group row">
						<label for="fechaNacimiento" class="col-md-1 control-label">Fecha de Nacimiento</label>
							<div class="col-md-2">
								<input type="date" class="form-control input-sm" name="fecha_nacimiento" id="fecha_nacimiento" value="" >
							</div>
				
						<label for="expediente" class="col-md-1 control-label">Número de Expediente</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm-1" name="expediente" id="expediente" placeholder="Expediente:">
							</div>
						<!--<label for="curp" class="col-md-1 control-label">CURP</label>
							<div class="col-sm-1">
								<input type="text" class="form-control input-sm-1" name="curp" id="curp" placeholder="CURP:">
							</div>	-->
						<label for="sexo" class="col-md-1 control-label">Sexo</label>
							<div class="col-sm-2">
								<select class='form-control input-md-1' id="sexo" name="sexo">
									<option value="0" >Hombre</option>
									<option value="1" >Mujer</option>
									<option value="3" >Otro</option>
									</option>
								</select>
							</div>

						<label for="edad" class="col-md-1 control-label">Edad</label>
							<div class="col-md-1">
								<input type="number" class="form-control input-sm" name="edad" id="edad" placeholder="Edad" >
							</div>
						
					</div>

					<div class="form-group row">

					<label for="h_inicio" class="col-md-1 control-label">Hora de Inicio:</label>
							<div class="col-sm-2">
								<input type="time" class="form-control input-sm" name="h_inicio" id="h_inicio" placeholder="Hora" >
							</div>
					<label for="h_termino" class="col-md-1 control-label">Hora de Termino:</label>
							<div class="col-sm-2">
								<input type="time" class="form-control input-sm" name="h_termino" id="h_termino" placeholder="Hora" >
							</div>
					<label for="turno" class="col-md-1 control-label">Turno</label>
							<div class="col-sm-2">
								<select class='form-control input-sm-1' id="turno" name="turno">
									<option value="Matutino" >Matutino</option>
									<option value="Vespertino" >Vespertino</option>
									<option value="Nocturno" >Nocturno</option>
									</option>
								</select>
							</div>
							<label for="sala" class="col-md-1 control-label">Sala</label>
							<div class="col-sm-2">
								<input type="text" class="form-control input-sm-2" name="sala" id="sala" placeholder="Sala" >
							</div>
				
						<?php
										$sql_vendedor2=mysqli_query($con,"SELECT * FROM users WHERE user_id = $usuario order by nombre");
										$rw = mysqli_fetch_array($sql_vendedor2);	
										$id_vendedor=$rw["user_id"];
										$nombre_vendedor=$rw["nombre"];
										$letra = $rw['letra'];
								?>
							<input type="hidden" class="form-control input-sm" name="vendedor" id="id_vendedor" value="<?php echo $id_vendedor?>" >
							</div>

								
								<div class="col-md-1" id="letras">
								<input type='hidden' class='form-control input-sm' name='letra_ventas ' id='letra_ventas' readonly value="<?php echo $letra?>" >
							</div>
							</div>
							<div class="form-group row">

					<label for="diagnostico" class="col-md-1 control-label">Diagnostico:</label>
								<div class="col-md-6">
									<textarea name="diagnostico" class="form-control input-sm" rows="3" cols="10" id="diagnostico" placeholder="Diagnostico" ></textarea>
								</div>
							</div>		
			</div>
			</div>
				<div class="col-md-12">
					<div class="pull-right">
						
				
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar procedimientos
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</div>	
				</div>
			</form>	
			
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
	<script type="text/javascript" src="js/remision_servicio.js"></script>
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