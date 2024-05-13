
		$(document).ready(function(){
			load(1);
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
			var caducidad=document.getElementById('caducidad_'+id).value;
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
			
			$.ajax({
        type: "POST",
        url: "./ajax/agregar_facturacion.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&lote="+lote+"&caducidad="+caducidad+"&referencia="+referencia+"&almacen="+almacen,
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
        url: "./ajax/agregar_facturacion.php",
        data: "id="+id,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});

		}
		
		$("#datos_factura").submit(function(){
		  var id_cliente = $("#id_cliente").val();
		  var id_vendedor = $("#id_vendedor").val();
		  var letra_ventas = $("#letra_ventas").val();
		  var compra = $("#compra").val();
		  var cotizacion = $("#cotizacion").val();
		  var doctor = $("#doctor").val();
		  var paciente = $("#paciente").val();
		  var material = $("#material").val();
		  var pago = $("#pago").val();
		  var d_factura = $("#d_factura").val();
		  var observaciones = $("#observaciones").val();

		  if (id_cliente==""){
			  alert("Debes seleccionar un cliente");
			  $("#nombre_cliente").focus();
			  return false;
		  }
		 VentanaCentrada('./pdf/documentos/factura_pdf.php?id_cliente='+id_cliente+'&id_vendedor='+id_vendedor+'&letra_ventas='+letra_ventas+'&compra='+compra+'&cotizacion='+cotizacion+'&doctor='+doctor+'&paciente='+paciente+'&material='+material+'&pago='+pago+'&d_factura='+d_factura+'&observaciones='+observaciones);
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

			

		$( "#guardar_envio" ).submit(function( event ) {
			$('#guardar_contacto').attr("disabled", true);
			
		   var parametros = $(this).serialize();
		   $.ajax({
				  type: "POST",
				  url: "ajax/nuevo_contacto.php",
				  data: parametros,
				   beforeSend: function(objeto){
					  $("#resultados_ajax_contacto").html("Mensaje: Cargando...");
					},
				  success: function(datos){ 
					console.log('estamos aki');
					load(1);
				  $("#resultados_ajax_contacto").html(datos);
				  $('#guardar_contacto').attr("disabled", false);
				  
				}
		  });
		event.preventDefault();
	  })