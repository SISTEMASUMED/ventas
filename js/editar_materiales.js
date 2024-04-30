$(document).ready(function(){
    load(1);
    var numero_servicio=document.getElementById('numero_servicio').value;
    var id_vendedor=document.getElementById('id_vendedor').value;
    var id_servicio=document.getElementById('id_servicio').value;
    $( "#resultados" ).load( "ajax/editar_materiales.php?id_vendedor="+id_vendedor+"&numero_servicio="+numero_servicio+"&id_servicio="+id_servicio);
});

function load(page){
  var id_servicio=$("#id_servicio").val();
  var numero_servicio=$("#numero_servicio").val();
  var id_vendedor=$("#id_vendedor").val();
  
    var q= $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url:'./ajax/productos_materiales_servicio.php?action=ajax&page='+page+'&q='+q+'&id_servicio='+id_servicio+'&numero_servicio='+numero_servicio+'&id_vendedor='+id_vendedor,
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
  var numero_servicio=document.getElementById('numero_servicio').value;
  var id_vendedor=document.getElementById('id_vendedor').value;
  var id_servicio=document.getElementById('id_servicio').value;
    
    var cantidad=document.getElementById('cantidad_'+id).value;
    var provedor=document.getElementById('provedor_'+id).value;
    var lote=document.getElementById('lote_'+id).value;
    var referencia=document.getElementById('referencia_'+id).value;
    var procedimiento=document.getElementById('procedimiento_'+id).value;
    var almacen=document.getElementById('almacen_'+id).value;

    //Inicia validacion
    
  if (procedimiento == null || procedimiento == ""){
    alert('Por favor selecciona un procedimiento');
    document.getElementById('procedimiento_'+id).focus();
    return false;
  }
  if (almacen == null || almacen == ""){
    alert('Por favor selecciona un almacen');
      document.getElementById('almacen_'+id).focus();
      return false;
    }
    if (lote == null || lote == "")
    {
    alert('Por favor ingresa el lote');
    document.getElementById('lote_'+id).focus();
    return false;
    }
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
  if (provedor== null ||  provedor == ""){
    alert('Por favor ingresa un provedor');
    return false;
  }
 
    
    //Fin validacion
    //newid= id.split("/");
    //res=newid[0];
    //indice = id.indexOf("/");
    //let extraida = id.substring(0,indice);

$.ajax({
type: "POST",
url: "./ajax/editar_materiales.php",
data: "id="+id+"&cantidad="+cantidad+"&lote="+lote+"&referencia="+referencia+"&almacen="+almacen+"&procedimiento="+procedimiento+"&provedor="+provedor+'&id_servicio='+id_servicio+'&numero_servicio='+numero_servicio+'&id_vendedor='+id_vendedor,
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
  
console.log(id);
$.ajax({
type: "GET",
url: "./ajax/editar_materiales.php",
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

  id_servicio=$('#id_servicio').val();
  numero_servicio=$('#numero_servicio').val();
  id_vendedor=$('#id_vendedor').val();

alert('materiales editados exitosamente');
VentanaCentrada('./servicios_integrales.php');

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