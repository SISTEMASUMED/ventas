<?php

	
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_cliente=intval($_GET['id']);
		$query=mysqli_query($con, "select * from facturas where id_cliente='".$id_cliente."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM clientes WHERE id_cliente='".$id_cliente."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar éste  cliente. Existen facturas vinculadas a éste producto. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nombre_cliente','rfc');//Columnas de busqueda
		 $sTable = "clientes";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere.=" order by nombre_cliente";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './clientes.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table  table-striped">
				<tr  class="info">
					<th class="columnas hidden-xs">Nombre</th>
					<th class="columnas hidden-xs">RFC</th>
					<th class="columnas hidden-xs">Teléfono</th>
					<th class="columnas hidden-xs">Email</th>
					<th class="columnas hidden-xs">Estado</th>
					<th class='text-right hidden-xs'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_cliente=$row['id_cliente'];
						$nombre=$row['nombre_cliente'];
						$rfc=$row['rfc'];
						$calle=$row['calle'];
						$numint=$row['numint'];
						$numext=$row['numext'];
						$colonia=$row['colonia'];
						$telefono=$row['telefono'];
						$emailpred=$row['emailpred'];
						
						
					?>
					
					<input type="hidden" value="<?php echo $row['nombre_cliente'];?>" id="nombre<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $row['rfc'];?>" id="rfc<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $row['calle'];?>" id="calle<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $row['numint'];?>" id="numint<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $row['numext'];?>" id="numext<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $row['colonia'];?>" id="colonia<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $row['telefono'];?>" id="telefono<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $row['emailpred'];?>" id="emailpred<?php echo $id_cliente;?>">
					
					<tr>
						
						<td class="columnas "><?php echo substr($nombre,0,25); ?></td>
						<td class="columnas "><?php echo $rfc; ?></td>
						<td class="columnas hidden-xs"><?php echo $telefono; ?></td>
						<td class="columnas hidden-xs"><?php echo $emailpred;?></td>
						
					
					<?php 

					$session_id = $_SESSION["user_id"];
					$sql_usuario=mysqli_query($con,"select * from users where user_id ='$session_id'");
					$rw_usuario=mysqli_fetch_array($sql_usuario);

					if ($rw_usuario['is_admin']==1){  
                          echo "	
					<td ><span class='pull-righ'>
					<a href='#' class='btn btn-default' title='Editar cliente' onclick='obtener_datos(". $id_cliente.");' data-toggle='modal' data-target='#myModal2'><i class='glyphicon glyphicon-edit'></i></a>
					<a href='#' class='btn btn-default' title='Borrar cliente' onclick='eliminar(".$id_cliente.");'><i class='glyphicon glyphicon-trash'></i> </a></span></td>";
						}?>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>