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
$id_vendedor = $_SESSION['user_id'];

// Verificar si ya existe un registro con el mismo UUID
$sql_check = "SELECT COUNT(*) AS count FROM finanzas WHERE uuid = '$uuid'";
$result_check = $con->query($sql_check);
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] > 0) {
    // Mostrar alerta si ya existe un registro con el mismo UUID
    echo "<script>alert('El gasto ya existe favor de verificar'); window.location.href = 'gastos.php';</script>";
} else {
    // Manejo de carga de archivos PDF y XML
    if (isset($_FILES['pdfFile']) && isset($_FILES['xmlFile'])) {
        $pdf_errors = [];
        $xml_errors = [];
        
        // Manejo de archivo PDF
        $pdf_file_name = $_FILES['pdfFile']['name'];
        $pdf_file_tmp = $_FILES['pdfFile']['tmp_name'];
        $pdf_file_type = $_FILES['pdfFile']['type'];
        
        // Asegurarse de que sea un archivo PDF
        if ($pdf_file_type != "application/pdf") {
            $pdf_errors[] = 'El archivo debe ser un PDF';
        }
        
        // Guardar el archivo PDF en el servidor
        if (empty($pdf_errors)) {
            $pdf_upload_directory = "img/pdf/";
            $pdf_file_path = $pdf_upload_directory . $pdf_file_name;
            move_uploaded_file($pdf_file_tmp, $pdf_file_path);
        } else {
            echo "<script>alert('Error al cargar el archivo PDF: " . implode(", ", $pdf_errors) . "');</script>";
        }
        
        // Manejo de archivo XML
        $xml_file_name = $_FILES['xmlFile']['name'];
        $xml_file_tmp = $_FILES['xmlFile']['tmp_name'];
        $xml_file_type = $_FILES['xmlFile']['type'];
        
        // Asegurarse de que sea un archivo XML
        if ($xml_file_type != "text/xml") {
            $xml_errors[] = 'El archivo debe ser un XML';
        }
        
        // Guardar el archivo XML en el servidor
        if (empty($xml_errors)) {
            $xml_upload_directory = "img/xml/";
            $xml_file_path = $xml_upload_directory . $xml_file_name;
            move_uploaded_file($xml_file_tmp, $xml_file_path);
        } else {
            echo "<script>alert('Error al cargar el archivo XML: " . implode(", ", $xml_errors) . "');</script>";
        }
        
        // Insertar datos en la base de datos si no existe un registro con el mismo UUID
        $pdf_path = isset($pdf_file_path) ? $pdf_file_path : '';
        $xml_path = isset($xml_file_path) ? $xml_file_path : '';

        $sql = "INSERT INTO finanzas (fecha, rfc, proveedor, uuid, folio, referencia, observacion, subtotal, iva, total, status, xml_path, pdf_path, id_vendedor)
                VALUES ('$fechaFormateada', '$rfc', '$proveedor', '$uuid', '$folio', '$referencia', '$observacion', '$subtotal', '$iva', '$total', 1, '$xml_path', '$pdf_path', '$id_vendedor')";

        if ($con->query($sql) === TRUE) {
            // Mostrar alerta de éxito
            echo "<script>alert('El gasto ha sido guardado exitosamente.'); window.location.href = 'gastos.php';</script>";
        } else {
            // Mostrar alerta de error
            echo "<script>alert('Error al guardar el gasto" . $con->error . "');</script>";
        }
    }
}

// Cerrar conexión
$con->close();
?>
