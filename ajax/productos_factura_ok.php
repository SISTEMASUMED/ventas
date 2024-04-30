<?php


	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
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

	   //$sWhere.=" order by id_producto desc";
	   include 'pagination.php'; //include pagination file
	   //pagination variables
	   $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	   $per_page = 3; //how much records you want to show
	   $adjacents  = 4; //gap between pages after number of adjacents
	   $offset = ($page - 1) * $per_page;
	   //Count the total number of row in your table*/
	   $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable ");
	   $row= mysqli_fetch_array($count_query);
	   $numrows = $row['numrows'];
	   $total_pages = ceil($numrows/$per_page);
	   $reload = './productos.php';
	   //main query to fetch the data
	   $sql="SELECT * from $sTable $sWhere LIMIT $offset, $per_page";  
	   //$sql="SELECT $sTable.id_producto, $sTable.clave as SKU, $sTable.clave_alterna as referencia, $sTable.descripcion as producto, ltpd01.CVE_ART, ltpd01.LOTE, ltpd01.CVE_ALM, ltpd01.CANTIDAD, almacenes01.clave as n_almacen, almacenes01.descripcion as nombre_almacen FROM $sTable INNER JOIN ltpd01 ON $sTable.clave = ltpd01.CVE_ART INNER JOIN almacenes01 ON almacenes01.clave = ltpd01.CVE_ALM $sWhere LIMIT $offset, $per_page ";
	   //$sql="SELECT $sTable.id_producto, $sTable.CVE_ART as SKU, $sTable.DESCR as producto, $sTable.EXIST, cves_alter01.CVE_ART, cves_alter01.CVE_ALTER, ltpd01.CVE_ART, ltpd01.LOTE, ltpd01.CVE_ALM, ltpd01.CANTIDAD, almacenes01.CVE_ALM as n_almacen, almacenes01.DESCR as nombre_almacen FROM $sTable INNER JOIN cves_alter01 ON $sTable.CVE_ART = cves_alter01.CVE_ART INNER JOIN ltpd01 ON $sTable.CVE_ART = ltpd01.CVE_ART INNER JOIN almacenes01 ON almacenes01.CVE_ALM = ltpd01.CVE_ALM $sWhere LIMIT $offset,$per_page ";
	   $query = mysqli_query($con, $sql);
	   //loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table table-striped">
				<tr  class="info">
					<th class="hidden-xs">Código SKU</th>
					<th>Referencia</th>
					<th >Producto</th>
					<th >Almacén</th>
					<th class='text-right size-xl'>Lote</th>
					<th class='text-right'>Cantidad</th>
					<th class='text-right'>Precio</th>
					<th class='text-right'>Agregar</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_producto=$row['id_producto'];
						$clave=$row['clave'];
						$referencia=$row['clave_alterna'];
						$descripcion=$row['descripcion'];
						$existencias=$row['existencia'];
					?>
					<tr >
						 
						<td class="hidden-xs column-font-small"><?php echo $clave; ?></td>
						<td class="column-font-small"><?php echo $referencia; ?></td>
						<td class="column-font-small"><?php echo $descripcion; ?></td>
						<?php
						?>
						<td>
						<select class="" id="almacen_<?php echo $id_producto; ?>"style="width:130%;font-size:14px;">
							<option selected="selected" value="">Almacen</option>
						<?php $sql_almacen="SELECT * FROM almacenes01"; $query= mysqli_query($con, $sql_almacen);
						while($row_alm=mysqli_fetch_array($query))
								{
								?>
								<option value='<?php echo $clave=$row_alm['descripcion'];?>'><?php echo $row_alm['clave']."--".$desc_almacen=$row_alm['descripcion'];?></option>
								<?php
								}
								?>		
								</select>
							</td>
						<td class='size-xl col-sm-1'>
						<div class="pull-right">
						<input type="text" class="form-control" style="text-align:right; width:80%;margin-left:15%;" id="lote_<?php echo $id_producto; ?>" >
						</div></td>
						<td class='col-xs-1'>
						<div class="pull-right">
						<input type="text" class="form-control" style="text-align:right" id="cantidad_<?php echo $id_producto; ?>"  value="1" >
						</div></td>
						<td class='col-xs-2'><div class="pull-right">
						<input type="text" class="form-control" style="text-align:right" id="precio_venta_<?php echo $id_producto ;?>"  >
						<input type="hidden" class="form-control" style="text-align:right" id="referencia_<?php echo $id_producto; ?>"  value="<?php echo $referencia; ?>" >
						</div></td>
						<td class='text-center'><a class='btn btn-info'href="#" onclick="agregar('<?php echo $id_producto;?>')"><i class="glyphicon glyphicon-plus"></i></a></td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=5><span class="pull-right">
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