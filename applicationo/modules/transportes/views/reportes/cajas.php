<body>
	<form action="<?php echo base_url()?>transportes/reportes/reporte_por_trabajador" role="form" id="form1" method="post" autocomplete="off">	
		<div class="panel panel-white">
			<div class="row">
			</div><br>
			<div class="row">
				<div class="col-md-1">	
				</div>
				<div class="col-md-10">
					<div class="col-md-2">	
						<p>Seleccione Fecha: </p>
					</div>
					<div class="col-md-2">
						<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker" type="text" id="datepicker" class="datepicker" size="10" placeholder="Desde" title="Fecha" required/> 
					</div>
					<div class="col-md-2"> 
						<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker2" type="text" id="datepicker2" class="datepicker2" size="10" placeholder="Hasta" title="Fecha" required/>
					</div>
					<div class="col-md-2"> 
						<button class="btn btn-success btn-sm" type="submit" name="buscar" title="BUSCAR">
							Buscar
						</button>
					</div>				  
				</div>
				<div class="col-md-1">	
				</div>
				<legend></legend>
			</div>

			<div class="row">

			</div>

			<div class="panel panel-body">
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8">
						<table class="table table-bordered">
							<thead>
								<th style="width:50px;"><p><input name="Todos" type="checkbox" value="1" class="check_todos"/>Seleccionar todos</p></th>
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
										<td style="width:53px;"><input type="checkbox" name="usuarios[]" class="ck" value="<?php echo $datos->id_trabajador ?>"></td> 
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
					</div>
					<div class="col-md-2"></div>
				</div>
			</div>
		</form>
	</body>