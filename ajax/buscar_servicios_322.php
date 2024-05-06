<?php

	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	echo "<script>console.log('estamos aqui".$_SESSION['user_id']."') </script>";
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$numero_factura=intval($_GET['id']);
		$del1="delete from servicios where numero_servicio='".$numero_factura."'";
		$del2="delete from detalle_servicio where numero_servicio ='".$numero_factura."'";
		$del3="delete from materiales_servicio where numero_servicio='".$numero_factura."'";
		if ($delete1=mysqli_query($con,$del1) and $delete2=mysqli_query($con,$del2) and $delete3=mysqli_query($con,$del3)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo eliminar los datos
			</div>
			<?php
			
		}
	}
	if($action == 'ajax'){
		$usuario = $_SESSION['user_id'];
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		  $sTable = "servicios, clientes, users";
		 $sWhere = "";
		 $sWhere.=" WHERE servicios.id_hospital=clientes.id_cliente and servicios.id_vendedor=users.user_id";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (clientes.nombre like '%$q%' or servicios.numero_factura like '%$q%')";
			
		}
		
		$sWhere.=" order by servicios.id_servicio desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere ");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './servicios_integrales.php';
		//main query to fetch the data
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$session_id2 = $_SESSION["user_id"];
		$sql_usuario1=mysqli_query($con,"select * from users where user_id ='$session_id2'");
        $rj_usuario1=mysqli_fetch_array($sql_usuario1);
		//echo "<script>console.log('work:".$rj_usuario1['is_admin']."');</script>";

		if ($rj_usuario1['is_admin']!=2){
	    $sql="SELECT * FROM $sTable  $sWhere LIMIT $offset,$per_page  ";
		//echo "<script>console.log('admin');</script>";
	}else if ($rj_usuario1['is_admin']==2){
			$sql="SELECT s.id_servicio,s.numero_servicio,s.id_hospital,id_vendedor,s.derecho_habiente,s.fecha_cirugia,s.paterno,s.materno,s.nombre_paciente,s.fecha_nacimiento,s.expediente,
			s.sexo,s.edad,s.sala,s.hora_inicio,s.hora_termino,s.turno,s.diagnostico,s.estado_servicio,s.fecha_servicio,c.id_cliente,c.clave,c.nombre_cliente,c.rfc,c.calle,c.numint,c.numext,c.colonia,c.telefono,c.emailpred,u.user_id,u.nombre,u.user_name,u.user_email,u.letra,u.is_admin 
			FROM servicios s INNER JOIN clientes c  ON c.id_cliente = s.id_hospital INNER JOIN users u on u.user_id = s.id_vendedor WHERE s.id_vendedor=$usuario LIMIT $offset,$per_page  ";
		
			//echo "<script>console.log('no admin');</script>";
		}
		$query = mysqli_query($con, $sql);		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table  table-striped" id="myTable2">
				<tr  class="info">
					<th class="hidden-xs" >Remisión No./Cliente</th>
						<th class="hidden-xs">Fecha</th>
				<th class=' hidden-xs'>Expediente</th>
				<th class=' hidden-xs'>Paciente</th>
				<th class="hidden-xs">Técnico</th>
				<th class="hidden-xs">Estado Factura</th>
				<th class="hidden-xs">Hoja de consumo</th>
					<th class=' hidden-xs'>Remisión SUMED</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_servicio=$row['id_servicio'];
						$id_vendedor=['id_vendedor'];
						$numero_servicio=$row['numero_servicio'];
					    $letra_ventas = $row['letra'];
						$fecha=date("d/m/Y", strtotime($row['fecha_servicio']));
						$nombre_cliente=$row['nombre_cliente'];
						$telefono = $row['telefono'];
						$email = $row['emailpred'];
						$paciente =$row['nombre_paciente']." ".$row['paterno']." ".$row['materno'];
						$nombre_vendedor=$row['nombre'];
						$expediente=$row['expediente'];
						$estado_servicio=$row['estado_servicio'];
						if ($estado_servicio==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}
						$total_venta=$row['total_venta'];
					?>



					<!-- <input type="hidden" value="<?php echo $estado_factura;?>" id="estado<?php echo $id_factura;?>">
					
					<tr>
						<td class="columnas"><ul><li><?php echo substr($nombre_cliente,0,25);?></li><li><?php echo $letra_ventas."-".$numero_servicio; ?></li></td>
						<td class="hidden-xs "><?php echo $fecha; ?></td>
						<td class="hidden-xs "><?php echo $expediente; ?></td>
						<td class="hidden-xs columnas"><?php echo $paciente; ?></td>	
						<td class="hidden-xs "><?php echo $nombre_vendedor; ?></td> -->
					<?php 
							// if($estado_servicio==1){
								
							// 	$factura_status = "<span class='label label-info'>SIN FACTURAR</span>";
							// }else{
							// 	$factura_status = "<span class='label label-success'>FACTURADA</span>";
							// }
					?>
						<!-- <td class="hidden-xs columnas"><?php echo $factura_status; ?></td>
							<td> -->
				<?php
								
