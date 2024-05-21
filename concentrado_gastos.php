<?php
    session_start();
    if (!isset($_SESSION['user_login_status']) || $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
        exit;
    }

    $active_facturas = "";
    $active_productos = "";
    $active_servicios = "";
    $active_finanzas = "active-link";
    $active_clientes = "";
    $active_usuarios = "";    
    $title = "SUMED";

    /* Connect To Database */
    require_once("config/db.php"); // Contiene las variables de configuracion para conectar a la base de datos
    require_once("config/conexion.php"); // Contiene funcion que conecta a la base de datos

    // Consulta para obtener todos los usuarios
    $sql = "SELECT user_id, nombre FROM users";
    $result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("head.php") ?>
</head>
<body>
    <?php include("navbar.php") ?>

    <div class="container">
        <h2>Buscar Gastos por Vendedor</h2>
        <form method="post" action="gastosg_excel.php">
            <div class="form-group">
                <label for="vendedor">Nombre del Vendedor:</label>
                <select class="form-control" id="vendedor" name="vendedor" required>
                    <option value="">Seleccione un vendedor</option>
                    <?php
                        // Generar las opciones del select con los usuarios
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['nombre'] . "'>" . $row['nombre'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Descargar Reporte</button>
        </form>
    </div>
</body>
</html>
