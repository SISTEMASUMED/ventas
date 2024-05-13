$(document).ready(function(){
    //load();
    
});

function load(){
    var inicio= $("#fecha_inicio").val();
    var final=  $("#fecha_fin").val();
    var id_cliente= $("#id_cliente").val();
    
    $("#loader").fadeIn('slow');
    $.ajax({
        url:'./ajax/buscar_reporte.php?fecha_inicio='+inicio+'&fecha_fin='+final+'&id_cliente='+id_cliente,
         beforeSend: function(objeto){
         $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
            console.log('esto funciona');
            
        }
    })
}
function load_excel(){
    
    var inicio= $("#fecha_inicio").val();
    var final=  $("#fecha_fin").val();
    var id_cliente= $("#id_cliente").val();
    if (inicio == "" || final == "" || id_cliente == "" ){
        alert("por favor llena todos los campos");
    }else{

    $("#loader").fadeIn('slow');
    $.ajax({
        url:'./ajax/buscar_reporte_excel.php?fecha_inicio='+inicio+'&fecha_fin='+final+'&id_cliente='+id_cliente,
         beforeSend: function(objeto){
         $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
            console.log('esto funciona');
            
            }
        })
    }
}


    function eliminar (id)
{
    var q= $("#q").val();
if (confirm("Realmente deseas cancelar esta remisión")){	
$.ajax({
type: "GET",
url: "../pdf/documentos/reporte_h_general__excel.php",
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

function descargar_excel(){
    var inicio= $("#fecha_inicio").val();
    var final=  $("#fecha_fin").val();
    var id_cliente= $("#id_cliente").val();
    if (inicio == "" || final == "" || id_cliente == "" ){
        alert("por favor llena todos los campos");
    }else{
    VentanaCentrada('./pdf/documentos/reporte_excel.php?fecha_inicio='+inicio+'&fecha_fin='+final+'&id_cliente='+id_cliente);
    }
}
