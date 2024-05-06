<?php
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
      header("location: login.php");
  exit;
      }

      require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
      require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
      

if ($con->connect_error) {
  die("Error de conexión a la base de datos: " . $con->connect_error);
}

// Obtener los datos del formulario de edición
$id = $_POST['id'];
$proveedor = $_POST['proveedor'];
$rfc = $_POST['rfc'];
$fecha = $_POST['fecha'];
$referencia = $_POST['referencia'];
$folio = $_POST['folio'];
$uuid = $_POST['uuid'];
$subtotal = $_POST['subtotal'];
$iva = $_POST['iva'];
$total = $_POST['total'];
$observacion = $_POST['observacion'];

// Actualizar los datos en la base de datos
$sql = "UPDATE finanzas SET ";
$sql .= "proveedor = '$proveedor', ";
$sql .= "rfc = '$rfc', ";
$sql .= "fecha = '$fecha', ";
$sql .= "referencia = '$referencia', ";
$sql .= "folio = '$folio', ";
$sql .= "uuid = '$uuid', ";
$sql .= "subtotal = '$subtotal', ";
$sql .= "iva = '$iva', ";
$sql .= "total = '$total', ";
$sql .= "observacion = '$observacion' ";
$sql .= " WHERE id = $id";





if ($con->query($sql) === TRUE) {
    echo '<script>alert("Los datos se actualizaron correctamente."); window.location.href = "gastos.php";</script>';
} else {
    echo '<script>alert("Error al actualizar los datos: ' . $con->error . '"); window.location.href = "gastos.php";</script>';
}

$con->close();
?>
