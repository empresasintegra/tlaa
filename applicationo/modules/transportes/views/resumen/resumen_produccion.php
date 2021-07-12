<body>
	
	<form action="<?php echo base_url()?>transportes/resumen/genera_informe_produccion" role="form" id="form1" method="post" autocomplete="off">
		<div class="panel panel-white">
			<div class="row"></div><br>
			<div class="row">
				<div class="col-md-1">	
				</div>
				<div class="col-md-10">
					<div class="col-md-2">	
						Seleccione Fecha:
					</div>
					<div class="col-md-2"> Desde
						<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker" type="text" id="datepicker" class="datepicker" size="10" title="Fecha" required/> 
					</div>
					<div class="col-md-2"> Hasta
						<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker2" type="text" id="datepicker2" class="datepicker2" size="10" title="Fecha" required/> 
					</div>				  
				</div>
				<div class="col-md-1">	
				</div>

			</div><br>
			
			<div class="panel-body">	
				<div class="row">

					<div class="col-md-12">
						<table id="example1">
							<thead>
								<th style="width:50px;">Todos<br>&nbsp;<input type="checkbox" onchange="togglecheckboxes(this,'usuarios[]')"></th>
								<th>Rut</th>								
								<th>Nombres</th>
								<th>Cargos</th>
								<th>Tipo Contr</th>
							</thead>
							<tbody>
								<?php
								$i = 1;
								foreach ($listado_seleccion as $datos){
									?>
									<tr>									

										<td style="width:53px;"><input type="checkbox" name="usuarios[]" value="<?php echo $datos->id_trabajador ?>"></td>
										<td><?php echo $datos->rut?></td>
										<td><?php echo $datos->apellido_paterno?> <?php echo $datos->apellido_materno?> <?php echo $datos->nombre?></td>
										<td><?php echo $datos->cargos?></td>
										<td ><?php echo $datos->nombre_instrumento_colectivo?></td>
										         
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
								<button class="btn btn-success btn-block" type="submit" name="guardar" title="GENERAR INFOMES">
									Generar Informes
								</button>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</form>
</body>