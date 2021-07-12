
<body>
	<div class="panel panel-white"><br>
		<div class="col-md-10">
			<p align="left">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				En esta secci&oacute;n usted podra:<strong><i>ingresar ranking trabajadores.</i></strong>
			</p>
		</div><br>
		<div class="col-md-5">
			<div class="form-group">
				<label class="col-md-3 control-label" for="textinput">Fecha Actual</label>  
				<div class="col-md-2">
					<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker" type="text" id="datepicker" class="datepicker" value="<?php echo $fecha_mostrar; ?>" size="10" readonly="true" title="Fecha"/> 

					<select id="fecha" name="fecha"  >
					<option value="2019-01-01">enero</option>
					<option value="2019-02-01">Febrero</option>
				</select>
				</div>
			</div>
		</div>



		<div class="panel-body">
			<form action="<?php echo base_url()?>transportes/ranking/guardar_ranking" role="form" id="form1" method="post" autocomplete="off">
				<table id="example1">
					<thead>
						<tr>
							<th>N°</th>
							<th>Nombre</th>
							<th>Rut</th>
							<th>Cargo</th>
							<th>T. Contrato</th>
							<th>Amonestaciones</th>
							<th>Inasistencias</th>
							<th>Falta Dinero</th>
							<th>Rechazo Caja</th>
							<th>Rechazo Cliente</th>
							<th>Aseo y Mantención</th>
							<th>Quejas y Reclamos</th>
							<th>Total Ranking</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i=1;
						foreach ($lista_aux as $row) { ?>
							<tr>
								<td><?php echo $row->id;?>
									 <input type="hidden" name="id_trabajador[<?php echo $i ?>]" id="id_trabajador" value="<?php echo $row->id?>" />
									<input type="hidden" name="fecha_mostrar" id="fecha_mostrar" value="<?php echo $fecha_mostrar ?>">
								</td>
								<td><?php echo $row->ap;?> <?php echo $row->am;?> <?php echo $row->nombre;?></td>
								<td><?php echo $row->rut;?></td>
								<?php switch ($row->cargo) {
									case '72': ?>
									<td><span class="label label-success">Chofer</span></td>
									<?php	break; ?>
									<?php case '73': ?>
									<td><span class="label label-warning">Ayudante</span></td>
									<?php	break; ?>

									<?php	default:
									# code...
									break;
								}?>

								<td><?php echo $row->nombre_convenio;?></td>
								<td>
									<div class="form-group">
										<div class="col-md-2">
											<input style="width: 90px;" id="amonesta[<?php echo $i ?>]" name="amonesta[<?php echo $i ?>]" type="number" value="<?php echo $row->amonesta; ?>" class="form-control input-md" min="0">
										</div>
									</div>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-2">
											<input style="width: 90px;" id="inasistencia[<?php echo $i ?>]" name="inasistencia[<?php echo $i ?>]" type="number" value="<?php echo $row->inasis; ?>" class="form-control input-md" min="0">
										</div>
									</div>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-2">
											<input style="width: 90px;" id="falta_dinero[<?php echo $i ?>]" name="falta_dinero[<?php echo $i ?>]" type="number" value="<?php echo $row->falta_dinero; ?>" class="form-control input-md" min="0">
										</div>
									</div>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-2">
											<input style="width: 90px;" id="r_caja[<?php echo $i ?>]" name="r_caja[<?php echo $i ?>]" type="number" value="<?php echo $row->r_caja; ?>" class="form-control input-md" min="0">
										</div>
									</div>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-2">
											<input style="width: 90px;" id="r_cliente[<?php echo $i ?>]" name="r_cliente[<?php echo $i ?>]" type="number" value="<?php echo $row->r_cliente; ?>" class="form-control input-md" min="0">
										</div>
									</div>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-2">
											<input style="width: 90px;" id="aseo[<?php echo $i ?>]" name="aseo[<?php echo $i ?>]" type="number" value="<?php echo $row->aseo; ?>" class="form-control input-md" min="0">
										</div>
									</div>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-2">
											<input style="width: 90px;" id="quejas[<?php echo $i ?>]" name="quejas[<?php echo $i ?>]" type="number" value="<?php echo $row->quejas; ?>" class="form-control input-md" min="0">
										</div>
									</div>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-2">
											<input style="width: 90px;" id="total[<?php echo $i ?>]" name="total[<?php echo $i ?>]" type="number" value="<?php echo $row->total; ?>" class="form-control input-md" min="0">
										</div>
									</div>
								</td>

							</tr>	
							<?php
							$i++;   
						}?>

					</tbody>
				</table>
				<div class="row">
					<div class="col-md-8"></div>
					<div class="col-md-4">
						<button class="btn btn-success btn-block" type="submit" name="guardar" title="GUARDAR RANKING">
						Guardar Ranking
						</button>
					</div>
				</div>

			</form>
		</div>
	</div>
</body>