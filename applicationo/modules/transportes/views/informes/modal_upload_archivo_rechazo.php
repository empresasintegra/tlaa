<body>
	<form action="<?php echo base_url() ?>transportes/informes/inserta_rechazo/" role="form" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
		<div class="panel panel-white"><br>
			<div class="row">
				<div class="col-md-1"></div>
			</div>
			<div class="modal-header" style="text-align:center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Subir Rechazo</h4>
			</div>
			<br>
			
			<label>Ingreso de Rechazo: <?php echo $fecha ?></label>
			<input type='hidden' name="fecha2" id="fecha2" value="<?php echo $fecha ?>"/>
			<input id="filebutton" name="dato" class="input-file" type="file" required="">
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" name="actualizar" class="btn btn-primary">Subir Archivo</button>
			</div>

		</div> 
	</form>
</body>


