<?php
if (isset($_GET['term'])){
include("../../config/db.php");
include("../../config/conexion.php");
$return_arr = array();
/* If connection to database, run sql statement. */
if ($con)
{
	
	$fetch = mysqli_query($con,"SELECT * FROM proveedores  WHERE nombre like '%" . mysqli_real_escape_string($con,($_GET['term'])) . "%' LIMIT 0 ,50"); 
	
	/* Retrieve and store in array the results of the query.*/
 while ($row = mysqli_fetch_array($fetch)) {
		$id_cliente=$row['id_proveedor'];
		$row_array['value'] = $row['nombre'];
		$row_array['id_proveedor']=$id_proveedor;
		$row_array['nombre']=$row['nombre'];
		
		array_push($return_arr,$row_array);
		

    }
	
}

/* Free connection resources. */
mysqli_close($con);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
?>