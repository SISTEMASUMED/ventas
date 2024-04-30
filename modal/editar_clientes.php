	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar cliente</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_cliente" name="editar_cliente">
			<div id="resultados_ajax2"></div>
			
			<div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_nombre" name="mod_nombre" value=" ">
				  <input type="hidden" id="mod_id" name="mod_id">
				</div>
			  </div>
			  <div class="form-group">
				<label for="rfc" class="col-sm-3 control-label">RFC</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_rfc" name="mod_rfc" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="calle" class="col-sm-3 control-label">CALLE</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_calle" name="mod_calle" >
				</div>
			 
			  </div>
			  <div class="form-group">
				<label for="numint" class="col-sm-3 control-label">NO.Interior</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_numint" name="mod_numint" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="numext" class="col-sm-3 control-label">NO. Exterior</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_numext" name="mod_numext" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="numext" class="col-sm-3 control-label">Colonia</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_colonia" name="mod_colonia" >
				</div>
			  </div>
			  			
			  <div class="form-group">
				<label for="colonia" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_telefono" name="mod_telefono" >
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="email" class="col-sm-3 control-label">Email</label>
				<div class="col-sm-8">
					<input type="email" class="form-control" id="mod_emailpred" name="mod_emailpred" >
				  
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