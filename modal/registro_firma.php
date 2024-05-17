<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="guardarFirma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="">
	  <div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo cliente</h4>
		  </div>
		  <div class="modal-body">

		  <iframe src="firma.php" width="500" height="500"  frameborder="0"></iframe>
		  </div>
	  </div>
	</div>
	</div>
	<?php
		}
	?>