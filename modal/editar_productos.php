	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<?
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	?>
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar producto</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_producto" name="actualizar_producto">
			<div id="resultados_ajax2"></div>
			  
			<div class="form-group">
				<label for="clave" class="col-sm-3 control-label">SKU</label>
				<div class="col-sm-8">
				
				  <input type="text" class="form-control" id="mod_clave" name="mod_clave" placeholder="Código SKU del producto" >
				  <input type="hidden" id="mod_id" name="mod_id">
				</div>
			  </div>

			  <div class="form-group">
				<label for="referencia" class="col-sm-3 control-label">Clave Alterna</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_referencia" name="mod_referencia" placeholder="Clave Alterna o referencia" required>
				</div>
			  </div>
			  
			  
			  <div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="mod_descripcion" name="mod_descripcion" placeholder="Descripción del producto" required maxlength="150" ></textarea>
				  
				</div>
			  </div>
			  
			  
			
		
			 
			  <div class="form-group">
				<label for="precio" class="col-sm-3 control-label">Existencia</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_exist" name="mod_exist" placeholder="Existencias que va a ocupar" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			  </div>
			 
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>