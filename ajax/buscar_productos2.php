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
		      $sku = $rw_producto['CVE_ART'];

			if ($delete1=mysqli_query($con,"DELETE FROM ltpd01 WHERE CVE_ART ='".$sku."'"))
			{

				if($delete1=mysqli_query($con,"DELETE FROM cves_alter01 WHERE CVE_ART ='".$sku."'"))
				{
					if($delete1=mysqli_query($con,"DELETE FROM inve01 WHERE CVE_ART ='".$sku."'")) {

						
				
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
		  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
		</div>
		<?php
		
	}
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
			  <strong>Error!</strong> No se pudo eliminar éste  producto. Existen cotizaciones vinculadas a éste producto. 
			</div>
			<?php
		}
		
		
		}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('inve01.CVE_ART','inve01.DESCR','cves_alter01.CVE_ALTER');//Columnas de busqueda
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
		$sWhere.="";
		//$sWhere ="$sTable.CVE_ART = ltpd01.CVE_ART AND cves_alter01.CVE_ART = $sTable.CVE_ART";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable ");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './productos.php';
		//main query to fetch the data
		$sql="SELECT $sTable.id_producto, $sTable.CVE_ART as SKU, $sTable.DESCR as producto, $sTable.EXIST, cves_alter01.CVE_ART, cves_alter01.CVE_ALTER, ltpd01.CVE_ART, ltpd01.LOTE, ltpd01.CVE_ALM, ltpd01.CANTIDAD, almacenes01.CVE_ALM as n_almacen, almacenes01.DESCR as nombre_almacen FROM $sTable INNER JOIN cves_alter01 ON $sTable.CVE_ART = cves_alter01.CVE_ART INNER JOIN ltpd01 ON $sTable.CVE_ART = ltpd01.CVE_ART INNER JOIN almacenes01 ON almacenes01.CVE_ALM = ltpd01.CVE_ALM $sWhere LIMIT $per_page ";
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		//$sql = "SELECT  i.inve01,c.cves_alter01, $sTable.DESCR AS DESCRIPCION, $sTable.EXIST AS EXISTENCIAS_TOTALES,$sTable.id_producto AS id_producto, ltpd01.LOTE, ltpd01.FCHCADUC AS FECHA_CADUCACION, ltpd01.CANTIDAD AS CANTIDAD_POR_LOTE FROM  $sTable INNER JOIN cves_alter01 ON $sTable.CVE_ART =  cves_alter01.CVE_ART INNER JOIN ltpd01 ON $sTable.CVE_ART = ltpd01.CVE_ART LIMIT $offset,$per_page";
		//$sql = "SELECT  * FROM  inve01  ";
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Código SKU</th>
					<th>Referencia</th>
					<th>Producto</th>
					<th>Lote</th>
					<th>Almacén</th>
					<th>Existencias</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php

				while ($row=mysqli_fetch_array($query)){
						$id_producto=$row['id_producto'];
						$clave=$row['SKU'];
						$referencia=$row['CVE_ALTER'];
						$descripcion=$row['producto'];
						$lote=$row['LOTE'];
						$almacen=$row['CVE_ALM'];
						$existencias=$row['CANTIDAD'];
						
						/*if ($estatus=="A"){$estado="Activo";}
						else {$estado="Inactivo";}
						//$precio_producto=$row['precio_producto'];*/
					?>
					
					<input type="hidden" value="<?php echo $clave;?>" id="clave<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $referencia;?>" id="referencia<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $descripcion;?>" id="descripcion<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $lote;?>" id="lote<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $almacen;?>" id="almacen<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $existencias;?>" id="existencias<?php echo $existencias;?>">
					
					<!--<input type="hidden" value="<?php echo number_format($precio_producto,2,'.','');?>" id="precio_producto<?php echo $id_producto;?>">-->
					<tr>
						
						<td><?php echo $clave; ?></td>
						<td ><?php echo $referencia; ?></td>
						<td ><?php echo $descripcion; ?></td>
						<td ><?php echo $lote; ?></td>
						<td><?php echo $almacen;?></td>
						<td ><?php echo $existencias; ?></td>
						
						<!--<td><?php echo $simbolo_moneda;?><span class='pull-right'><?php echo number_format($precio_producto,2);?></span></td>-->
				<?php 

					$session_id = $_SESSION["user_id"];
					$sql_usuario=mysqli_query($con,"select * from users where user_id ='$session_id'");
					$rj_usuario=mysqli_fetch_array($sql_usuario);

					if ($rj_usuario['is_admin']==1){
                          echo "		
					<td ><span class='pull-right'>
					<!--<a href='#' class='btn btn-default' title='Editar producto' onclick='obtener_datos(".$id_producto.");' data-toggle='modal' data-target='#myModal2'><i class='glyphicon glyphicon-edit'></i></a>--> 
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