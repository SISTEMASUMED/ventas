<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
        $active_facturas="";
        $active_productos="";
        $active_servicios="";
        $active_finanzas="active-link";
        $active_clientes="";
        $active_usuarios="";	
        $title="SUMED";
        $usuario = $_SESSION['user_id'];
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php 
include("head.php");?>
</head>
<body>

<?php
	include("navbar.php");

	?>  
<div class="container-fluid">
  <div class="panel panel-info">
    <div class="panel-heading">
      <h4>
        <i class="glyphicon glyphicon-edit"></i> <?php echo $usuario;?>Nuevo Gasto</h4>
    </div>

    <div class="panel-body">
      <form id="facturacionForm" class="form-horizontal" action="nuevo_gasto.php" method="post">
        <div class="form-group row">    <!-- primer group -->
          <center><label class="subtitulo">Ingresa tu XML para que los datos se llenen automáticamente O en caso de tener Autorización subir el Ticket o Comprobante</label></center>
          <br>
            <label class="col-md-1 control-label" for="xml">XML:</label>
            <div class="col-md-2">
              <input class="form-control input-sm" type="file" accept=".xml" id="xml" name="xml" required class="form-control">
            </div>
            <div class="col-md-1">

            </div>
            <div class="col-md-1">

            </div>
            <div class="col-md-1">
              
            </div>

            <label class="col-md-1 control-label" for="autorizacion">Autorización:</label>
            <div class="col-md-2">
              <input class="form-control input-sm" type="file" accept=".png, .jpg, .jpeg" id="autorizacion" name="autorizacion" class="form-control">
            </div>
        </div>     <!-- primer group -->

        <hr class="style13">

        <div class="form-group row"> <!-- segundo group -->
          <label for="proveedor" class="col-sm-1 control-label">Nombre del Proveedor:</label>
            <div class="col-md-3">
              <input type="text" id="proveedor" name="proveedor" readonly class="form-control input-sm">
            </div>
            <label for="rfc" class="col-sm-1 control-label">RFC:</label>
            <div class="col-md-2">
              <input type="text" id="rfc" name="rfc" readonly class="form-control input-sm">
            </div>
            <label for="fecha" class="col-sm-1 control-label">Fecha:</label>
            <div class="col-md-2">
              <input type="text" id="fecha" name="fecha" readonly class="form-control input-sm" value="">
              <input type="hidden" id="fechaFormateada" name="fechaFormateada" value="<?php echo $fechaFormateada; ?>">
            </div>
         
        </div>     <!-- segundo group -->

        <div class="form-group row"> <!-- tercer group -->

        <label for="referencia" class="col-sm-1 control-label">Referencia:</label>
          <div class="col-md-3">
            <select id="referencia" name="referencia" class="form-control select-sm">
              <option value="" selected disabled>--Selecciona una opción--</option>
              <option value="Viaticos Alimenticios">Viáticos Alimenticios</option>
              <option value="Pasaje o Transporte">Pasaje o Transporte</option>
              <option value="Casetas">Casetas</option>
              <option value="Combustible">Combustible</option>
              <option value="Hospedaje">Hospedaje</option>
              <option value="Mensajería">Mensajería</option>
              <option value="Cortesia (Doctores o Hospitales)">Cortesía (Doctores o Hospitales)</option>
              <option value="Estacionamiento">Estacionamiento</option>
              <option value="Papelería y Artículos">Papelería y Artículos</option>
              <option value="Otros">Otros</option>
            </select required>
          </div>
          <label for="folio" class="col-sm-1 control-label">Folio:</label>
            <div class="col-md-2">
              <input type="text" id="folio" name="folio" readonly class="form-control input-sm">
            </div>
          
            <label for="uuid" class="col-sm-1 control-label">UUID:</label>
            <div class="col-md-2">
              <input type="text" id="uuid" name="uuid" readonly class="form-control input-sm">
            </div>
        </div>  <!-- tercer group -->

        <div class="form-group row">    <!-- cuarto group -->
         
          <label for="subtotal" class="col-sm-1 control-label">Subtotal: $</label>
            <div class="col-md-3">
              <input type="text" id="subtotal" name="subtotal" readonly class="form-control input-sm">
            </div>
          <label for="iva" class="col-sm-1 control-label">IVA: $</label>
            <div class="col-md-2">
              <input type="text" id="iva" name="iva" readonly class="form-control input-sm">
            </div>
          <label for="total" class="col-sm-1 control-label">Total: $</label>
            <div class="col-md-2">
              <input type="text" id="total" name="total" readonly class="form-control input-sm">
            </div>

        </div>  <!-- cuarto group -->

        <div class="form-group row">   <!-- quinto group -->
          
          <label for="pdf" class="col-sm-1 control-label">PDF:</label>
            <div class="col-md-3">
              <input type="file" accept=".pdf" id="pdf" name="pdf" class="form-control input-sm">
            </div>
          <label for="comprobante" class="col-sm-1 control-label">Comprobante:</label>
          <div class="col-md-2">
            <input type="file" accept=".png, .jpg, .jpeg" id="comprobante" name="comprobante" class="form-control input-sm">
          </div>
          <label for="observacion" class="col-sm-1 control-label">Observación:</label>
            <div class="col-md-2">
              <textarea id="observacion" name="observacion" required class="form-control textarea-sm"></textarea>
            </div>
        </div>  <!-- quinto group -->

        <button type="submit" style="margin-left:30%; margin-top:2%;" class="btn  btn-info">Agregar Gasto</button>

      </form>
    </div>
  </div>
