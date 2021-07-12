<body>
	<div class="panel panel-white">
		<div class="row"><br>
			<div class="col-md-10">
				<p align="left">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<b>En esta secci&oacute;n puede indicar la el tipo de falla de los trabajadores que acontinuación se describen.</b>
				</p>
			</div>
			<div class="col-md-1" align="center"></div>
		</div>
		<div class="panel-body">
			<div class="row">
				<!--<div class="col-md-1"></div>-->
				<div class="col-md-12">
					<form action="<?php echo base_url()?>transportes/datos/guardar_inasistencias" role="form" id="form1" method="post" autocomplete="off">
						<table id="example1">
							<thead>
								<th>NOMBRE TRABAJADOR</th>
								<th>APELLIDO TRABAJADOR</th>
								<th>TIPO TRABAJADOR</th>
								<th>CODIGO CAMION</th>
								<th>INASISTENCIA</th>							
								<th>COMENTARIOS</th>
							</thead>
							<tbody>	
								<?php 
								if ($trabajadores_inasistentes != FALSE) {
									$i=1;		
									foreach ($trabajadores_inasistentes as $row) { ?>

										<tr>

											<td><?php echo strtoupper($row->nombre); ?>
												<input type="hidden" name="id_trabajador[<?php echo $i ?>]" id="id_trabajador" value="<?php echo $row->id?>" />
											</td>
											<td><?php echo strtoupper($row->ap);?> <?php echo strtoupper($row->am); ?></td>
											<?php if($row->cargo == 72){ ?>
												<td><span class="label label-danger">Chofer</span></td>
												<?php }elseif ($row->cargo == 73) { ?>
													<td><span class="label label-warning">Peoneta</span></td>
													<?php } ?>
													<td align="center"><?php echo $row->ccu; ?></td>
													<td>
														<select id="id_select_inasistencia" name="id_select_inasistencia[<?php echo $i ?>]" required>
															<option>[Seleccionar..]</option>
															<option value="1">Con Goce de Sueldo</option>
															<option value="2">Sin Goce de Sueldo</option>
															<option value="3">Vacaciones</option>
															<option value="4">Licencias</option>
															<option value="5">Aunsencia Injustificada</option>
														</select>
														<input type="hidden" id="vuelta" name="vuelta[<?php echo $i ?>]" value="<?php echo $vueltas; ?>" />
														<input type="hidden" id="fecha_trabajar" name="fecha_trabajar[<?php echo $i ?>]" value="<?php echo $fecha_trabajar; ?>" />
														<input type="hidden" id="id_ccu_oculto" name="id_ccu_oculto[<?php echo $i ?>]" value="<?php echo $row->id_ccu; ?>" />
													</td>
													<td><textarea class="form-control" id="comentario" name="comentario[<?php echo $i ?>]" required></textarea>
													</td>			
												</tr>		
												<?php
												$i++;   
											}?>
											<?php }?>


										</tbody>
									</table>
									<div class="row">
										<div class="col-md-8"></div>
										<div class="col-md-4">
											<button class="btn btn-danger btn-block" type="submit" name="guardar" title="GUARDAR INASISTENCIAS">
												Guardar Inasistencias
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>						
					</div>
				</div>

			</body>