	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo cliente</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_cliente" name="guardar_cliente">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="nombre" name="nombre" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="rfc" class="col-sm-3 control-label">RFC</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="rfc" name="rfc" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="calle" class="col-sm-3 control-label">CALLE</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="calle" name="calle" >
				</div>
			 
			  </div>
			  <div class="form-group">
				<label for="numint" class="col-sm-3 control-label">NO.Interior</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="numint" name="numint" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="numext" class="col-sm-3 control-label">NO. Exterior</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="numext" name="numext" >
				</div>
			  </div>
			 
			  <div class="form-group">
				<label for="numext" class="col-sm-3 control-label">Colonia</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="colonia" name="colonia" >
				</div>
			  </div>

			  <div class="form-group">
				<label for="colonia" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="telefono" name="telefono" >
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="email" class="col-sm-3 control-label">Email</label>
				<div class="col-sm-8">
					<input type="email" class="form-control" id="emailpred" name="emailpred" >
				  
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