</div>

<script>
  document.getElementById('xml').addEventListener('change', handleXMLFile);

  function handleXMLFile(event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = function(e) {
      const xmlContent = e.target.result;
      const parser = new DOMParser();
      const xmlDoc = parser.parseFromString(xmlContent, 'text/xml');
      //hay que formatear la fecha para que aparezca de forma correcta al cargar el xml
      var fecha= xmlDoc.getElementsByTagName('tfd:TimbreFiscalDigital')[0].getAttribute('FechaTimbrado');
      var fechaFormateada=moment(fecha).format('DD/MM/YYYY');
      //document.getElementById('fecha').value = xmlDoc.getElementsByTagName('tfd:TimbreFiscalDigital')[0].getAttribute('FechaTimbrado');
      document.getElementById('fecha').value = fechaFormateada;
      document.getElementById('fechaFormateada').value = xmlDoc.getElementsByTagName('tfd:TimbreFiscalDigital')[0].getAttribute('FechaTimbrado');
      document.getElementById('rfc').value = xmlDoc.getElementsByTagName('cfdi:Emisor')[0].getAttribute('Rfc');
      document.getElementById('proveedor').value = xmlDoc.getElementsByTagName('cfdi:Emisor')[0].getAttribute('Nombre');
      document.getElementById('uuid').value = xmlDoc.getElementsByTagName('tfd:TimbreFiscalDigital')[0].getAttribute('UUID');
      document.getElementById('folio').value = xmlDoc.getElementsByTagName('cfdi:Comprobante')[0].getAttribute('Folio');
      document.getElementById('subtotal').value = xmlDoc.getElementsByTagName('cfdi:Comprobante')[0].getAttribute('SubTotal');
      document.getElementById('iva').value = xmlDoc.getElementsByTagName('cfdi:Traslado')[0].getAttribute('Importe');
      document.getElementById('total').value = xmlDoc.getElementsByTagName('cfdi:Comprobante')[0].getAttribute('Total');
    };
    reader.readAsText(file);
  }

  document.addEventListener("DOMContentLoaded", function() {
    var facturacionForm = document.getElementById("facturacionForm");
    var xmlInput = document.getElementById("xml");
    var pdfInput = document.getElementById("pdf");
    var autorizacionInput = document.getElementById("autorizacion");
    var comprobanteInput = document.getElementById("comprobante");
    var referenciaSelect = document.getElementById("referencia");

    facturacionForm.addEventListener("submit", function(event) {
        if (xmlInput.files.length > 0 && pdfInput.files.length === 0) {
            event.preventDefault();
            alert("Por favor, adjunta el PDF correspondiente al XML.");
        }
        if (autorizacionInput.files.length > 0 && comprobanteInput.files.length === 0) {
            event.preventDefault();
            alert("Por favor, adjunta el comprobante correspondiente a la autorización.");
        }
    });

    xmlInput.addEventListener("change", function() {
        if (xmlInput.files.length > 0) {
            pdfInput.disabled = false;
            comprobanteInput.disabled = true;
            autorizacionInput.disabled = true;

            // Limpiar campos si se selecciona primero el XML y luego la autorización
            proveedorInput.value = ""; // Limpiar el campo de proveedor
            rfcInput.value = ""; // Limpiar el campo de RFC

        } else {
            pdfInput.disabled = true;
            comprobanteInput.disabled = false;
            autorizacionInput.disabled = false;
        }
    });

    autorizacionInput.addEventListener("change", function() {
        if (autorizacionInput.files.length > 0) {
            comprobanteInput.disabled = false;
            xmlInput.disabled = true;
            pdfInput.disabled = true;
            referenciaSelect.value = "Otros"; // Selecciona automáticamente "Otros" en el campo de referencia
        } else {
            comprobanteInput.disabled = true;
            xmlInput.disabled = false;
            pdfInput.disabled = false;
            referenciaSelect.value = ""; // Limpia la selección en el campo de referencia
        }
    });
})

document.addEventListener("DOMContentLoaded", function() {
    var xmlInput = document.getElementById("xml");

    xmlInput.addEventListener("change", function() {
        if (!xmlInput.files || xmlInput.files.length === 0) {
            limpiarCampos();
        }
    });
});


function limpiarCampos() {
    // Limpiar campos de entrada de texto
    document.getElementById("proveedor").value = "";
    document.getElementById("rfc").value = "";
    document.getElementById("fecha").value = "";
    document.getElementById("fechaFormateada").value = "";
    document.getElementById("folio").value = "";
    document.getElementById("uuid").value = "";
    document.getElementById("subtotal").value = "";
    document.getElementById("iva").value = "";
    document.getElementById("total").value = "";
    document.getElementById("observacion").value = "";

    // Reiniciar selección de archivos
    document.getElementById("pdf").value = "";
    document.getElementById("autorizacion").value = "";
    document.getElementById("comprobante").value = "";

    // Reiniciar selección en el campo de referencia
    document.getElementById("referencia").value = "";

    // Habilitar campos de autorización y comprobante
    document.getElementById("autorizacion").disabled = false;
    document.getElementById("comprobante").disabled = false;

    // Deshabilitar campos de PDF
    document.getElementById("pdf").disabled = true;
}



</script>

  <?php
	  include("footer.php");
	?>

</body>
</html>