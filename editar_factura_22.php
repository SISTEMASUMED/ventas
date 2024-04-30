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
	
	if (isset($_GET['id_factura']))
	{
		$id_factura=intval($_GET['id_factura']);
		$sql_factura=mysqli_query($con,"select * from facturas, clientes where facturas.id_cliente=clientes.id_cliente and id_factura='".$id_factura."'");
		$count=mysqli_num_rows($sql_factura);
		if ($count==1)
		{
				$rw_factura=mysqli_fetch_array($sql_factura);
				$id_cliente=$rw_factura['id_cliente'];
				$nombre_cliente=$rw_factura['nombre_cliente'];
				$calle=$rw_factura['calle'];
				$colonia=$rw_factura['colonia'];
				$num_ext=$rw_factura['numext'];
				$rfc=$rw_factura['rfc'];
				$telefono_cliente=$rw_factura['telefono'];
				$email_cliente=$rw_factura['emailpred'];
				$id_vendedor_db=$rw_factura['id_vendedor'];
				$fecha_factura=date("d/m/Y", strtotime($rw_factura['fecha_factura']));
				$estado_factura=$rw_factura['estado_factura'];
				$numero_factura=$rw_factura['numero_factura'];
				$compra=$rw_factura['compra'];
				$cotizacion=$rw_factura['cotizacion'];
				$doctor=$rw_factura['doctor'];
				$paciente=$rw_factura['paciente'];
				$material=$rw_factura['material'];
				$pago=$rw_factura['pago'];
				$d_factura=$rw_factura['d_factura'];
				$observaciones=$rw_factura['observaciones'];
				$_SESSION['id_factura']=$id_factura;
				$_SESSION['numero_factura']=$numero_factura;
		}	
		else
		{
			header("location: facturas.php");
			exit;	
		}
	} 
	else 
	{
		header("location: facturas.php");
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
			<h4><i class='glyphicon glyphicon-edit'></i> Editar Remisión</h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
		?>
			<form class="form-horizontal" role="form" id="datos_factura">
				<div class="form-group row">
				  <label for="nombre_cliente" class="col-md-1 control-label">Cliente</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" placeholder="Selecciona un cliente" required value="<?php echo $nombre_cliente;?>">
					  <input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $id_cliente;?>">
					  	
				  </div>
				 <label for="direccion" class="col-md-1 control-label">Calle</label>
				  <div class="col-md-2">
					  <input type="text" class="form-control input-sm" name="calle" id="calle_cliente" value="<?php echo $calle;?>" placeholder="Calle" readonly >
				  </div>
				  <label for="numext" class="col-md-1 control-label">No.EXT</label>
				  <div class="col-md-1">
					  <input type="text" class="form-control input-sm" name="numext" id="numext_cliente" value="<?php echo $num_ext;?>" placeholder="No. EXT" readonly>
				  </div>
				  <label for="colonia" class="col-md-1 control-label">Colonia</label>
				  <div class="col-md-2">
					  <input type="text" class="form-control input-sm" name="colonia" id="colonia_cliente" value="<?php echo $colonia;?>" placeholder="Colonia" readonly>
				  </div>
				</div>
				<div class="form-group row">
				  <label for="rfc" class="col-sm-1 control-label">RFC</label>
							<div class="col-md-2">
								<input type="text" name="rfc" class="form-control input-sm" id="rfc_cliente" value="<?php echo $rfc;?>" placeholder="RFC" readonly>
							</div>
				  <label for="telefono_cliente" class="col-md-1 control-label">Teléfono</label>
							<div class="col-md-2">
								<input type="text" name="telefono_cliente" class="form-control input-sm" id="telefono_cliente" value="<?php echo $telefono_cliente;?>" placeholder="Teléfono" readonly>
							</div>
					<label for="mail" class="col-md-1 control-label">Email</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" name="mail" id="mail" value="<?php echo $email_cliente;?>" placeholder="Email" readonly>
							</div>
							<label for="tel2" class="col-md-1 control-label">Fecha</label>
							<div class="col-md-1">
								<input type="text" class="form-control input-sm" name="fecha" id="fecha" value="<?php echo $fecha_factura;?>" readonly>
							</div>
				 </div>
						<div class="form-group row">
						<label for="compra" class="col-md-1 control-label">Orden de compra</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" name="compra" id="compra" value="<?php echo $compra;?>" placeholder="Orden de compra:">
							</div>
							<label for="cotizacion" class="col-md-1 control-label">Cotización no.</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" name="cotizacion" id="cotizacion" value="<?php echo $cotizacion;?>" placeholder="Cotización" >
							</div>

							<label for="doctor" class="col-md-1 control-label">Doctor</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" name="doctor" id="doctor" value="<?php echo $doctor;?>" placeholder="Nombre del Doctor" >
							</div>

							<label for="paciente" class="col-md-1 control-label">Paciente</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" name="paciente" id="paciente" value="<?php echo $paciente;?>" placeholder="Paciente" >
							</div>
					</div>

					<div class="form-group row">
							<label for="empresa" class="col-md-1 control-label">Vendedor</label>
							<div class="col-md-2">	
							<?php
							$sql_vendedor=mysqli_query($con,"select * from users where user_id = $id_vendedor_db");
							$rw = mysqli_fetch_array($sql_vendedor);
							$nombre_vendedor=$rw["nombre"];
							$letra = $rw['letra'];
							?>
							<input type="hidden" class="form-control input-sm" name="id_vendedor" id="id_vendedor" value="<?php echo $id_vendedor_db?>" >
							<input type="text" class="form-control input-sm" name="vendedor" id="vendedor" value="<?php echo $nombre_vendedor?>" readonly>
							<input type="hidden" class="form-control input-sm" name="numero_factura2" id="numero_factura2" value="<?php echo $numero_factura?>" >
							
							</div>

								<label for="letra" class="col-md-1 control-label">LETRA</label>
								<div class="col-sm-1" id="letras">
								<input type='text' class='form-control input-sm' name='letra_ventas ' id='letra_ventas' readonly value="<?php echo $letra?>" >
								
									</div>
									<label for="material" class="col-md-1 control-label">Material de:</label>
									<div class="col-sm-1">
										<select class='form-control input-sm ' id="material" name="material">
											<option selected><?php echo $material;?></option>
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
										<option selected><?php echo $pago;?></option>
											<option value="Efectivo" >Efectivo</option>
											<option value="Transferencia" >Transferencia</option>
											<option value="Crédito" >Crédito</option>
											</option>
										</select>
									</div>
									
									<label for="d_factura" class="col-sm-1 control-label">Factura</label>
									<div class="col-sm-1">
										<select class='form-control input-sm ' id="d_factura" name="d_factura">
										<option selected><?php echo $d_factura;?></option>
											<option value="SI" >SI</option>
											<option value="PUBLICO EN GENERAL" >PUBLICO EN GENERAL</option>
											</option>
										</select>
										</div>
									</div>
									<div class="form-group row">
									<label for="letra" class="col-md-1 control-label">Observaciones</label>
								<div class="col-sm-2" id="letras">
								<textarea name="observaciones" id="observaciones" rows="3" cols="25" value=""><?php echo $observaciones;?></textarea>
								</div>	
							</div>
			</div>
			</div>
				
				<div class="col-md-12">
					<div class="pull-right">
						<!--<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-refresh"></span> Actualizar datos
						</button>-->
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoProducto">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo producto
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoCliente">
						 <span class="glyphicon glyphicon-user"></span> Nuevo cliente
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
						<button type="submit" class="btn btn-default" >
						  <span class="glyphicon glyphicon-print"></span> Actualizar
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
	<!--<script type="text/javascript" src="js/editar_factura.js"></script>-->
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
			$(document).ready(function(){
			load(1);
			$( "#resultados" ).load( "ajax/editar_facturacion.php" );
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/productos_factura.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	function agregar (id)
		{
			var precio_venta=document.getElementById('precio_venta_'+id).value;
			var cantidad=document.getElementById('cantidad_'+id).value;
			var lote=document.getElementById('lote_'+id).value;
			var referencia=document.getElementById('referencia_'+id).value;
			var almacen=document.getElementById('almacen_'+id).value;

			
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
			if (isNaN(precio_venta)|| precio_venta ==null || precio_venta =="")
			{
			alert('Esto no es un numero');
			document.getElementById('precio_venta_'+id).focus();
			if(precio_venta==null || precio_venta==""){
				alert('Por favor ingresa un precio');
			document.getElementById('precio_'+id).focus();
			}
			return false;
			}
			if (lote == null || lote == "")
			{
			alert('Por favor ingresa el lote');
			document.getElementById('lote_'+id).focus();
			return false;
			}
			//Fin validacion
			//newid= id.split("/");
			//res=newid[0];
			//indice = id.indexOf("/");
			//let extraida = id.substring(0,indice);
			
			$.ajax({
        type: "POST",
        url: "./ajax/editar_facturacion.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&lote="+lote+"&referencia="+referencia+"&almacen="+almacen,
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
        url: "./ajax/editar_facturacion.php",
        data: "id="+id,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});

		}
		
 $("#datos_factura").submit(function(event){

		  if (id_cliente==""){
			  alert("Debes seleccionar un cliente");
			  $("#nombre_cliente").focus();
			  return false;
		  }
		  var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/editar_factura.php",
					data: parametros,
					 beforeSend: function(objeto){
						$(".editar_factura").html("Mensaje: Cargando...");
					  },
					success: function(datos){
						$(".editar_factura").html(datos);
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

		/*function imprimir_factura(id_factura, numero_factura){
			VentanaCentrada('./pdf/documentos/ver_factura2.php?id_factura='+id_factura+'&numero_factura='+numero_factura);
		}*/

	</script>

  </body>
</html>