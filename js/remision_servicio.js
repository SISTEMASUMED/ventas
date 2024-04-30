
$(document).ready(function(){
    load(1);
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

function agregar (id)
{ 
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
          url: "./ajax/agregrar_facturacion_servicio.php",
          data: "id="+id+"&cantidad="+cantidad+"&adicionales="+adicionales+"&lote="+lote+"&caducidad="+caducidad,
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
url: "./ajax/agregrar_facturacion_servicio.php",
data: "id="+id,
 beforeSend: function(objeto){
    $("#resultados").html("Mensaje: Cargando...");
  },
success: function(datos){
$("#resultados").html(datos);
}
    });

}

$("#datos_servicio").submit(function(){
var id_cliente = $("#id_cliente").val();
var	derecho_habiente=$("#derechoh").val();
var	fecha_cirugia=$("#fecha_cirugia").val();
var nombre_cirugia = $("#nombre_cirugia").val();
var nombre_cirujano = $("#nombre_cirujano").val();
var	paterno=$("#paterno").val();
var	materno=$("#materno").val();
var	nombre_paciente=$("#nombre_paciente").val();
var	fecha_nacimiento=$("#fecha_nacimiento").val();
var expediente=$("#expediente").val();
var	sexo=$("#sexo").val();
var edad=$("#edad").val();
var	sala=$("#sala").val();
var h_inicio=$("#h_inicio").val();
var	h_termino=$("#h_termino").val();
var	turno=$("#turno").val();
var	id_vendedor=$("#id_vendedor").val();
var	letra_ventas=$("#letra_ventas").val();
var diagnostico=$("#diagnostico").val();
  
  if (id_cliente==""){
    alert("Debes seleccionar un cliente");
    $("#nombre_cliente").focus();
    return false;
  }
  VentanaCentrada('./pdf/documentos/servicios_pdf.php?id_cliente='+id_cliente+'&derecho_habiente='+derecho_habiente+'&fecha_cirugia='+fecha_cirugia+'&paterno='+paterno+'&materno='+materno+'&nombre_paciente='+nombre_paciente+'&fecha_nacimiento='+fecha_nacimiento+'&expediente='+expediente+'&sexo='+sexo+'&edad='+edad+'&sala='+sala+'&h_inicio='+h_inicio+'&h_termino='+h_termino+'&turno='+turno+'&id_vendedor='+id_vendedor+'&letra_ventas='+letra_ventas+'&diagnostico='+diagnostico+'&nombre_cirugia='+nombre_cirugia+'&nombre_cirujano='+nombre_cirujano);
   
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
