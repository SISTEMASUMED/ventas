<?php
session_start();
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

if(isset($_POST['image'])) {

    $data = $_POST['image'];
    $data = str_replace('data:image/png;base64,', '', $data);
    $data = str_replace(' ', '+', $data);
    $imageData = base64_decode($data);
   
   $sql_fact=mysqli_query( $con,"SELECT * FROM facturas WHERE id_vendedor=1 ORDER BY numero_factura DESC");
   $rj_fact=mysqli_fetch_array($sql_fact);
   $numero_fact=$rj_fact['numero_factura'];

   //selecciona y ordena para tener el ultimo id
    $consecutivo=$numero_fact+1;
    $id_user=$_SESSION['user_id'];
    // Guardar la imagen en el servidor
    $filename = '../pdf/documentos/res/img/firmas/firma'.$consecutivo.'.png';
    file_put_contents($filename, $imageData);
   
    $_SESSION['filename']=$filename;

    echo "<script>console.log('".$_SESSION['filename']."')</script>";
    ///inserta los datos en la base
    $insert_firma= mysqli_query($con,"INSERT INTO firmas VALUES (NULL, '$id_user','$consecutivo','$filename')");
    echo "<script>console.log('".$id_user." ".$numero_fact."')</script>";
}
?>
