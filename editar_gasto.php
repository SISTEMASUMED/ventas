<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
    $active_facturas="";
    $active_productos="";
    $active_servicios="";
    $active_finanzas="active-link";
    $active_clientes="";
    $active_usuarios="";	
    $title="SUMED";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos


    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("head.php");?>
</head>
<body>
    <?php include("navbar.php");?>

    <div class="container-fluid">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4><i class="glyphicon glyphicon-edit"></i> Editar Gasto</h4>
            </div>
            <div class="panel-body">
                
            </div>
        </div>
    </div>

</body>
</html>