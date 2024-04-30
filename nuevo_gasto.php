<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "remisiones";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
  die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Obtener datos del formulario
$fecha = $_POST['fecha'];
$rfc = $_POST['rfc'];
$proveedor = $_POST['proveedor'];
$uuid = $_POST['uuid'];
$folio = $_POST['folio'];
$referencia = $_POST['referencia'];
$observacion = $_POST['observacion'];
$subtotal = $_POST['subtotal'];
$iva = $_POST['iva'];
$total = $_POST['total'];

// Verificar si ya existe un registro con el mismo UUID
$sql_check = "SELECT COUNT(*) AS count FROM finanzas WHERE uuid = '$uuid'";
$result_check = $conn->query($sql_check);
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] > 0) {
  // Mostrar alerta si ya existe un registro con el mismo UUID
  echo "<script>alert('Ya existe una factura con el mismo UUID. No se puede facturar dos veces la misma factura.'); window.location.href = 'gastos.php';</script>";
} else {
  // Insertar datos en la base de datos si no existe un registro con el mismo UUID
  $sql = "INSERT INTO finanzas (fecha, rfc, proveedor, uuid, folio, referencia, observacion, subtotal, iva, total)
  VALUES ('$fecha', '$rfc', '$proveedor', '$uuid', '$folio', '$referencia', '$observacion', '$subtotal', '$iva', '$total')";

  if ($conn->query($sql) === TRUE) {
    // Mostrar alerta de éxito
    echo "<script>alert('Datos guardados exitosamente.'); window.location.href = 'gastos.php';</script>";
  } else {
    // Mostrar alerta de error
    echo "<script>alert('Error al guardar los datos: " . $conn->error . "');</script>";
  }
}

// Cerrar conexión
$conn->close();
?>