$session_id = $_SESSION["user_id"];
$sql_usuario=mysqli_query($con,"select * from users where user_id ='$session_id'");
$rj_usuario=mysqli_fetch_array($sql_usuario);

if ($rj_usuario['is_admin']==1){
	$consulta_admin=mysqli_query($con,"select * from materiales_servicio where numero_servicio = '$numero_servicio'");
	$count_admin=mysqli_num_rows($consulta_admin);
	if($count_admin>0){
	 
	}else{	
		echo "
		 		
		";
	}
	
	echo"
	
	<a href='#' class='btn btn-default' title='Ver Hoja de consumo' onclick='ver_consumo(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-eye-open'></i></a> 
	<a href='#' class='btn btn-default' title='Descargar Remisión' onclick='imprimir_consumo(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-download'></i></a> 
	
  ";}
  else if($rj_usuario['is_admin']==2){
	$consulta=mysqli_query($con,"select * from materiales_servicio where id_servicio = '$id_servicio' and id_vendedor=$session_id");
	$count=mysqli_num_rows($consulta);
	if($count>0){
	
	}
	echo "
	<a href='#' class='btn btn-default' title='Ver Hoja de consumo' onclick='ver_consumo(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-eye-open'></i></a> 
	<a href='#' class='btn btn-default' title='Descargar Remisión' onclick='imprimir_consumo(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-download'></i></a> 
	";
	 echo "
	
</td>";

}
  
	
	else if($rj_usuario['is_admin']==3){
		$consulta=mysqli_query($con,"select * from materiales_servicio where id_servicio = '$id_servicio' and id_vendedor=$session_id");
		$count=mysqli_num_rows($consulta);
		if($count>0){
		
		}
		echo "
		<a href='#' class='btn btn-default' title='Ver Hoja de consumo' onclick='ver_consumo(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-eye-open'></i></a> 
	<a href='#' class='btn btn-default' title='Descargar Remisión' onclick='imprimir_consumo(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-download'></i></a> 
	";
		 echo "
		
	</td>";

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

<td class="columnas"><?php 


$session_id = $_SESSION["user_id"];
$sql_usuario=mysqli_query($con,"select * from users where user_id ='$session_id'");
$rj_usuario=mysqli_fetch_array($sql_usuario);

if ($rj_usuario['is_admin']==1){
	$consulta_admin=mysqli_query($con,"select * from materiales_servicio where numero_servicio = '$numero_servicio'");
	$count_admin=mysqli_num_rows($consulta_admin);
	if($count_admin>0){
	 
	}else{
		
			
		echo "
		<a href='agregar_materiales.php?id_servicio=".$id_servicio."&numero_servicio=".$numero_servicio."' class='btn btn-default' title='Agregar materiales' ><i class='glyphicon glyphicon-list-alt'></i></a> 		
		";
	}
	
	echo"
	<a href='editar_servicio.php?id_servicio=".$id_servicio."' class='btn btn-default' title='Editar factura' ><i class='glyphicon glyphicon-edit'></i></a>
	<a href='#' class='btn btn-default' title='Ver Remisión' onclick='ver_factura(".$id_servicio.",".$numero_servicio.",".$id_materiales.");'><i class='glyphicon glyphicon-eye-open'></i></a>
	<a href='#' class='btn btn-default' title='Descargar Remisión' onclick='imprimir_factura(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-download'></i></a> 
	<a href='#' class='btn btn-default' title='Borrar Remisión' onclick='eliminar(".$numero_servicio.");'><i class='glyphicon glyphicon-trash'></i> </a>
  ";}
	
	else if($rj_usuario['is_admin']==2){
		$consulta=mysqli_query($con,"select * from materiales_servicio where id_servicio = '$id_servicio' and id_vendedor=$session_id");
		$count=mysqli_num_rows($consulta);
		if($count>0){
		
		}
		echo "
		<a href='agregar_materiales.php?id_servicio=".$id_servicio."&numero_servicio=".$numero_servicio."' class='btn btn-default' title='Agregar materiales' ><i class='glyphicon glyphicon-list-alt'></i></a> 		
		";
		 echo "
		
	<a href='#' class='btn btn-default' title='Ver remisión' onclick='ver_factura(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-eye-open'></i></a>
	<a href='#' class='btn btn-default' title='Descargar remisión' onclick='imprimir_factura(".$id_servicio.",".$numero_servicio.");'><i class='glyphicon glyphicon-download'></i></a>
	</td>";

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
				</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pagination pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
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
	}
?>