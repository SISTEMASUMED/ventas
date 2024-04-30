	<?php
		if (isset($con))
		{
	?>
	<?
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo producto</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_producto" name="guardar_producto">
			<div id="resultados_ajax_productos"></div>
			  
			<div class="form-group">
				<label for="clave" class="col-sm-3 control-label">SKU</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="clave" name="clave" placeholder="Código SKU del producto" required>
				</div>
			  </div>

			  <div class="form-group">
				<label for="referencia" class="col-sm-3 control-label">Clave Alterna</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Clave Alterna o referencia" required>
				</div>
			  </div>
			  
			  
			  <div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del producto" required maxlength="150" ></textarea>
				  
				</div>
			  </div>
			  
			 
			  <div class="form-group">
				<label for="precio" class="col-sm-3 control-label">Existencia</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="exist" name="exist" placeholder="Existencias que va a ocupar" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
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