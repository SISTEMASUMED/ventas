<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
    $active_facturas="";
    $active_productos="";
    $active_servicios="";
    $active_finanzas="active";
    $active_clientes="";
    $active_usuarios="";	
    $title="SUMED";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
    if ($con->connect_error) {
        die("Error de conexión a la base de datos: " . $con->connect_error);
    }

?>

<?php

$id = $_GET['id_finanza']; 

// Obtener los detalles del gasto
$sql = "SELECT * FROM finanzas WHERE id_finanza = $id";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    
    $row = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html>
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
            <h2>Editar Gasto</h2>
        <form id="editarGastoForm" class="form-horizontal" action="actualizar_gasto.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id_finanza']; ?>">
            <div class="form-group row">
                <label class="col-md-1 control-label" for="xml">XML:</label>
                <div class="col-md-2">
                    <input class="form-control input-sm" type="file" accept=".xml" id="xml" name="xml" class="form-control" disabled>
                </div>
                <label class="col-md-1 control-label" for="autorizacion">Autorización:</label>
                <div class="col-md-2">
                    <input class="form-control input-sm" type="file" accept=".png, .jpg, .jpeg" id="autorizacion" name="autorizacion" class="form-control" disabled>
                </div>
            </div>
            <hr class="style13">
            <div class="form-group row">
                <label for="proveedor" class="col-sm-1 control-label">Nombre del Proveedor:</label>
                <div class="col-md-3">
                    <input type="text" id="proveedor" name="proveedor" readonly class="form-control input-sm" value="<?php echo $row['proveedor']; ?>">
                </div>
                <label for="rfc" class="col-sm-1 control-label">RFC:</label>
                <div class="col-md-2">
                    <input type="text" id="rfc" name="rfc" readonly class="form-control input-sm" value="<?php echo $row['rfc']; ?>">
                </div>
                <label for="fecha" class="col-sm-1 control-label">Fecha:</label>
                <div class="col-md-2">
                    <input type="text" id="fecha" name="fecha" readonly class="form-control input-sm" value="<?php echo $row['fecha']; ?>">
                    <input type="hidden" id="fechaFormateada" name="fechaFormateada" value="<?php echo $fechaFormateada; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="referencia" class="col-sm-1 control-label">Referencia:</label>
                <div class="col-md-3">
                    <select id="referencia" name="referencia" class="form-control select-sm" required>
                        <option value="<?php echo $row['referencia']; ?>" selected disabled>--Selecciona una opción--</option>
                        <option value="Viaticos Alimenticios">Viáticos Alimenticios</option>
                        <option value="Pasaje o Transporte">Pasaje o Transporte</option>
                        <option value="Casetas">Casetas</option>
                        <option value="Combustible">Combustible</option>
                        <option value="Hospedaje">Hospedaje</option>
                        <option value="Mensajería">Mensajería</option>
                        <option value="Cortesia (Doctores o Hospitales)">Cortesía (Doctores o Hospitales)</option>
                        <option value="Estacionamiento">Estacionamiento</option>
                        <option value="Papelería y Artículos">Papelería y Artículos</option>
                        <option value="Otros" disabled >Otros</option>
                    </select>
                </div>
                <label for="folio" class="col-sm-1 control-label">Folio:</label>
                <div class="col-md-2">
                    <input type="text" id="folio" name="folio" readonly class="form-control input-sm" value="<?php echo $row['folio']; ?>">
                </div>
                <label for="uuid" class="col-sm-1 control-label">UUID:</label>
                <div class="col-md-2">
                    <input type="text" id="uuid" name="uuid" readonly class="form-control input-sm" value="<?php echo $row['uuid']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="subtotal" class="col-sm-1 control-label">Subtotal: $</label>
                <div class="col-md-3">
                    <input type="text" id="subtotal" name="subtotal" readonly class="form-control input-sm" value="<?php echo $row['subtotal']; ?>">
                </div>
                <label for="iva" class="col-sm-1 control-label">IVA: $</label>
                <div class="col-md-2">
                    <input type="text" id="iva" name="iva" readonly class="form-control input-sm" value="<?php echo $row['iva']; ?>">
                </div>
                <label for="total" class="col-sm-1 control-label">Total: $</label>
                <div class="col-md-2">
                    <input type="text" id="total" name="total" readonly class="form-control input-sm" value="<?php echo $row['total']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="pdf" class="col-sm-1 control-label">PDF:</label>
                <div class="col-md-3">
                    <input type="file" accept=".pdf" id="pdf" name="pdf" class="form-control input-sm" disabled>
                </div>
                <label for="comprobante" class="col-sm-1 control-label">Comprobante:</label>
                <div class="col-md-2">
                    <input type="file" accept=".png, .jpg, .jpeg" id="comprobante" name="comprobante" class="form-control input-sm" disabled>
                </div>
                <label for="observacion" class="col-sm-1 control-label">Observación:</label>
                <div class="col-md-2">
                    <textarea id="observacion" name="observacion" class="form-control textarea-sm"><?php echo $row['observacion']; ?></textarea>
                </div>
            </div>
            <button type="submit" style="margin-left:30%; margin-top:2%;" class="btn btn-info">Guardar Cambios</button>
        </form>
            </div>
        </div>
    </div>

        <?php
	        include("footer.php");
	    ?>

    </body>
    </html>
    
<?php
    } else {
        echo "No se encontró el gasto.";
    }

    $conn->close();
?>