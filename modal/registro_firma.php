<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="guardarFirma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Datos de envío/contacto</h4>
		  </div>
		  <div class="modal-body">

          <canvas id="canvas" width="400" height="200"></canvas><br>
            
			  
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" id="clearBtn" class="btn btn-default" onclick="limpiar()" data-dismiss="modal">Limpiar firma</button>
			<button type="submit" class="btn btn-primary" onclick="saveImage()" id="guardar_firma">Guardar firma</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>