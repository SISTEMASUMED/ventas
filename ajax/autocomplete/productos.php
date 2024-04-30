<?php
if (isset($_GET['term'])){
include("../../config/db.php");
include("../../config/conexion.php");
$return_arr = array();
/* If connection to database, run sql statement. */
if ($con)
{
		$sTable = "cves_alter01";
	$fetch = mysqli_query($con,"SELECT $sTable.id_producto, $sTable.CVE_ART as SKU, $sTable.DESCR as producto, $sTable.EXIST, cves_alter01.CVE_ART, cves_alter01.CVE_ALTER, ltpd01.CVE_ART, ltpd01.LOTE, ltpd01.CVE_ALM, ltpd01.CANTIDAD, almacenes01.CVE_ALM as n_almacen, almacenes01.DESCR as nombre_almacen FROM $sTable INNER JOIN cves_alter01 ON $sTable.CVE_ART = cves_alter01.CVE_ART INNER JOIN ltpd01 ON $sTable.CVE_ART = ltpd01.CVE_ART INNER JOIN almacenes01 ON almacenes01.CVE_ALM = ltpd01.CVE_ALM  " . mysqli_real_escape_string($con,($_GET['term'])) . "%' LIMIT 0 ,50"); 
	
	/* Retrieve and store in array the results of the query.*/
	while ($row = mysqli_fetch_array($fetch)) {
		$id_cliente=$row['id_producto'];
		$row_array['value'] = $row['DESCR'];
		$row_array['id_cliente']=$id_cliente;
		$row_array['nombre_cliente']=$row['nombre'];
		$row_array['rfc_cliente']=$row['rfc'];
		if($row['telefono']== NULL){
			$vacio="No hay Teléfono";
			$row_array['telefono_cliente']= $vacio;
		}else{
		$row_array['telefono_cliente']=$row['telefono'];
		}
		$row_array['emailpred']=$row['emailpred'];
		$row_array['calle']=$row['calle'];
		$row_array['numext']=$row['numext'];
		$row_array['colonia']=$row['colonia'];
		array_push($return_arr,$row_array);
    }
	
}

/* Free connection resources. */
mysqli_close($con);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
?>