<div id="modal">
	<div class="modal-header" style="text-align:center">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos Camiones</h4>
	</div>
	<div id="modal_content">
		<div class="modal-header">
			<strong>Agregar Trabajadores Camion</strong> <strong><?php echo $codigo;?></strong><br>
		</div><br>
		<div class="row">
		<div class="col-md-6">
		     <strong>Choferes</strong>
		</div>		
		<div class="col-md-6">
		    <strong>Peonetas</strong>
		</div>	   
		</div>
		<form action="<?php echo base_url() ?>transportes/asignacion/agregar_trabajadores" role="form" id="form2" method='post' name="f2" autocomplete="off">

		<input type="hidden" name="id_camion" id="id_camion" value="<?php echo $codigo;?>" />
			<div class="col-md-6">
			
			<?php
			$x= 0;
			if ($choferes != FALSE){
				foreach ($choferes as $row){
					$x +=1;
					?>

						<div class="control-group">

							<div class="controls">
								<input type="radio"  
								value="<?php echo $row->c_chofer; ?>"; name="chofer[<?php echo $x ?>]" id="id_chofer[]"/> 
								
								<input type="hidden" name="id_cargo_c[<?php echo $x?>]" value="<?php echo $row->c_cargo ?>" id="id_cargo_c[]"/>	
								<label><?php echo $row->c_nombre?>&nbsp;<?php echo $row->c_ap?>&nbsp;<?php echo $row->c_am?></label>

							</div>
						</div>   			

					<?php
				}
			}else{
				?>
				<p style='color:#088A08; font-weight: bold;'>OCURRIO UN ERROR EN LA CONSULTA.</p>
				<?php
			}
			?>
			</div>

			<div class="col-md-6">

			<?php
			$i = 0;
			if ($peonetas != FALSE){
				foreach ($peonetas as $row1){
					$i += 1;
					?>

						<div class="control-group">

							<div class="controls">
								<input type="checkbox"  
								value="<?php echo $row1->c_peoneta; ?>" name="peonetas[<?php echo $i ?>]" id="peonetas]"/>

								<input type="hidden" name="id_cargo_p[<?php echo $i?>]" value="<?php echo $row1->p_cargo ?>" id="id_cargo_p[]"/>
								<label><?php echo $row1->p_nombre?>&nbsp;<?php echo $row1->p_ap?>&nbsp;<?php echo $row1->p_am?></label>

							</div>
						</div>   			

					<?php
				}
			}else{
				?>
				<p style='color:#088A08; font-weight: bold;'>OCURRIO UN ERROR EN LA CONSULTA.</p>
				<?php
			}
			?>
			</div>

			<br><br><br><br><br><br><br><br><br><br><br><br>
			<div class="modal-footer">
				<button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
			</div>
		</form>
	</div>
</div>