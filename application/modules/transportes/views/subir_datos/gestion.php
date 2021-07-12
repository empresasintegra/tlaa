<body>
	<form action="<?php echo base_url() ?>transportes/subir_datos/inserta_datos" role="form" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
		<div class="panel panel-white"><br>
		<!--  *Modificar el model si_sube_datos
			  *modificar el controlador	-->
			<div class="row">
				<div class="col-md-1"></div>
			</div>
			<div class="modal-header" style="text-align:center">
				<div align="right" title="ir al controlador 'subir_datos', ir al model 'si_sube_datos' y modificar los campos indicados">?</div>
				<h4 class="modal-title" id="exampleModalLabel">Subir Datos</h4>
				
			</div>
			<br>
			<div align="center">
			<label>Ingreso de Datos:</label>
			<input type='hidden' name="fecha2" id="fecha2" value=""/>
			<input id="filebutton" name="dato" class="input-file" type="file" required="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" name="actualizar" class="btn btn-primary">Subir Archivo</button>
			</div>

		</div> 
	</form>
</body>