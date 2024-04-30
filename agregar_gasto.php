<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	$active_facturas="";
	$active_productos="";
	$active_servicios="";
    $active_finanzas="active";
	$active_clientes="";
	$active_usuarios="";	
	$title="SUMED";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

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
        <h4><i class='glyphicon glyphicon-edit'></i> <?php echo $usuario;?>Nuevo Gasto</h4>

        </div>
  <div class="panel-body">
      <form id="facturacionForm" class="form-horizontal"  method="post" action="nuevo_gasto.php">
          <div class="form-group row">
                  <center><label class="subtitulo">Ingresa tu XML para que los datos se llenen automáticamente O en caso de tener Autorización subir el Ticket o Comprobante</label></center>
                  <br>
                    <label class="col-md-1 control-label" for="xml">XML:</label>
                  <div class="col-md-2">
                    <input class="form-control input-sm" type="file" accept=".xml" id="xml" name="xml" required class="form-control">
                  </div>

                    <label class="col-md-1 control-label" for="autorizacion">Autorización:</label>
                  <div class="col-md-2">
                    <input class="form-control input-sm" type="file" accept=".png, .jpg, .jpeg" id="autorizacion" name="autorizacion" class="form-control">
                  </div>
            </div>

  <!-- <center><h1 class="titulo-formulario">Formulario de Gasto</h1></center> -->

  <div class="form-group row">
            
        <div class="form-group">
          <label for="fecha">Fecha:</label>
          <input type="text" id="fecha" name="fecha" readonly class="form-control">
        </div>
        <div class="form-group">
          <label for="rfc">RFC:</label>
          <input type="text" id="rfc" name="rfc" readonly class="form-control">
        </div>
        <div class="form-group">
          <label for="proveedor">Nombre del Proveedor:</label>
          <input type="text" id="proveedor" name="proveedor" readonly class="form-control">
        </div>
        <div class="form-group">
          <label for="uuid">UUID:</label>
          <input type="text" id="uuid" name="uuid" readonly class="form-control">
        </div>
        <div class="form-group">
          <label for="folio">Folio:</label>
          <input type="text" id="folio" name="folio" readonly class="form-control">
        </div>
        <div class="form-group">
          <label for="referencia">Referencia:</label>
          <select id="referencia" name="referencia" class="form-control">
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
          </select>
        </div>
        <div class="form-group">
          <label for="observacion">Observación:</label>
          <textarea id="observacion" name="observacion" required class="form-control"></textarea>
        </div>
        <div class="form-group">
          <label for="subtotal">Subtotal:</label>
          <input type="text" id="subtotal" name="subtotal" readonly class="form-control">
        </div>
        <div class="form-group">
          <label for="iva">IVA:</label>
          <input type="text" id="iva" name="iva" readonly class="form-control">
        </div>
        <div class="form-group">
            <label for="total">Total:</label>
            <input type="text" id="total" name="total" readonly class="form-control">
        </div>
        <div class="form-group">
          <label for="pdf">PDF:</label>
          <input type="file" accept=".pdf" id="pdf" name="pdf" class="form-control">
        </div>
        <div class="form-group">
          <label for="comprobante">Comprobante:</label>
          <input type="file" accept=".png, .jpg, .jpeg" id="comprobante" name="comprobante" class="form-control">
        </div>
        
        <button type="submit" class="btn btn-info">Agregar Gasto</button>
  </form>
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
      document.getElementById('fecha').value = xmlDoc.getElementsByTagName('tfd:TimbreFiscalDigital')[0].getAttribute('FechaTimbrado');
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
    facturacionForm.addEventListener("submit", function(event) {
      var xmlFile = document.getElementById("xml").files[0];
      var pdfFile = document.getElementById("pdf").files[0];
      var autorizacionFile = document.getElementById("autorizacion").files[0];
      var comprobanteFile = document.getElementById("comprobante").files[0];

      // Si se ha seleccionado un XML, se requiere el PDF
      if (xmlFile && !pdfFile) {
        event.preventDefault();
        alert("Por favor, adjunta el PDF correspondiente al XML.");
      }

      // Si se ha seleccionado una autorización, se requiere el comprobante
      if (autorizacionFile && !comprobanteFile) {
        event.preventDefault();
        alert("Por favor, adjunta el comprobante correspondiente a la autorización.");
      }
    });
  });


  document.addEventListener("DOMContentLoaded", function() {
    var xmlInput = document.getElementById("xml");
    var autorizacionInput = document.getElementById("autorizacion");
    var comprobanteInput = document.getElementById("comprobante");

    xmlInput.addEventListener("change", function() {
      if (xmlInput.files.length > 0) {
        // Si se selecciona un XML, deshabilita el campo de autorización y comprobante
        autorizacionInput.disabled = true;
        comprobanteInput.disabled = true;
      } else {
        // Si no se selecciona un XML, habilita el campo de autorización y comprobante
        autorizacionInput.disabled = false;
        comprobanteInput.disabled = false;
      }
    });

    autorizacionInput.addEventListener("change", function() {
      if (autorizacionInput.files.length > 0) {
        // Si se selecciona una autorización, deshabilita el campo de XML y comprobante
        xmlInput.disabled = true;
        pdfFile.disabled = true;
      } else {
        // Si no se selecciona una autorización, habilita el campo de XML y comprobante
        xmlInput.disabled = false;
        pdfFile.disabled = false;
      }
    });

    comprobanteInput.addEventListener("change", function() {
      if (comprobanteInput.files.length > 0) {
        // Si se selecciona un comprobante, deshabilita el campo de XML y autorización
        xmlInput.disabled = true;
        autorizacionInput.disabled = true;
      } else {
        // Si no se selecciona un comprobante, habilita el campo de XML y autorización
        xmlInput.disabled = false;
        autorizacionInput.disabled = false;
      }
    });
  });

  document.addEventListener("DOMContentLoaded", function() {
    var xmlInput = document.getElementById("xml");
    var autorizacionInput = document.getElementById("autorizacion");
    var comprobanteInput = document.getElementById("comprobante");
    var referenciaSelect = document.getElementById("referencia");
    var observacionTextarea = document.getElementById("observacion");

    autorizacionInput.addEventListener("change", function() {
      if (autorizacionInput.files.length > 0) {
        // Si se selecciona una autorización, deshabilita todos los campos excepto el de observación
        xmlInput.disabled = true;
        comprobanteInput.disabled = true;
        referenciaSelect.disabled = true;
        referenciaSelect.value = "Otros"; // Selecciona automáticamente "Otros" en el campo de referencia
        observacionTextarea.value = ""; // Llena la observación con un mensaje
      } else {
        // Si no se selecciona una autorización, habilita todos los campos
        xmlInput.disabled = false;
        comprobanteInput.disabled = true;
        referenciaSelect.disabled = false;
        observacionTextarea.value = ""; // Limpia la observación
      }
    });
  });
</script>

</body>
</html>