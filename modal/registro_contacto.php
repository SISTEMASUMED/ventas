<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="guardarContacto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Datos de envío/contacto</h4>
		  </div>
		  <div class="modal-body">

			<form class="form-horizontal" method="post" id="guardar_envio" name="guardar_envio">
			<div id="resultados_ajax_contacto"></div>

			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre de quien recibe</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="nombre" name="nombre" required>
				</div>
			  </div>
			 
			  <div class="form-group">
				<label for="calle" class="col-sm-3 control-label">Calle</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="calle" name="calle" >
				</div>
			  </div>
				<div class="form-group">
				<label for="colonia" class="col-sm-3 control-label">Colonia</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="colonia" name="colonia" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="numint" class="col-sm-3 control-label">No.Interior</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="numint" name="numint" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="numext" class="col-sm-3 control-label">No. Exterior</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="numext" name="numext" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="postal" class="col-sm-3 control-label">C.P.</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="postal" name="postal" >
				</div>
			  </div> 
			  <div class="form-group">
				<label for="colonia" class="col-sm-3 control-label">Teléfono de contacto</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="telefono" name="telefono" >
				</div>
			  </div>
			  
			  
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_contacto">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>