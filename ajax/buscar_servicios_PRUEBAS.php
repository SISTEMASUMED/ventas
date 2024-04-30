<?php
error_reporting(0);
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$usuario = $_SESSION['user_id'];
		$numero_factura=intval($_GET['id']);
		$sql_1=mysqli_query($con,"SELECT * FROM servicios WHERE id_servicio='".$numero_factura."'");
		$rj_1=mysqli_fetch_array($sql_1);
		$estado_servicio=$rj_1['estado_servicio'];
		//echo "<script>console.log('".$estado_servicio."');</script>";
		if($estado_servicio==1){
			$update_servicio="UPDATE servicios SET status_fact=1 WHERE id_servicio='".$numero_factura."'";
			$update1=mysqli_query($con,$update_servicio);
			//echo"<script>console.log('work:se ejecuto codigo hasta aqui ".$estado_factura."');</script>";
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
			  <strong>Aviso!</strong> Remisión Cancelada Exitosamente!
			</div>
			<?php
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puede cancelar
			</div>
			<?php
			
		}
	
}
	if($action == 'ajax'){
		$usuario = $_SESSION['user_id'];
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		
		
		include 'pagination.php'; //include pagination file
		
		$reload = './servicios_integrales.php';
		//main query to fetch the data
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$session_id2 = $_SESSION["user_id"];
		$sql_usuario1=mysqli_query($con,"select users.user_id, users.is_admin from users where user_id ='$session_id2'");
        $rj_usuario1=mysqli_fetch_array($sql_usuario1);
		//echo "<script>console.log('work:".$rj_usuario1['is_admin']."');</script>";
		$is_admin=$rj_usuario1["is_admin"];
		if ($rj_usuario1['is_admin']!=2){
	    //$sql="SELECT * FROM $sTable  $sWhere ";
		// $sql="SELECT servicios.id_servicio, servicios.numero_servicio,servicios.id_hospital, servicios.fecha_servicio, servicios.id_vendedor,
		// servicios.nombre_paciente,servicios.paterno,servicios.materno,servicios.status_fact,clientes.id_cliente, clientes.nombre_cliente,
		// users.user_id, users.nombre, users.letra FROM servicios, clientes, users WHERE servicios.id_hospital=clientes.id_cliente and servicios.id_vendedor=users.user_id LIMIT 50";
		// //echo "<script>console.log('admin');</script>";
		$sql="SELECT id_servicio, numero_servicio,id_hospital, fecha_servicio,id_vendedor,nombre_paciente,paterno,materno,status_fact FROM servicios ORDER BY numero_servicio DESC LIMIT 1000";
	}
	
	else if ($rj_usuario1['is_admin']==2){
			$sql="SELECT s.id_servicio,s.numero_servicio,s.id_hospital,id_vendedor,s.derecho_habiente,s.fecha_cirugia,s.paterno,s.materno,s.nombre_paciente,s.fecha_nacimiento,s.expediente,
			s.sexo,s.edad,s.sala,s.hora_inicio,s.hora_termino,s.turno,s.diagnostico,s.estado_servicio,s.fecha_servicio,s.status_fact,c.id_cliente,c.clave,c.nombre_cliente,c.rfc,c.calle,c.numint,c.numext,c.colonia,c.telefono,c.emailpred,u.user_id,u.nombre,u.user_name,u.user_email,u.letra,u.is_admin 
			FROM servicios s INNER JOIN clientes c  ON c.id_cliente = s.id_hospital INNER JOIN users u on u.user_id = s.id_vendedor WHERE s.id_vendedor=$usuario and s.status_fact=0  ORDER BY s.numero_servicio desc";
		
			//echo "<script>console.log('no admin');</script>";
		}
		$query = mysqli_query($con, $sql);		//loop through fetched data
		
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table  table-striped" id="myTable2">
				<tr  class="info">
					<th class="" >Remisión No./Cliente</th>
					<th class="">Fecha</th>
					<th class=' '>Paciente</th>
					<th class="">Técnico</th>
					<th>Status en sistema</th>
					<th class="">Hoja de consumo</th>
					<th class=''>Remisión SUMED</th>
					<th>Materiales</th>
					
						<?php 
						if ($rj_usuario1['is_admin']==1){

							echo "<th>Bloqueo<br>Desboqueo</th>";
						}
						?>
						
				</tr>
				<?php
				$vuelta=1;
				while ($row=mysqli_fetch_array($query)){
						$id_servicio=$row['id_servicio'];
						$id_ventas=$row['id_vendedor'];
						$cliente=$row['id_cliente'];
						$numero_servicio=$row['numero_servicio'];
					    $letra_ventas = $row['letra'];
						$fecha=date("d/m/Y", strtotime($row['fecha_servicio']));
						$nombre_cliente=$row['nombre_cliente'];
						$telefono = $row['telefono'];
						$email = $row['emailpred'];
						$paciente =$row['nombre_paciente']." ".$row['paterno']." ".$row['materno'];
						$nombre_vendedor=$row['nombre'];
						$status=$row['status_fact'];
						if ($status==0){$text_status="ACTIVA";$label_class1='label-success';}
						else{$text_status="CANCELADA";$label_class1='label-warning';}
						$estado_servicio=$row['estado_servicio'];
						$total_venta=$row['total_venta'];
						$vuelta=$vuelta+1;
					?>

					<input type="hidden" value="<?php echo $estado_factura;?>" id="estado<?php echo $id_factura;?>">
					
					<tr>
						<td class=""><ul><li><?php echo $nombre_cliente;?></li><li><?php echo $letra_ventas."-".$numero_servicio; ?></li></td>
						<td class=" "><?php echo $fecha; ?></td>
						<td class=" "><?php echo $paciente; ?></td>	
						<td class=" "><?php echo $nombre_vendedor ?></td>
						<td class=""><span class="<?php echo $label_class1; ?>"><?php echo $text_status; ?></span></td>	
						<td>
								<?php				

if ($is_admin==1 || $is_admin==2 ){
	if ( $cliente==162 || $id_ventas==18 ){
	
	echo"
	
	<a href='#' class='btn btn-default' title='Ver Hoja de consumo' onclick='ver_consumo(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-eye-open'></i></a> 
	<a href='#' class='btn btn-default' title='Descargar Remisión' onclick='imprimir_consumo(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-download'></i></a> 
	
  ";}
  
  }
 	
	else if($is_admin==3 || $is_admin==4){
		
		echo "

		";

	}else{
		$consulta=mysqli_query($con,"select * from materiales_servicio where id_servicio = '$id_servicio'");
		$count=mysqli_num_rows($consulta);
		if($count>0){
		
		}
		echo "
		<a href='agregar_materiales.php?id_servicio=".$id_servicio."&numero_servicio=".$numero_servicio."' class='btn btn-default' title='Agregar materiales' ><i class='glyphicon glyphicon-list-alt'></i></a> 		
		";
		echo "
	
	<a href='#' class='btn btn-default' title='Editar estado' onclick='obtener_datos(".$id_servicio.");' data-toggle='modal' data-target='#myModal9'><i class='glyphicon glyphicon-edit'></i></a> 
	<a href='#' class='btn btn-default' title='Ver remisión' onclick='ver_factura(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-eye-open'></i></a>
	<a href='#' class='btn btn-default' title='Descargar remisión' onclick='imprimir_factura(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-download'></i></a>
</td>";
	}
?>
</td>

<td class="">
<?php 

$consulta_bloqueo=mysqli_query($con,"SELECT servicios.id_servicio, servicios.bloqueo from servicios where id_servicio = '$id_servicio'" );
	$rj_bloqueo=mysqli_fetch_array($consulta_bloqueo);
	$bloqueo=$rj_bloqueo['bloqueo'];
			if($bloqueo == 0){
				$estilo="style='background-color:#FF5B33;border:none;box-shadow: 1px 2px 1px black;'";
				$href="";
				$href2="";
				$cancel="";

			}else if ($bloqueo == 1){
				
				$estilo="style='background-color:#33D7FF;border:none;box-shadow: 1px 2px 1px black;'";
				$href= "<a href='editar_servicio.php?id_servicio=".$id_servicio."&numero_servicio=".$numero_servicio."' class='btn btn-default' title='Editar Remision' ><i class='glyphicon glyphicon-edit'></i></a>";
				$href2="<a href='editar_materiales.php?id_servicio=".$id_servicio."&numero_servicio=".$numero_servicio."&id_vendedor=".$id_ventas."' class='btn btn-default' title='Editar materiales'  ><i class='glyphicon glyphicon-edit'></i></a> 		
				";
				$cancel="<a href='#' class='btn btn-default' title='Cancelar Remisión' onclick='eliminar(".$id_servicio.");'><i class='glyphicon glyphicon-remove'></i> </a>";
			}
	
if ($is_admin==1){
	
	if ($estado_servicio==1){
		echo "<a href='#' class='btn btn-default' title='Editar estado' onclick='obtener_datos(".$id_servicio.");' data-toggle='modal' data-target='#myModal9'><i class='glyphicon glyphicon-edit'></i></a> 
	";
	}else{echo "";}
	echo"
	<a href='editar_servicio.php?id_servicio=".$id_servicio."&numero_servicio=".$numero_servicio."' class='btn btn-default' title='Editar Remision' ><i class='glyphicon glyphicon-edit'></i></a>
	<a href='#' class='btn btn-default' title='Ver Remisión' onclick='ver_factura(".$id_servicio.",".$numero_servicio.",".$id_materiales.");'><i class='glyphicon glyphicon-eye-open'></i></a>
	<a href='#' class='btn btn-default' title='Descargar Remisión' onclick='imprimir_factura(".$DLid_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-download'></i></a> 
	<a href='#' class='btn btn-default' title='Descargar remisión' onclick='descargar(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-download-alt'></i></a>
	<a href='#' class='btn btn-default' title='Cancelar Remisión' onclick='eliminar(".$id_servicio.");'><i class='glyphicon glyphicon-remove'></i> </a>
  ";}
  elseif ($is_admin == 2){
	
	echo $href."

	<a href='#' class='btn btn-default' title='Ver Remisión' onclick='ver_factura(".$id_servicio.",".$numero_servicio.",".$id_materiales.");'><i class='glyphicon glyphicon-eye-open'></i></a>
	<a href='#' class='btn btn-default' title='Descargar Remisión' onclick='imprimir_factura(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-download'></i></a> "
	.$cancel
	;

}
	 
	elseif ($is_admin==3) {
		
		echo "
	
	<a href='#' class='btn btn-default' title='Editar estado' onclick='obtener_datos(".$id_servicio.");' data-toggle='modal' data-target='#myModal9'><i class='glyphicon glyphicon-edit'></i></a> 
	<a href='#' class='btn btn-default' title='Ver remisión' onclick='ver_factura(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-eye-open'></i></a>
	<a href='#' class='btn btn-default' title='Descargar remisión' onclick='imprimir_factura(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-download'></i></a>
	<a href='#' class='btn btn-default' title='Descargar remisión' onclick='descargar(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-download-alt'></i></a>

</td>";
	}
	elseif ($is_admin==4){
		echo "
	
	<a href='#' class='btn btn-default' title='Ver remisión' onclick='ver_factura(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-eye-open'></i></a>
	<a href='#' class='btn btn-default' title='Descargar remisión' onclick='imprimir_factura(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-download'></i></a>
</td>";
	}

	?>	
	 	</td>		
		<td>
		<?php 


//$sql_usuario=mysqli_query($con,"select * from users where user_id ='$session_id'");
//$rj_usuario=mysqli_fetch_array($sql_usuario);

if ($is_admin==1 ){
	
	$consulta_admin=mysqli_query($con,"select materiales_servicio.numero_servicio, materiales_servicio.id_vendedor from materiales_servicio where numero_servicio = '$numero_servicio' and id_vendedor='$id_ventas'" );
	$count_admin=mysqli_num_rows($consulta_admin);
	
	if($count_admin>0){
	 echo"
	 <a href='editar_materiales.php?id_servicio=".$id_servicio."&numero_servicio=".$numero_servicio."&id_vendedor=".$id_ventas."' class='btn btn-default' title='Editar materiales'  ><i class='glyphicon glyphicon-edit'></i></a> 		
		
	 ";
	}else{
		
			
		echo "<a href='agregar_materiales.php?id_servicio=".$id_servicio."&numero_servicio=".$numero_servicio."&id_vendedor=".$id_ventas."' class='btn btn-default' title='Agregar materiales' style='".$visivility."'  ><i class='glyphicon glyphicon-list-alt'></i></a> 		
		";
	}
}
if ( $is_admin==2){
	
	$consulta_admin=mysqli_query($con,"select materiales_servicio.numero_servicio, materiales_servicio.id_vendedor from materiales_servicio where numero_servicio = '$numero_servicio' and id_vendedor='$id_ventas'" );
	$count_admin=mysqli_num_rows($consulta_admin);
	
	if($count_admin>0){
	 echo $href2;
	}else{
		
			
		echo "<a href='agregar_materiales.php?id_servicio=".$id_servicio."&numero_servicio=".$numero_servicio."&id_vendedor=".$id_ventas."' class='btn btn-default' title='Agregar materiales' style='".$visivility."'  ><i class='glyphicon glyphicon-list-alt'></i></a> 		
		";
	}
}

	?>
</td>		
	<?php
	if($is_admin==1 || $is_admin== 3){

	
echo"
<td>
<a href='#' ".$estilo."  class='btn btn-default' title='Bolquear Remisión' onclick='obtener_bloqueo(".$id_servicio.");' data-toggle='modal' data-target='#myModalBloqueo'><i class='glyphicon glyphicon-ban-circle'></i></a> 
		
</td>


";

	}
	?>		
				</tr> 

					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pagination pull-right"><?php
					 //echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			  <script>
	var tabla = document.querySelector("#myTable2");
	var dataTable = new DataTable(tabla);
	</script>
			</div>
			<?php
		}
	
?>