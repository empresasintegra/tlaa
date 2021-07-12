<body>
	<div class="panel panel-white">
		<div class="row">
			<div class="col-md-10">
				<div class="col-md-2" align="center">
					<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<p align="left"><b><font style="font-size: 15px;" color="#006B12">Seleccione Mes a Trabajar</font></b></p>         
				</div>
				<div class="form-style" id="contact_form">
					<div class="col-md-2">
						<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<label for="datepicker">Fecha</label>
						<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="fecha_desde" type="text" id="datepicker" class="datepicker" value="<?php echo $fecha; ?>" size="10" readonly="true" title="Fecha"/>
					</div>
					<div class="col-md-2" style="margin-top: 15px;">
						<br>&nbsp;&nbsp;
						<button id="calcula_boton_cajas" type="submit" class="btn btn-success">Generar Informe</button>
					</div>
				</div>				
			</div>
		</div>
	<div class="row"></div>
		<div class="panel panel-body">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<table id="example1">
						<thead >
							<th>Codigo Camión</th>
							<th>Tamaño Camión</th>
							<?php foreach ($fechas as $f) { ?>
								<th><?php echo $f; ?></th>
							<?php } ?>
						</thead>
						<tbody>

							<?php foreach ($lista_aux as $lista) { ?>
								<tr>									
									<td><?php echo $lista->codigo_camion; ?></td>
									<td><?php echo $lista->pallets; ?></td>
									<?php 								
										foreach ($lista->fechas as $key): ?>
											<td><?php echo $key->fecha_camion ?></td>
									<?php endforeach ?>



								</tr>								
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-md-1"></div>
			</div>
			<div class="row">
				<div class="col-md-10"></div>
				<div class="col-md-2">
					<button id="myButtonControlID" class="btn btn-green">Exportar a Excel</button>
				</div>
			</div>
		</div>
	</div>
</body>

<div id="divTableDataHolder" style="display:none">
	<meta content="charset=UTF-8"/>
	<table class="table table-bordered">
		<thead >
			<th>Codigo Camion</th>
			<th>Tamaño Camión</th>
			<?php foreach ($fechas as $f) { ?>
			<th><?php echo $f; ?></th>
			<?php } ?>
		</thead>
		<tbody>

			<?php foreach ($lista_aux as $lista) { ?>
			<tr>									
				<td><?php echo $lista->codigo_camion; ?></td>
				<td><?php echo $lista->pallets; ?></td>
				<?php foreach ($lista->fechas as $key): ?>
					<td><?php echo $key->fecha_camion ?></td>	

				<?php endforeach ?>


			</tr>								
			<?php } ?>
		</tbody>
	</table>
</div>