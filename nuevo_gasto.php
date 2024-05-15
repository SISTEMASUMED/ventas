<?php
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}

require_once("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once("config/conexion.php");//Contiene funcion que conecta a la base de datos

if ($con->connect_error) {
    die("Error de conexión a la base de datos: " . $con->connect_error);
}

// Obtener datos del formulario
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
$status = $_POST['status'];
$xml = $_POST['xml'];
$id_vendedor = $_SESSION['user_id'];

// Verificar si ya existe un registro con el mismo UUID
$sql_check = "SELECT COUNT(*) AS count FROM finanzas WHERE uuid = '$uuid'";
$result_check = $con->query($sql_check);
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] > 0) {
    // Mostrar alerta si ya existe un registro con el mismo UUID
    echo "<script>alert('El gasto ya existe favor de verificar'); window.location.href = 'gastos.php';</script>";
} else {
    // Manejo de carga de archivo PDF
    if (isset($_FILES['pdfFile'])) {
        $errors = [];
        $file_name = $_FILES['pdfFile']['name'];
        $file_tmp = $_FILES['pdfFile']['tmp_name'];
        $file_type = $_FILES['pdfFile']['type'];

        echo"<script>console.log('Esta debe ser la ruta del archivo"."archivo nombre".$file_name."archivo temporal".$file_tmp."archivo tipo".$file_type."')</script>";
        

        // Asegurarse de que sea un archivo PDF
        if ($file_type != "application/pdf") {
            $errors[] = 'El archivo debe ser un PDF';
        }


        // Guardar el archivo en el servidor
        if (empty($errors)) {
            $upload_directory = "img/pdf/";
            $file_path = $upload_directory . $file_name;
            move_uploaded_file($file_tmp, $file_path);
        } else {
            echo "<script>alert('Error al cargar el archivo PDF: " . implode(", ", $errors) . "');</script>";
        }
    }

    // Insertar datos en la base de datos si no existe un registro con el mismo UUID
    $pdf_path = isset($file_path) ? $file_path : ''; // Ruta del archivo PDF cargado

    echo"<script>console.log('Esta debe ser la ruta del archivo".$pdf_path."')</script>";

    $sql = "INSERT INTO finanzas (fecha, rfc, proveedor, uuid, folio, referencia, observacion, subtotal, iva, total, status, xml_path, pdf_path, id_vendedor)
            VALUES ('$fechaFormateada', '$rfc', '$proveedor', '$uuid', '$folio', '$referencia', '$observacion', '$subtotal', '$iva', '$total', 1, '$xml', '$pdf_path', '$id_vendedor')";

    if ($con->query($sql) === TRUE) {
        // Mostrar alerta de éxito
        echo "<script>alert('El gasto ha sido guardado exitosamente.'); window.location.href = 'gastos.php';</sipt>";
    } else {
        // Mostrar alerta de error
        echo "<script>alert('Error al guardar el gasto" . $con->error . "');</script>";
    }
}

// Cerrar conexión
$con->close();
?>
