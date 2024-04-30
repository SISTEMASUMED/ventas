<?php

	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_producto=intval($_GET['id']);
		$query=mysqli_query($con, "select * from detalle_factura where id_producto ='".$id_producto."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			$sql_usuario=mysqli_query($con, "select * from inve01 where id_producto='".$id_producto."'");
			 $rw_producto=mysqli_fetch_array($sql_usuario);
		      $sku = $rw_producto['id_producto'];

			if ($delete=mysqli_query($con,"DELETE FROM inve01 WHERE id_producto ='".$sku."'")) {

						
				
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
	}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar éste  producto. Existen cotizaciones vinculadas a éste producto. 
			</div>
			<?php
		}
		
		
		}

	

	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
		
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 
		 $aColumns = array('inve01.clave','inve01.descripcion','inve01.clave_alterna');//Columnas de busqueda
		 $sTable = "inve01";
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
		/*$sWhere.=" order by id_producto asc";*/
		
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 15; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable ");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './productos.php';
		//main query to fetch the data
		$sql="SELECT * from $sTable $sWhere LIMIT $offset, $per_page ";
		//$sql="SELECT $sTable.id_producto, $sTable.clave as SKU, $sTable.clave_alterna as referencia, $sTable.descripcion as producto, ltpd01.CVE_ART, ltpd01.LOTE, ltpd01.CVE_ALM, ltpd01.CANTIDAD, almacenes01.clave as n_almacen, almacenes01.descripcion as nombre_almacen FROM $sTable INNER JOIN ltpd01 ON $sTable.clave = ltpd01.CVE_ART INNER JOIN almacenes01 ON almacenes01.clave = ltpd01.CVE_ALM $sWhere LIMIT $offset, $per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
		$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
			?>
			<div class="table-responsive">
			  <table class="table  table-striped" id="producTable">
				<tr  class="info">
					<th class="hidden-xs">Código SKU</th>
					<th class="hidden-xs">Referencia</th>
					<th class="hidden-xs">Producto</th>
					<th class='hidden-xs text-right'>Acciones</th>
					
				</tr>
				<?php

				while ($row=mysqli_fetch_array($query)){
						$id_producto=$row['id_producto'];
						$clave=$row['clave'];
						$referencia=$row['clave_alterna'];
						$descripcion=$row['descripcion'];
						//$lote=$row['LOTE'];
						//$almacen=$row['CVE_ALM'];
						
					?>
					
					<input type="hidden" value="<?php echo $clave;?>" id="clave<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $referencia;?>" id="referencia<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $descripcion;?>" id="descripcion<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $existencias;?>" id="existencias<?php echo $id_producto;?>">
					
					<!--<input type="hidden" value="<?php echo number_format($precio_producto,2,'.','');?>" id="precio_producto<?php echo $id_producto;?>">-->
					<tr>
						<td class="columnas hidden-xs"><?php echo $clave; ?></td>
						<td  class="columnas"><?php echo $referencia; ?></td>
						<td  class="columnas "><?php echo $descripcion; ?></td>
						
						<!--<td><?php echo $simbolo_moneda;?><span class='pull-right'><?php echo number_format($precio_producto,2);?></span></td>-->
				<?php 

					$session_id = $_SESSION["user_id"];
					$sql_usuario=mysqli_query($con,"select * from users where user_id ='$session_id'");
					$rj_usuario=mysqli_fetch_array($sql_usuario);

					if ($rj_usuario['is_admin']==1){
                          echo "		
					<td class='hidden-xs'><span class='pull-right'>
					<a href='#' class='btn btn-default' title='Editar producto' onclick='obtener_datos(".$id_producto.");' data-toggle='modal' data-target='#myModal2'><i class='glyphicon glyphicon-edit'></i></a> 
					<a href='#' class='btn btn-default' title='Borrar producto' onclick='eliminar(".$id_producto.");'><i class='glyphicon glyphicon-trash'></i> </a></span></td>";
						}?>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=6><span class="pull-right">
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