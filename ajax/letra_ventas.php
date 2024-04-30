<?php
//Include database configuration file
include("../config/db.php");
include("../config/conexion.php");

if(isset($_POST["ventasID"]) && !empty($_POST["ventasID"])){
    //Get all state data
    $ventas=$_POST["ventasID"];
    $sql_ventas=mysqli_query($con,"SELECT letra FROM users WHERE user_id = $ventas");
    $rw=mysqli_fetch_array($sql_ventas);
    $userLetra=$rw["letra"];
    
    echo "<input type='text' class='form-control input-sm' name='letra_ventas ' id='letra_ventas' readonly value='".$userLetra."' >";
    //Display states list

}
