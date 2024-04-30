<?php

error_reporting(0);
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$clave=intval($_GET['id']);
		$del1="delete from almacenes01 where clave='".$clave."'";
		
		if ($delete1=mysqli_query($con,$del1) and $delete2=mysqli_query($con,$del2)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Almacen Eliminado Exitosamente
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
		
		$fColumns = array('almacenes01.clave','almacenes01.descripcion','almacenes01.encargado');//Columnas de busqueda
		$sTable = "almacenes01";
		 $sWhere = "";
		 $sWhere.="";
		if ( $_GET['q'] != ""  )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($fColumns) ; $i++ )
			{
				$sWhere .= $fColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}            
		
		$sWhere.=" order by almacenes01.clave asc";

		include 'pagination.php'; //include pagination file
		/*pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere ");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './almacenes.php';
		//main query to fetch the data*/
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		//$session_id2 = $_SESSION["user_id"];
		//$sql_usuario1=mysqli_query($con,"select * from users where user_id ='$session_id2'");
       // $rj_usuario1=mysqli_fetch_array($sql_usuario1);
		//echo "<script>console.log('work:".$rj_usuario1['is_admin']."');</script>";

		
	    	$sql="SELECT * FROM $sTable  $sWhere ";
			//echo "<script>console.log('admin');</script>";
		
		$query = mysqli_query($con, $sql);		//loop through fetched data
		
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table  table-striped" id="myTable">
				<tr  class="info">
					<th class="" >NO. ALmacen</th>
					<th class="">Nombre Almacén</th>
				    <th class=''>Encargado</th>
					<th class=''>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$clave=$row['clave'];
						$descripcion=$row['descripcion'];
					    $encargado = $row['encargado'];
						
					?>

					
					
					<tr>
						
						<td class=" "><?php echo $clave; ?></td>
						<td class=" "><?php echo $descripcion; ?></td>
						<td class=" "><?php echo $encargado; ?></td>
						<td class="columnas"><?php 


$session_id = $_SESSION["user_id"];
$sql_usuario=mysqli_query($con,"select * from users where user_id ='$session_id'");
$rj_usuario=mysqli_fetch_array($sql_usuario);

if ($rj_usuario['is_admin']==1){
	  echo "
			
	<!--<a href='editar_almacen.php?id_almacen=".$clave."' class='btn btn-default' title='Editar almacen' ><i class='glyphicon glyphicon-edit'></i></a>-->
	<a href='#' class='btn btn-default' title='Eliminar' onclick='eliminar(".$clave.");'><i class='glyphicon glyphicon-trash'></i> </a>
";
	}
	else if($rj_usuario['is_admin']==2){
		 echo "
	";

	}else{
		echo "
	";
	}

	?>		</td>
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
	
?>