<?php
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}

require_once("config/db.php");
require_once("config/conexion.php");

if ($con->connect_error) {
    die("Error de conexión a la base de datos: " . $con->connect_error);
}

// Obtener datos del formulario y sanitizarlos
$rfc = $con->real_escape_string($_POST['rfc']);
$proveedor = $con->real_escape_string($_POST['proveedor']);
$uuid = $con->real_escape_string($_POST['uuid']);
$folio = $con->real_escape_string($_POST['folio']);
$referencia = $con->real_escape_string($_POST['referencia']);
$observacion = $con->real_escape_string($_POST['observacion']);
$subtotal = $con->real_escape_string($_POST['subtotal']);
$iva = $con->real_escape_string($_POST['iva']);
$total = $con->real_escape_string($_POST['total']);
$fechaFormateada = $con->real_escape_string($_POST['fechaFormateada']);
$status = 1; // Asumiendo que el status inicial es 1
$id_vendedor = $_SESSION['user_id'];

// Verificar si ya existe un registro con el mismo UUID
$sql_check = "SELECT COUNT(*) AS count FROM finanzas WHERE uuid = '$uuid'";
$result_check = $con->query($sql_check);
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] > 0) {
    echo "<script>alert('El gasto ya existe, favor de verificar'); window.location.href = 'gastos.php';</script>";
} else {
    // Manejo de carga de archivos
    $errors = [];

    function upload_file($file, $allowed_types, $upload_directory) {
        if (!isset($file['name']) || empty($file['name'])) {
            return ['path' => ''];
        }

        $file_name = uniqid() . '-' . basename($file['name']);
        $file_tmp = $file['tmp_name'];
        $file_type = mime_content_type($file_tmp);

        if (!in_array($file_type, $allowed_types)) {
            return ['error' => "El archivo debe ser de tipo: " . implode(", ", $allowed_types)];
        }

        $file_path = $upload_directory . $file_name;
        if (move_uploaded_file($file_tmp, $file_path)) {
            return ['path' => $file_path];
        } else {
            return ['error' => 'Error al cargar el archivo'];
        }
    }

    // Manejo de archivos
    $pdf_path = '';
    if (isset($_FILES['pdfFile'])) {
        $pdf_result = upload_file($_FILES['pdfFile'], ['application/pdf'], "img/pdf/");
        if (isset($pdf_result['error'])) {
            $errors[] = $pdf_result['error'];
        } else {
            $pdf_path = $pdf_result['path'];
        }
    }

    $xml_path = '';
    if (isset($_FILES['xmlFile'])) {
        $xml_result = upload_file($_FILES['xmlFile'], ['application/xml', 'text/xml'], "img/xml/");
        if (isset($xml_result['error'])) {
            $errors[] = $xml_result['error'];
        } else {
            $xml_path = $xml_result['path'];
        }
    }

    $comprobante_path = '';
    if (isset($_FILES['comprobanteFile'])) {
        $comprobante_result = upload_file($_FILES['comprobanteFile'], ['image/jpeg', 'image/png', 'image/gif'], "img/comprobante/");
        if (isset($comprobante_result['error'])) {
            $errors[] = $comprobante_result['error'];
        } else {
            $comprobante_path = $comprobante_result['path'];
        }
    }

    $autorizacion_path = '';
    if (isset($_FILES['autorizacionFile'])) {
        $autorizacion_result = upload_file($_FILES['autorizacionFile'], ['image/jpeg', 'image/png', 'image/gif'], "img/autorizacion/");
        if (isset($autorizacion_result['error'])) {
            $errors[] = $autorizacion_result['error'];
        } else {
            $autorizacion_path = $autorizacion_result['path'];
        }
    }

    if (!empty($errors)) {
        echo "<script>alert('Error al cargar los archivos: " . implode(", ", $errors) . "'); window.location.href = 'gastos.php';</script>";
    } else {
        $sql = "INSERT INTO finanzas (fecha, rfc, proveedor, uuid, folio, referencia, observacion, subtotal, iva, total, status, xml_path, pdf_path, comprobante_path, autorizacion_path, id_vendedor)
                VALUES ('$fechaFormateada', '$rfc', '$proveedor', '$uuid', '$folio', '$referencia', '$observacion', '$subtotal', '$iva', '$total', '$status', '$xml_path', '$pdf_path', '$comprobante_path', '$autorizacion_path', '$id_vendedor')";

        if ($con->query($sql) === TRUE) {
            echo "<script>alert('El gasto ha sido guardado exitosamente.'); window.location.href = 'gastos.php';</script>";
        } else {
            echo "<script>alert('Error al guardar el gasto: " . $con->error . "');</script>";
        }
    }
}

$con->close();
?>
