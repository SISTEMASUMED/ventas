<?php

	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_costo=intval($_GET['id']);
		$query=mysqli_query($con, "select * from lista_costos where id_costo ='".$id_costo."'");
		$count=mysqli_num_rows($query);}
		

	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
		
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 
		 $aColumns = array('referencia','descripcion','proveedor');//Columnas de busqueda
		 $sTable = "lista_costos";
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
		$reload = './costos.php';
		//main query to fetch the data
		$sql="SELECT * from $sTable $sWhere LIMIT $offset, $per_page ";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
		$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
			?>
			<div class="table-responsive">
			  <table class="table  table-striped" id="producTable">
				<tr  class="info">
                <th class="hidden-xs">Proveedor</th>
					<th>Referencia</th>
					<th class="hidden-xs">Familia</th>
					<th class="hidden-xs">Producto</th>
                    <th class="hidden-xs">Costo</th>
					<th class="hidden-xs">Unidad</th>
					<th class='hidden-xs text-right'>Acciones</th>
					
				</tr>
				<?php

				while ($row=mysqli_fetch_array($query)){
						$id_costo=$row['id_costo'];
                        $proveedor=$row['proveedor'];
						$referencia=$row['referencia'];
                        $unidad=$row['unidad'];
						$familia=$row['familia'];
						$especialidad=$row['especialidad'];
						$descripcion=$row['descripcion'];
						$costo=$row['costo'];

						
					
					?>
					
					<input type="hidden" value="<?php echo $proveedor;?>" id="proveedor<?php echo $id_costo;?>">
					<input type="hidden" value="<?php echo $referencia;?>" id="referencia<?php echo $id_costo;?>">
					<input type="hidden" value="<?php echo $descripcion;?>" id="descripcion<?php echo $id_costo;?>">
                    <input type="hidden" value="<?php echo $unidad;?>" id="unidad<?php echo $id_costo;?>">
					<input type="hidden" value="<?php echo $costo;?>" id="costo<?php echo $id_costo;?>">
					
					<!--<input type="hidden" value="<?php echo number_format($precio_producto,2,'.','');?>" id="precio_producto<?php echo $id_costo;?>">-->
					<tr>
						
						<td class="columnas hidden-xs"><?php echo $proveedor; ?></td>
						<td  class="columnas"><?php echo $referencia; ?></td>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-tags'></i><?php echo " ".$proveedor;?><br><i class='glyphicon glyphicon-star'></i><?php echo $especialidad;?>"><?php echo $familia;?></a></td>
						<td  class="columnas "><?php echo $descripcion; ?></td>
                        <td  class="columnas"><?php echo $simbolo_moneda;?><span class=''><?php echo number_format($costo,2); ?></td>
                        <td  class="columnas "><?php echo $unidad; ?></td>
				<?php 

					$session_id = $_SESSION["user_id"];
					$sql_usuario=mysqli_query($con,"select * from users where user_id ='$session_id'");
					$rj_usuario=mysqli_fetch_array($sql_usuario);

					if ($rj_usuario['is_admin']==1){
                          echo "		
					<td class='hidden-xs'><span class='pull-right'>
					<a href='#' class='btn btn-default' title='Editar producto' onclick='obtener_datos(".$id_costo.");' data-toggle='modal' data-target='#myModal2'><i class='glyphicon glyphicon-edit'></i></a> 
					<a href='#' class='btn btn-default' title='Borrar producto' onclick='eliminar(".$id_costo.");'><i class='glyphicon glyphicon-trash'></i> </a></span></td>";
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