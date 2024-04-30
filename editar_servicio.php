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
    if (isset($_GET['id_servicio'])&&(isset($_GET['numero_servicio'])))
	{
		$id_servicio=intval($_GET['id_servicio']);
		$numero_servicio=intval($_GET['numero_servicio']);
		$sql_servicio=mysqli_query($con,"select * from servicios, clientes where servicios.id_hospital=clientes.id_cliente and id_servicio='".$id_servicio."'");
		$count=mysqli_num_rows($sql_servicio);
        if ($count==1)
		{
            $rw_servicio=mysqli_fetch_array($sql_servicio);

            $id_cliente=$rw_servicio['id_cliente'];
            $nombre_cliente=$rw_servicio['nombre_cliente'];
            $calle=$rw_servicio['calle'];
            $colonia=$rw_servicio['colonia'];
            $num_ext=$rw_servicio['numext'];
            $rfc=$rw_servicio['rfc'];
            $telefono_cliente=$rw_servicio['telefono'];
            $email_cliente=$rw_servicio['emailpred'];
            $numero_servicio=$rw_servicio['numero_servicio'];
            $id_vendedor=$rw_servicio['id_vendedor'];
            $derecho_habiente=$rw_servicio['derecho_habiente'];
            $fecha_cirugia=$rw_servicio['fecha_cirugia'];
            $fecha_nacimiento=$rw_servicio['fecha_nacimiento'];
            $paterno=$rw_servicio['paterno'];
            $materno=$rw_servicio['materno'];
            $nombre_paciente=$rw_servicio['nombre_paciente'];
            $edad=$rw_servicio['edad'];
            $expediente=$rw_servicio['expediente'];
            $sala=$rw_servicio['sala'];
            $hora_inicio=$rw_servicio['hora_inicio'];
            $hora_termino=$rw_servicio['hora_termino'];
            $turno=$rw_servicio['turno'];
            $diagnostico=$rw_servicio['diagnostico'];
			$nombre_cirugia=$rw_servicio['nombre_cirugia'];
			$nombre_cirujano=$rw_servicio['nombre_cirujano'];
            $fecha_servicio=$rw_servicio['fecha_servicio'];
            $_SESSION['id_servicio']=$id_servicio;
			$_SESSION['numero_servicio']=$numero_servicio;
    
}	
else
{
    header("location: servicios.php");
    exit;	
}
} 
else 
{
header("location: servicios.php");
exit;
}

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
			<h4><i class='glyphicon glyphicon-edit'></i> <?php echo $usuario;?>Editar Remisión de Servicios</h4>
			<input type=hidden id='id_servicio_2' value='<?php echo $id_servicio;?>'>
			<input type=hidden id='numero_servicio_2' value='<?php echo $numero_servicio;?>'>
			
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_servicios.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
		?>
			<form class="form-horizontal"  id="datos_servicio">
				
		<div class="form-group row">
				<label for="hospital" class="col-md-1 control-label">Hospital</label>
					<div class="col-md-2">
						<input type="text" class="form-control input-sm" name="nombre_cliente" id="nombre_cliente" placeholder="Selecciona un hospital" value="<?php echo $nombre_cliente;?>">
						<input id="id_cliente" name="id_cliente" type='hidden'  value="<?php echo $id_cliente;?>">
						<input id="id_servicio"	name="id_servicio" type='hidden' value="<?php echo $id_servicio;?>">
					</div>
			
				<label for="" class="col-md-1 control-label">Derecho Habiente?</label>
					<div class="col-md-2">
						<select class='form-control input-sm-1 ' id="derechoh" name="derechoh">
							<?php if ($derecho_habiente==1){
								$derechoh="NO";
							}else{
								$derechoh="SI";
							}
							?>
							<option selected value="<?php echo $derecho_habiente;?>"><?php echo $derechoh;?></option>
							<option value="0" >SI</option>
							<option value="1" >NO</option>
							</option>
						</select>
					</div>
				<label for="fechaCirugia" class="col-md-1 control-label">Fecha de Cirugía</label>
							<div class="col-md-1">
								<input type="date" class="form-control input-md" name="fecha_cirugia" id="fecha_cirugia" value="<?php echo $fecha_cirugia; ?>" >
							</div>
					</div>
			<div class="form-group row">
					<label for="nombre_cirujano" class="col-md-1 control-label">Nombre del cirujano</label>
						<div class="col-md-4">
							<input type="text" class="form-control input-sm" name="nombre_cirujano" id="nombre_cirujano" value="<?php echo $nombre_cirujano; ?>">
						</div>
					<label for="nombre_cirugia" class="col-md-1 control-label">Nobre de procedimiento</label>
					<div>
						<div class="col-md-4">
							<input type="text" class="form-control input-sm" name="nombre_cirugia" id="nombre_cirugia" value="<?php echo $nombre_cirugia; ?>">
						</div>
					</div>
				</div>
		<div class="form-group row">
				<label for="paterno" class="col-md-1 control-label">Apellido Paterno</label>
						<div class="col-md-2">
							<input type="text" name="paterno" class="form-control input-sm" id="paterno" placeholder="Apellido Paterno" value="<?php echo $paterno; ?>">
						</div>	
				<label for="materno" class="col-md-1 control-label">Apellido Materno</label>
							<div class="col-md-2">
								<input type="text" name="materno" class="form-control input-sm" id="materno" placeholder="Apellido Materno" value="<?php echo $materno; ?>">
							</div>
				<label for="nombre" class="col-md-1 control-label">Nombre</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" name="nombre_paciente" id="nombre_paciente" placeholder="Nombre" value="<?php echo $nombre_paciente; ?>">
							</div>

					 </div>
						<div class="form-group row">
						<label for="fechaNacimiento" class="col-md-1 control-label">Fecha de Nacimiento</label>
							<div class="col-md-1">
								<input type="date" class="form-control input-sm" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo $fecha_nacimiento ?>" >
							</div>
				
						<label for="expediente" class="col-md-1 control-label">Número de Expediente</label>
							<div class="col-md-1">
								<input type="text" class="form-control input-sm-1" name="expediente" id="expediente" placeholder="Expediente:" value="<?php echo $expediente; ?>">
							</div>
						<!--<label for="curp" class="col-md-1 control-label">CURP</label>
							<div class="col-sm-1">
								<input type="text" class="form-control input-sm-1" name="curp" id="curp" placeholder="CURP:">
							</div>	-->
						<label for="sexo" class="col-md-1 control-label">Sexo</label>
							<div class="col-md-1">
								<select class='form-control input-sm-1' id="sexo" name="sexo">
									<option value="0" >Hombre</option>
									<option value="1" >Mujer</option>
									<option value="3" >Otro</option>
									</option>
								</select>
							</div>

						<label for="edad" class="col-md-1 control-label">Edad</label>
							<div class="col-md-1">
								<input type="number" class="form-control input-sm" name="edad" id="edad" placeholder="Edad" value="<?php echo $edad; ?>">
							</div>
						<label for="sala" class="col-md-1 control-label">Sala</label>
							<div class="col-md-1">
								<input type="text" class="form-control input-sm" name="sala" id="sala" placeholder="Sala" value="<?php echo $sala; ?>">
							</div>
					</div>

					<div class="form-group row">

					<label for="h_inicio" class="col-md-1 control-label">Hora de Inicio:</label>
							<div class="col-md-1">
								<input type="time" class="form-control input-sm" name="h_inicio" id="h_inicio" placeholder="Hora" value="<?php echo $hora_inicio ?>">
							</div>
					<label for="h_termino" class="col-md-1 control-label">Hora de Termino:</label>
							<div class="col-md-1">
								<input type="time" class="form-control input-sm" name="h_termino" id="h_termino" placeholder="Hora" value="<?php echo $hora_termino ?>" >
							</div>
					<label for="turno" class="col-md-1 control-label">Turno</label>
							<div class="col-md-1">
								<select class='form-control input-sm-1' id="turno" name="turno">
									<option value="Matutino" >Matutino</option>
									<option value="Vespertino" >Vespertino</option>
									<option value="Nocturno" >Nocturno</option>
									</option>
								</select>
							</div>

					<label for="empresa" class="col-md-1 control-label">Vendedor</label>
							<div class="col-md-2">	
								<?php   

										$sql_vendedor2=mysqli_query($con,"SELECT * FROM users WHERE user_id = $id_vendedor order by nombre");
										$rw = mysqli_fetch_array($sql_vendedor2);	
										$id_vendedor=$rw["user_id"];
										$nombre_vendedor=$rw["nombre"];
										$letra = $rw['letra'];
								?>
							<input type="hidden" class="form-control input-sm" name="id_vendedor" id="id_vendedor" value="<?php echo $id_vendedor?>" >
							<input type="text" class="form-control input-sm" name="vendedor" id="" value="<?php echo $nombre_vendedor?>" readonly>
							</div>

								<label for="letra" class="col-md-1 control-label">LETRA</label>
								<div class="col-md-1" id="letras">
								<input type='text' class='form-control input-sm' name='letra_ventas ' id='letra_ventas' readonly value="<?php echo $letra?>" >
								
									</div>
							</div>
							<div class="form-group row">

					<label for="diagnostico" class="col-md-1 control-label">Diagnostico:</label>
								<div class="col-md-6">
									<textarea name="diagnostico" class="form-control input-sm" rows="3" cols="10" id="diagnostico"  ><?php echo $diagnostico; ?></textarea>
								</div>
							</div>		
			</div>
			</div>
				<div class="col-md-12">
					<div class="pull-right">
						
				
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						<button type="submit" class="btn btn-default" onclick="load(1)">
						  <span class="glyphicon glyphicon-refresh"></span> Actualizar
						</button>
					</div>	
				</div>
			</form>	
			<div class="clearfix"></div>
		<div class="editar_servicio" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
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
	<!--<script type="text/javascript" src="js/editar_servicio.js"></script>-->
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
            $(document).ready(function(){
			load(1);
			var id_servicio=document.getElementById('id_servicio_2').value;
			var numero_servicio=document.getElementById('numero_servicio_2').value;
			$( "#resultados" ).load( "ajax/editar_facturacion_servicio.php?id_servicio="+id_servicio+"&numero_servicio="+numero_servicio);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/productos_servicio.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

		/*function editar_servicio(){
			var id_servicio=document.getElementById('id_servicio_2').value;
			var numero_servicio=document.getElementById('numero_servicio_2').value;
			$( "#resultados" ).load( "ajax/editar_facturacion_servicio.php?id_servicio="+id_servicio+"&numero_servicio="+numero_servicio);
		}*/

		function agregar (id)
{ 
  
 // var selectOS=document.getElementById('miHospital').value;
  //console.log(selectOS);
    var clave_hraei=document.getElementById('clave_hraei_'+id).value;
	var codigo=document.getElementById('codigo_'+id).value;
    var cantidad=document.getElementById('cantidad_'+id).value;
    var adicionales=document.getElementById('adicionales_'+id).value;
    var lote = document.getElementById('lote_'+id).value;
    var caducidad = document.getElementById('caducidad_'+id).value;

        //Inicia validacion
        if (isNaN(cantidad))
        {
        alert('Esto no es un numero');
        document.getElementById('cantidad_'+id).focus();
        if(cantidad == null || cantidad== ""){
            alert('Por favor ingresa una cantidad');
        document.getElementById('cantidad_'+id).focus();
        }
        return false;
        }
    $.ajax({
          type: "POST",
          url: "./ajax/editar_facturacion_servicio.php",
          data: "id="+id+"&cantidad="+cantidad+"&adicionales="+adicionales+"&lote="+lote+"&caducidad="+caducidad+"&clave_hraei="+clave_hraei+"&codigo="+codigo,
          beforeSend: function(objeto){
              $("#resultados").html("Mensaje: Cargando...");
            },
          success: function(datos){
          $("#resultados").html(datos);
          }
              });
              
   
 }
		
			function eliminar (id)
		{
			
			$.ajax({
        type: "GET",
        url: "./ajax/editar_facturacion_servicio.php",
        data: "id="+id,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});

		}

		
		$("#datos_servicio").submit(function(event){
			var $id_cliente = $("#id_cliente").val();
			var $id_servicio=$("#id_servicio");
			var	$derecho_habiente=$("#derechoh").val();
			var	$fecha_cirugia=$("#fecha_cirugia").val();
			var $nombre_cirujano=$("#nombre_cirujano");
			var $nombre_cirugia=$("#nombre_cirugia");
			var	$paterno=$("#paterno").val();
			var	$materno=$("#materno").val();
			var	$nombre_paciente=$("#nombre_paciente").val();
			var	$fecha_nacimiento=$("#fecha_nacimiento").val();
			var $expediente=$("#expediente").val();
			var	$sexo=$("#sexo").val();
			var	$edad=$("#edad").val();
			var	$sala=$("#sala").val();
			var	$h_inicio=$("#h_inicio").val();
			var	$h_termino=$("#h_termino").val();
			var	$turno=$("#turno").val();
			var	$id_vendedor=$("#id_vendedor").val();
			var	$letra_ventas=$("#letra_ventas").val();
			var $diagnostico=$("#diagnostico").val();
			
		  if (id_cliente==""){
			  alert("Debes seleccionar un cliente");
			  $("#nombre_cliente").focus();
			  return false;
		  }
		  var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/editar_servicio.php",
					data: parametros,
					 beforeSend: function(objeto){
						$(".editar_servicio").html("Mensaje: Cargando...");
					  },
					success: function(datos){
						$(".editar_servicio").html(datos);
					}
			});
			
			event.preventDefault();
	 	});
		
		$( "#guardar_cliente" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nuevo_cliente.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
		})
		
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

		function imprimir_servicio(id_servicio, numero_servicio){
			VentanaCentrada('./pdf/documentos/ver_servicio.php?id_servicio='+id_servicio+'&numero_servicio='+numero_servicio);
		}

			



	</script>

  </body>
</html>