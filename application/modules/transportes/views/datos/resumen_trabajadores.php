<body>
	<div class="panel panel-white"><br>
		<div class="row">
			<div class="col-md-8">

			</div>
			<div class="col-md-4" align="center">           
				<a data-toggle="modal" class="btn btn-green" href="<?php echo base_url()?>transportes/datos/agrega_nuevo_registro_chofer/<?php echo $fecha; ?>" data-target="#modal_agrega_nuevo_registro_chofer">Insertar Choferes</a>
				<a data-toggle="modal" class="btn btn-green" href="<?php echo base_url()?>transportes/datos/agrega_nuevo_registro_peoneta/<?php echo $fecha; ?>" data-target="#modal_agrega_nuevo_registro_peoneta">Insertar Peonetas</a>
			</div>

			<div class="col-md-1" align="center"></div>
		</div><br>
		<div class="col-md-10">
			<!-- Text input-->
			<div class="col-md-5">
				<div class="form-group">
					<label class="col-md-3 control-label" for="textinput">Fecha Actual</label>  
					<div class="col-md-2">
						<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker" type="text" id="datepicker" class="datepicker" value="<?php echo $fecha; ?>" size="10" readonly="true" title="Fecha"/> 
					</div>
				</div>
			</div>
		</div><br>

		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<form action="<?php echo base_url()?>transportes/datos/continua_ingreso_produccion" role="form" id="form1" method="post" autocomplete="off">
						<input name="fecha_registro" type="hidden" id="fecha_registro" value="<?php echo $fecha; ?>"/>
						<table id="example1">
							<thead>
								<!--<th>/</th>-->
								<!--<th>Rut</th>-->
								<th>Nombre</th>
								<th>Cargo</th>
								<th>Motivo</th>
								<th>Comentario</th>
							</thead>
							<tbody>
								<?php
								$i = 0;
								foreach ($trabajadores as $datos){?>
									<tr>
										<!--<td><?php //echo $datos->id_trabajador ?></td>-->
										<!--<td><?php //echo $datos->rut?></td>-->
										<td><?php echo $datos->ap?> <?php echo $datos->am?> <?php echo $datos->nombre?></td>
										<td><?php echo $datos->cargo?></td>
										<td>
											<input type="hidden" name="trabajadores[<?php echo $i; ?>]" id="trabajadores[<?php echo $i; ?>]" value="<?php echo $datos->id_trabajador ?>">                    
											<?php if ($datos->estado == 0) { ?>
												<div class="controls">
													<select name="id_select_inasistencia[<?php echo $i; ?>]" id="id_select_inasistencia[<?php echo $i; ?>]">
														<option>Seleccione</option>
														<?php foreach ($listar_faltas as $r) {
															echo '<option value="',$r->id,'">',$r->nombre_falta,'</option>';
														} ?>
													</select>
												</div>
												<?php }else{?>
													<div class="controls">
														<select name="id_select_inasistencia[<?php echo $i; ?>]" id="id_select_inasistencia[<?php echo $i; ?>]" >
															<option value="<?php echo $datos->estado; ?>"><?php echo $datos->nombre_falta; ?></option>
															<?php foreach ($listar_faltas as $r) {
																echo '<option value="',$r->id,'">',$r->nombre_falta,'</option>';
															} ?>
														</select>
													</div>
													<?php }?>                                                  
												</td>
												<td>
													<!-- Textarea -->
													<div class="form-group">
														<div class="col-md-4"> 
															<textarea class="form-control" id="comentario[<?php echo $i; ?>]" name="comentario[<?php echo $i; ?>]" value=""><?php echo $datos->comentario; ?></textarea>
														</div>
													</div>
												</td>	
									</tr>
								<?php
								$i++;
								}  
								?>
							</tbody>
						</table>
						<div class="row">
							<div class="col-md-8"></div>
							<div class="col-md-4">
								<button class="btn btn-success btn-block" type="submit" name="guardar" title="GUARDAR INASISTENCIAS TRABAJADORES">
									Guardar Inasistencias y Continuar
								</button>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</body>
		<!-- Modal Agregar chofer-->
		<div class="modal fade" id="modal_agrega_nuevo_registro_chofer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Ingreso Choferes</h4>
					</div>
					<div class="modal-body">

					</div>
				</div>
			</div>
		</div>

		<!-- Modal Agregar chofer-->
		<div class="modal fade" id="modal_agrega_nuevo_registro_peoneta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Ingreso Ayudantes</h4>
					</div>
					<div class="modal-body">

					</div>
				</div>
			</div>
		</div>