<?
error_reporting(E_ALL ^ E_NOTICE);
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: ../login.php");
    exit;
}
ini_set('display_errors', 1);
include("../../../config/db.php");
include("../../../config/conexion.php");

//Archivo de funciones PHP
include("../../../funciones.php");
$numero_factura=2;
$id_producto=1;
$codigo_producto="SM002SM001";
$referencia="ATP540";
$lote="abcde12345";
$almacen="FACTURACION";
$cantidad = 2;
$precio_total_r=1500;
$id_vendedor=1;

$insertar = mysqli_query($con, "INSERT INTO detalle_factura VALUES (NULL,'$numero_factura','$id_producto','$codigo_producto','$referencia','$lote','$almacen','$cantidad','$precio_total_r','$id_vendedor')");
echo "<script>alert('work:insert correcto');</script>";	
header("location: ../../../facturas.php");
?>