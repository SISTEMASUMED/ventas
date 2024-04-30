<?php

error_reporting(0);
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$numero_factura=intval($_GET['id']);
		
		/*$del1="delete from facturas where numero_factura='".$numero_factura."'";
		$del2="delete from detalle_factura where numero_factura='".$numero_factura."'";*/
		$sql_1=mysqli_query($con,"select * from facturas where numero_factura='".$numero_factura."'");
		$rj_1=mysqli_fetch_array($sql_1);
		$estado_factura=$rj_1['estado_factura'];
		if ($estado_factura==1){
			$update_factura="UPDATE facturas SET status_fact=0 WHERE numero_factura='".$numero_factura."'";
			if ($update1=mysqli_query($con,$update_factura)){
				?>
				<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
				  <strong>Aviso!</strong> Remisión Cancelada Exitosamente!
				</div>
				<?php 
			}else {
				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
				  <strong>Error!</strong> No se puede cancelar esta remisión
				</div>
				<?php
				
			}
		}
		else{
			?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
				  <strong>Error!</strong> Esta remisión ya esta facturada, no se puede cancelar!
				</div>
				<?php
			
		}



	}
	if($action == 'ajax'){
		$usuario = $_SESSION['user_id'];
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		
		$fColumns = array('factura.numero_factura','clientes.nombre_cliente','users.user_name');//Columnas de busqueda
		$sTable = "facturas, clientes, users";
		 $sWhere = "";
		 $sWhere.=" WHERE facturas.id_cliente=clientes.id_cliente and facturas.id_vendedor=users.user_id ";
		if ( $_GET['q'] != ""  )
		{
			$sWhere = "WHERE (  ";
			for ( $i=0 ; $i<count($fColumns) ; $i++ )
			{
				$sWhere .= $fColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}            
		
		$sWhere.=" order by facturas.id_factura desc";

		$status=1;
		$sWhere2 = "";
		$aColumns = array('user_name','numero_factura');//Columnas de busqueda
		$sTable2 = "f.id_factura,f.numero_factura,f.fecha_factura,f.id_cliente,f.id_vendedor,f.total_venta,f.estado_factura,f.compra,f.cotizacion,f.doctor,f.paciente,f.material,
		f.pago,f.d_factura,f.observaciones,f.status_fact,
		c.id_cliente,c.clave,c.nombre_cliente,c.rfc,c.calle,c.numint,c.numext,c.colonia,c.telefono,c.emailpred,
		u.user_id,u.nombre,u.user_name,u.user_email,u.letra,u.is_admin 
		FROM facturas f INNER JOIN clientes c  ON c.id_cliente = f.id_cliente 
		INNER JOIN users u on u.user_id = f.id_vendedor 
		";
		
		$sWhere2.=" WHERE f.id_vendedor=$usuario  and status_fact=1";
		if ( $_GET['q'] != "" )
			{
				$sWhere2 = "WHERE ( " ;
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					$sWhere2 .= $aColumns[$i]." LIKE '%".$q."%' OR ";
				}
				$sWhere2 = substr_replace( $sWhere2, "", -3 );
				$sWhere2 .= ')';
			}            
			
	   $sWhere2.=" order by f.id_factura desc";
	   echo"<script>console.log('work:".$sWhere2."');</script>";
	   echo"<script>console.log('work:".$q."');</script>";
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
		$reload = './facturas.php';
		$session_id2 = $_SESSION["user_id"];
		$sql_usuario1=mysqli_query($con,"select * from users where user_id ='$session_id2'");
        $rj_usuario1=mysqli_fetch_array($sql_usuario1);
		//echo "<script>console.log('work:".$rj_usuario1['is_admin']."');</script>";

		if ($rj_usuario1['is_admin']!=2){
	    	$sql="SELECT * FROM $sTable   $sWhere  LIMIT $offset,$per_page  ";
		}else if ($rj_usuario1['is_admin']==2){
			$sql="SELECT $sTable2  $sWhere2 LIMIT $offset,$per_page";
		}
		$query = mysqli_query($con, $sql);		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table  table-striped" id="myTable">
				<tr  class="info">
					<th class="hidden-xs" >Remisión No./Cliente</th>
						<th class="hidden-xs">Fecha</th>
				<th class=' hidden-xs'>Total</th>
				<th class="hidden-xs">Vendedor</th>
				<th class="hidden-xs">Estado Remisión</th>
				<th>Status en Sistema</th>
					<th class=' hidden-xs'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_factura=$row['id_factura'];
						$numero_factura=$row['numero_factura'];
					    $letra_ventas = $row['letra'];
						$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						$nombre_cliente=$row['nombre_cliente'];
						$telefono = $row['telefono'];
						$email = $row['emailpred'];
						$nombre_vendedor=$row['nombre'];
						$estado_factura=$row['estado_factura'];
						/*if ($estado_factura==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}*/
						if($estado_factura==1){
								
							$factura_status = "<span class='label label-info'>SIN FACTURAR</span>";
						}else{
							$factura_status = "<span class='label label-success'>FACTURADA</span>";
						}
						$total_venta=$row['total_venta'];
						$status_fact=$row['status_fact'];
							if($status_fact==1){
								$status_fact="ACTIVA";
							}else{
								$status_fact="CANCELADA";
							} 	
									
					?>

					<input type="hidden" value="<?php echo $estado_factura;?>" id="estado<?php echo $id_factura;?>">
					
					<tr>
						<td class="columnas"><ul><li><?php echo substr($nombre_cliente,0,25);?></li><li><?php echo $letra_ventas."-".$numero_factura; ?></li></td>
						<td class="hidden-xs columnas"><?php echo $fecha; ?></td>
						<td class='hidden-xs text-left columnas'>$<?php echo number_format ($total_venta,2); ?></td>	
						<td class="hidden-xs "><?php echo $nombre_vendedor; ?></td>
						<td class="hidden-xs columnas"><?php echo $factura_status; ?></td>
						<td class="columnas"><?php echo $status_fact; ?></td>
						<td class="columnas"><?php 


$session_id = $_SESSION["user_id"];
$sql_usuario=mysqli_query($con,"select * from users where user_id ='$session_id'");
$rj_usuario=mysqli_fetch_array($sql_usuario);

if ($rj_usuario['is_admin']==1){
	  echo "
			
	<a href='editar_factura.php?id_factura=".$id_factura."' class='btn btn-default' title='Editar factura' ><i class='glyphicon glyphicon-edit'></i></a>
	<a href='#' class='btn btn-default' title='Ver factura' onclick='ver_factura(".$id_factura.",".$numero_factura.");'><i class='glyphicon glyphicon-eye-open'></i></a> 
	<a href='#' class='btn btn-default' title='Descargar factura' onclick='imprimir_factura(".$id_factura.",".$numero_factura.");'><i class='glyphicon glyphicon-download'></i></a> 
	<a href='#' class='btn btn-default' title='Borrar factura' onclick='eliminar(".$numero_factura.");'><i class='glyphicon glyphicon-remove'></i> </a>
";
	}
	else if($rj_usuario['is_admin']==2){
		 echo "
	<a href='editar_factura.php?id_factura=".$id_factura."' class='btn btn-default' title='Editar factura' ><i class='glyphicon glyphicon-edit'></i></a>
	<a href='#' class='btn btn-default' title='Ver factura' onclick='ver_factura(".$id_factura.",".$numero_factura.");'><i class='glyphicon glyphicon-eye-open'></i></a>
	<a href='#' class='btn btn-default' title='Descargar factura' onclick='imprimir_factura(".$id_factura.",".$numero_factura.");'><i class='glyphicon glyphicon-download'></i></a>
	<a href='#' class='btn btn-default' title='Borrar factura' onclick='eliminar(".$numero_factura.");'><i class='glyphicon glyphicon-remove'></i> </a>
</td>";

	}else if($rj_usuario['is_admin']==4){
		echo "
		 
	<a href='#' class='btn btn-default' title='Ver factura' onclick='ver_factura(".$id_factura.",".$numero_factura.");'><i class='glyphicon glyphicon-eye-open'></i></a>
	<a href='#' class='btn btn-default' title='Descargar factura' onclick='imprimir_factura(".$id_factura.",".$numero_factura.");'><i class='glyphicon glyphicon-download'></i></a>
</td>";
	}else {
		echo "
		
	<a href='#' class='btn btn-default' title='Editar estado' onclick='obtener_datos(".$id_factura.");' data-toggle='modal' data-target='#myModal9'><i class='glyphicon glyphicon-edit'></i></a> 
	<a href='#' class='btn btn-default' title='Ver factura' onclick='ver_factura(".$id_factura.",".$numero_factura.");'><i class='glyphicon glyphicon-eye-open'></i></a>
	<a href='#' class='btn btn-default' title='Descargar factura' onclick='imprimir_factura(".$id_factura.",".$numero_factura.");'><i class='glyphicon glyphicon-download'></i></a>
</td>";
	}

	?>					</td>
						
						

					
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
	var tabla = document.querySelector("#myTable");
	var dataTable = new DataTable(tabla);
	</script>
			</div>
			<?php
		}
	}
?>