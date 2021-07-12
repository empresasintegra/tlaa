<div id="modal">
	<div class="modal-header" style="text-align:center">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="exampleModalLabel">Ingresar Vuelta Camión</h4>
	</div>
	<div id="modal_content">
		
		<div class="row">
			<div class="col-md-6">
				<strong>Agregar Trabajadores Vueltas Camion</strong> <strong><?php echo $c_camion;?></strong><br>

			</div>
			<div class="col-md-6 text-right">
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_trabajadores">Agregar Trabajadores</button>

			</div>
		</div>			
	</div><br>
	<input type="hidden" id="id_camion" name="id_c" value="<?php echo $c_camion;?>" />
	<div class="row">
		<form action="#" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
			<div class="col-md-6">



				<div class="control-group">
					<label class="control-label" for="inputTipo">Rutas</label>
					<div class="controls">
						<select name="id_select_ruta" id="id_select_ruta" required>
							<option value="id_select_ruta">Seleccione Ruta</option>
							<?php
							foreach ($listarutas as $data)
								echo '<option value="',$data->id,'">',$data->nombre_rutas,'</option>';
							?>
						</select>
					</div><br>
					<label class="control-label" for="inputTipo">Cajas Entrega</label>
					<div class="controls">
						<input type="number"></input>
					</div><br>
					<label class="control-label" for="inputTipo">Cajas Rechazos</label>
					<div class="controls">
						<input type="number"></input>
					</div>
					<div class="controls">
						 <input type='text' class="input-mini" name="nombre" id="nombre" value="nombre" disabled/>
						  <input type='text' class="input-mini" name="apellido" id="apellido" value="apellido" disabled/>
					</div>							

				</div>
			</div>

			<div class="col-md-6">
				<label class="control-label" for="inputTipo">Listado de Trabajadores</label>
				<div class="control-group">
					<label class="control-label">Choferes</label>
					<div id="trabajadores" class="controls">						
						<?php foreach ($todos_choferes as $row) { ?>
						<div id="chofer"class="controls">
							<label><?php echo strtoupper($row->nombre_persona); ?>&nbsp;<?php echo strtoupper($row->ap); ?>&nbsp;<?php echo strtoupper($row->ap); ?></label><input type="hidden" size="20" name="chofer[]" value="<?php echo $row->id_trabajador; ?>"/> 

							<span><a href="#" onclick="borrar();">Borrar</a></span>
						</div><br>
						<?php } ?>							
						<label class="control-label" for="inputTipo">Peonetas</label>
						<?php foreach ($todos_peonetas as $l) { ?>
						<div id="peonetas" class="controls">
							<label><?php echo strtoupper($l->nombre_persona); ?>&nbsp;<?php echo strtoupper($l->ap); ?>&nbsp;<?php echo strtoupper($l->am); ?></label><input type="hidden" size="20" name="id_chofer[]" value="<?php echo $l->id_trabajador; ?>"/> 
							<a href="#" onclick="borrar_p();">Borrar</a>
						</div>
						<?php } ?>

						<br>
					</div>
				</div>
				<div class="modal-footer" style="margin-top: 25px">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_trabajadores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="text-align:center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Ingresar Vuelta Camión</h4>
			</div>


			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<strong>Choferes</strong>
					</div>		
					<div class="col-md-6">
						<strong>Peonetas</strong>
					</div>	   
				</div>

				<div class="row">

					<div class="col-md-6">

						<?php
						$x= 0;
						if ($choferes != FALSE){
							foreach ($choferes as $row){
								$x +=1;
								?>

								<div class="control-group">

									<div class="controls">
										<input type="checkbox" class="chk" value="<?php echo $row->c_chofer; ?>" name="chofer[<?php echo $x ?>]" id="id_chofer[]"/> 

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
										<input type="checkbox" class="chk" value="<?php echo $row1->c_peoneta; ?>" name="peonetas[<?php echo $i ?>]" id="peonetas[]"/>

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
					<div class="modal-footer" style="margin-top: 25px">
						<input type="button" class="btn" style="width:70px; height:30px;" value="Buscar" onclick="buscar_merma()">
					</div>	

				</div>


			</div>

		</div>
	</div>
</div>