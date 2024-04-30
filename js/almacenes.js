$(document).ready(function(){
    load(1);
    
});

function load(page){
    var q= $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url:'./ajax/buscar_almacen.php?action=ajax&page='+page+'&q='+q,
         beforeSend: function(objeto){
         $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
            $('[data-toggle="tooltip"]').tooltip({html:true}); 
            
        }
    })
}

	
$( "#guardar_almacen" ).submit(function( event ) {
    $('#guardar_datos').attr("disabled", true);
    
   var parametros = $(this).serialize();
       $.ajax({
              type: "POST",
              url: "ajax/nuevo_almacen.php",
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



    function eliminar (id)
{
    var q= $("#q").val();
if (confirm("Realmente deseas eliminar este almacén")){	
$.ajax({
type: "GET",
url: "./ajax/buscar_almacen.php",
data: "id="+id,"q":q,
 beforeSend: function(objeto){
    $("#resultados").html("Mensaje: Cargando...");
  },
success: function(datos){
$("#resultados").html(datos);
load(1);
}
    });
}
}
function descargar(id_factura, numero_factura){
    VentanaCentrada('./pdf/documentos/ver_factura_excel.php?id_factura='+id_factura+'&numero_factura='+numero_factura);
}
function imprimir_factura(id_factura, numero_factura){
    VentanaCentrada('./pdf/documentos/ver_factura.php?id_factura='+id_factura+'&numero_factura='+numero_factura);
}
function ver_factura(id_factura, numero_factura){
    VentanaCentrada('./pdf/documentos/ver_factura2.php?id_factura='+id_factura+'&numero_factura='+numero_factura);
}

