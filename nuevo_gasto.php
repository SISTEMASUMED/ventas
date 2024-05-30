<?php
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}

require_once("config/db.php"); // Contiene las variables de configuración para conectar a la base de datos
require_once("config/conexion.php"); // Contiene función que conecta a la base de datos

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
    // Manejo de carga de archivos PDF, XML, comprobante y autorización
    $errors = [];

    // Función para manejar la carga de archivos
    function upload_file($file, $allowed_types, $upload_directory) {
        if (!isset($file['name']) || empty($file['name'])) {
            return ['path' => ''];
        }

        $file_name = uniqid() . '-' . basename($file['name']);
        $file_tmp = $file['tmp_name'];
        $file_type = $file['type'];

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

    // Manejo de archivo PDF
    $pdf_path = '';
    if (isset($_FILES['pdfFile'])) {
        $pdf_result = upload_file($_FILES['pdfFile'], ['application/pdf'], "img/pdf/");
        if (isset($pdf_result['error'])) {
            $errors[] = $pdf_result['error'];
        } else {
            $pdf_path = $pdf_result['path'];
        }
    }

    // Manejo de archivo XML
    $xml_path = '';
    if (isset($_FILES['xmlFile'])) {
        $xml_result = upload_file($_FILES['xmlFile'], ['text/xml'], "img/xml/");
        if (isset($xml_result['error'])) {
            $errors[] = $xml_result['error'];
        } else {
            $xml_path = $xml_result['path'];
        }
    }

    // Manejo de archivo de comprobante (imagen)
    $comprobante_path = '';
    if (isset($_FILES['comprobanteFile'])) {
        $comprobante_result = upload_file($_FILES['comprobanteFile'], ['image/jpeg', 'image/png', 'image/gif'], "img/comprobante/");
        if (isset($comprobante_result['error'])) {
            $errors[] = $comprobante_result['error'];
        } else {
            $comprobante_path = $comprobante_result['path'];
        }
    }

    // Manejo de archivo de autorización (imagen)
    $autorizacion_path = '';
    if (isset($_FILES['autorizacionFile'])) {
        $autorizacion_result = upload_file($_FILES['autorizacionFile'], ['image/jpeg', 'image/png', 'image/gif'], "img/autorizacion/");
        if (isset($autorizacion_result['error'])) {
            $errors[] = $autorizacion_result['error'];
        } else {
            $autorizacion_path = $autorizacion_result['path'];
        }
    }

    // Verificar si hubo errores en la carga de archivos
    if (!empty($errors)) {
        echo "<script>alert('Error al cargar los archivos: " . implode(", ", $errors) . "'); window.location.href = 'gastos.php';</script>";
    } else {
        // Insertar datos en la base de datos si no existe un registro con el mismo UUID
        $sql = "INSERT INTO finanzas (fecha, rfc, proveedor, uuid, folio, referencia, observacion, subtotal, iva, total, status, xml_path, pdf_path, comprobante_path, autorizacion_path, id_vendedor)
                VALUES ('$fechaFormateada', '$rfc', '$proveedor', '$uuid', '$folio', '$referencia', '$observacion', '$subtotal', '$iva', '$total', 1, '$xml_path', '$pdf_path', '$comprobante_path', '$autorizacion_path', '$id_vendedor')";

        if ($con->query($sql) === TRUE) {
            // Mostrar alerta de éxito
            echo "<script>alert('El gasto ha sido guardado exitosamente.'); window.location.href = 'gastos.php';</script>";
        } else {
            // Mostrar alerta de error
            echo "<script>alert('Error al guardar el gasto: " . $con->error . "');</script>";
        }
    }
}

// Cerrar conexión
$con->close();
?>
