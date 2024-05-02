<?php
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
      header("location: login.php");
  exit;
      }

      require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
      require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
      
// Configuración de la conexión a la base de datos
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "remisiones";

// Crear conexión
// $con = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($con->connect_error) {
  die("Error de conexión a la base de datos: " . $con->connect_error);
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
$fechaFormateada = $_POST['fechaFormateada'];

// Verificar si ya existe un registro con el mismo UUID
$sql_check = "SELECT COUNT(*) AS count FROM finanzas WHERE uuid = '$uuid'";
$result_check = $con->query($sql_check);
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] > 0) {
  // Mostrar alerta si ya existe un registro con el mismo UUID
  echo "<script>alert('Ya existe una factura con el mismo UUID. No se puede facturar dos veces la misma factura.'); window.location.href = 'gastos.php';</script>";
} else {
  // Insertar datos en la base de datos si no existe un registro con el mismo UUID
  $sql = "INSERT INTO finanzas (fecha, rfc, proveedor, uuid, folio, referencia, observacion, subtotal, iva, total)
  VALUES ('$fechaFormateada', '$rfc', '$proveedor', '$uuid', '$folio', '$referencia', '$observacion', '$subtotal', '$iva', '$total')";

  if ($con->query($sql) === TRUE) {
    // Mostrar alerta de éxito
    echo "<script>alert('Datos guardados exitosamente.'); window.location.href = 'gastos.php';</script>";
  } else {
    // Mostrar alerta de error
    echo "<script>alert('Error al guardar los datos: " . $con->error . "');</script>";
  }
}

// Cerrar conexión
$con->close();
?>
