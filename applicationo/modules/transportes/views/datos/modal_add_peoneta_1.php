<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/DataTables/media/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css">
<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css">
<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-modal/css/bootstrap-modal.css">
<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-btns/css/btn.css">


<form action="<?php echo base_url() ?>transportes/datos/add_peoneta_1" role="form" id="form2" method='post' name="f2" autocomplete="off">

	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<input type="hidden" name="fecha_mostrar" id="fecha_mostrar" value="<?php echo $fecha;?>" />
			<input type="hidden" name="id_camion" id="id_camion" value="<?php echo $codigo;?>" />
			<input type="hidden" name="vuelta" id="vuelta" value="<?php echo $vuelta;?>" />
							
			
			<?php
			$x= 0;
			if ($peoneta != FALSE){
				foreach ($peoneta as $row){
					$x +=1;
					?>
					<div class="control-group">

						<div class="controls">
							<input type="radio"  
							value="<?php echo $row->id; ?>"; name="peoneta[]" id="id_peoneta[]"/>
							<label><?php echo strtoupper($row->ap)?> <?php echo strtoupper($row->am)?> <?php echo strtoupper($row->nombre)?></label>

						</div>
					</div>


					<?php
				}
				} ?>
						
		</div>

	</div>
	<div class="modal-footer">
		<button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		<button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
	</div>
</form>

<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/si_datepicker_asistencia.js"></script>
<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/si_dymanic_trabajadores.js"></script>
<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/si_exportar_excel.js"></script>
<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/main.js"></script>
<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/evaluar_pgp.js"></script>
<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/lista_usuarios_req.js"></script>

