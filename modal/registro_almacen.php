<?php
		if (isset($con))
		{
	?>
	<?
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoAlmacen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo almacen</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_almacen" name="guardar_almacen">
			<div id="resultados_ajax_productos"></div>
			  
			<div class="form-group">
				<label for="clave" class="col-sm-3 control-label">Clave</label>
				<div class="col-sm-8">
				<?php
				$sql_almacen=mysqli_query($con,"SELECT * FROM almacenes01  ORDER BY clave DESC ");
        		$almacen=mysqli_fetch_array($sql_almacen);
				$clave_id=$almacen['clave']+1; 
		?>
				 <input type="text" class="form-control" id="clave" name="clave" placeholder="Clave sugerida  <?php echo $clave_id ;?>" required>
				</div>
			  </div>

			  <div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Descripción</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripción o nombre del almacén" required>
				</div>
			  </div>
			  
			  
			  <div class="form-group">
				<label for="encargado" class="col-sm-3 control-label">Encargado</label>
				<div class="col-sm-8">
				<input type="text" class="form-control" id="encargado" name="encargado" placeholder="Encargado" required>
				
				</div>
			  </div>
			  
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>