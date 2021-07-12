<script type="text/javascript">

	function bloquear_div_informes(){
		$('#div_liquidaciones *').prop('disabled',false);
	}

	function selecciona(sel){
		if (sel.value=="1"){
			$("#div_liquidaciones").show();
			$('#div_liquidaciones *').prop('disabled',false);
		}else{
			$("#div_liquidaciones").hide();
			$('#div_liquidaciones *').prop('disabled',true);
		}
		if (sel.value=="2"){
			$("#informe_general").show();
			$('#informe_general *').prop('disabled',false);
		}else{
			$("#informe_general").hide();
			$('#informe_general *').prop('disabled',true);
		}
	}


</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#guardar').click(function(){
			var selected = '';    
			$('#form1 input[type=checkbox]').each(function(){
				if (this.checked) {
					selected += $(this).val()+', ';
				}
			}); 

			if (selected != '') 
				alert('Has seleccionado: '+selected);  
			else
				alert('Debes seleccionar al menos una opción.');

			return false;
		});         
	});    
</script>


<body onload="bloquear_div_informes();">
	<div class="panel panel-white">
		<div class="row">
			<div class="row">
			</div><br>
			<div class="row">
				<div class="col-md-2">	
				</div>
				<div class="col-md-8">
					<div class="col-md-2">	
						<p>Fecha Seleccionada</p>
					</div>
					<div class="col-md-2">
						<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="fecha1" type="text" id="fecha1" value="<?php echo $fecha_1; ?>" size="10" placeholder="Desde" title="Fecha Desde" disabled/> 
					</div>
					<div class="col-md-2"> 
						<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="fecha2" type="text" id="fecha2" value="<?php echo $fecha_2; ?>" size="10" placeholder="Hasta" title="Fecha Hasta" disabled/>
					</div>
					<div class="col-md-2"> 
						
					</div>
					<legend></legend>				  
				</div>
				<div class="col-md-2">	
				</div>	
			</div>

			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">					
					<div class="form-group">
						<label class="col-md-2 control-label" for="radios">Seleccione Tipo Informe</label>
						<div class="col-md-4"> 
							<label class="radio-inline" for="radios-0">
								<input type="radio" name="radios" id="radios-0" value="1" onChange="selecciona(this)" checked="checked">
								Generar Liquidaciones 
							</label> 
							<label class="radio-inline" for="radios-1">
								<input type="radio" name="radios" id="radios-1" value="2" onChange="selecciona(this)">
								Generar Informe General de Produccion
							</label>
						</div>
					</div>
					<legend></legend>
				</div>
				<div class="col-md-2">					
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div id="div_liquidaciones" >
				<form action="<?php echo base_url()?>transportes/resumen/genera_informe_produccion" role="form" id="form1" method="post" autocomplete="off">
					<input type="hidden" name="dias_laborales" id="dias_laborales" value="<?php echo $dias_laborales ?>">
					<div class="row">
						<div class="col-md-2">
						</div>	
						<div class="col-md-8">
							
							<legend></legend>		
							<table id="example1">
								<thead>
									<th style="width:50px;">Todos<br>&nbsp;<input type="checkbox" onchange="togglecheckboxes(this,'usuarios[]')"></th>
									<th>Rut</th>								
									<th>Nombres</th>
									<th>Cargos</th>
									<th>Tipo Contr</th>
									<th>Empresa</th>
								</thead>
								<tbody>
									<?php
									$i = 1;
									foreach ($listado_seleccion as $datos){
										?>
										<tr>							
											<input name="datepicker" type="hidden" id="datepicker" value="<?php echo $fecha_1; ?>"/>
											<input name="datepicker2" type="hidden" id="datepicker2" value="<?php echo $fecha_2; ?>"/>
											
											<td style="width:53px;"><input type="checkbox" name="usuarios[]" value="<?php echo $datos->id_trabajador ?>"></td>
											<td><?php echo $datos->rut?></td>
											<td><?php echo $datos->apellido_paterno?> <?php echo $datos->apellido_materno?> <?php echo $datos->nombre?></td>
											<td><?php echo $datos->cargos?></td>
											<td ><?php echo $datos->nombre_instrumento_colectivo?></td>
											<td ><?php echo $datos->empresa?></td>

										</tr>  
										<?php
										$i++;
									}  
									?>							
								</tbody>
							</table>

						</div>
						<div class="col-md-2">					
						</div>
					</div>
					<div class="row">
						<div class="col-md-8"></div>
						<div class="col-md-4">
						    
							<button id="liquidaciones" class="btn btn-success btn-block" type="submit" name="guardar" title="GENERAR INFOMES">
								Generar Informes
							</button>
						    
						</div>
					</div>
				</form>
			</div>
			<div id="informe_general" style="display: none;">
				<form action="<?php echo base_url()?>transportes/produccion_nuevo/genera_informe_general" role="form" id="form1" method="post" autocomplete="off">	
					<input type="hidden" name="dias_laborales" id="dias_laborales" value="<?php echo $dias_laborales ?>">
					<div class="row">
						<div class="row">
							<div class="col-md-2">
								<input name="datepicker" type="hidden" id="datepicker" value="<?php echo $fecha_1; ?>"/>
								<input name="datepicker2" type="hidden" id="datepicker2" value="<?php echo $fecha_2; ?>"/>
							</div>
						</div><br>

						<div class="panel-body">
							<div class="col-md-2">
							</div>	
							<div class="col-md-8">
							<table id="example2">
	
								
									<thead>
										<th style="width:50px;">Todos<br>&nbsp;<input type="checkbox" onchange="togglecheckboxes(this,'usuarios_2[]')"></th>
										<th>Rut</th>
										<th>Nombres</th>
										<th>Cargos</th>
										<th>Tipo Contr</th>
										<th>Empresa</th>
									</thead>
									<tbody>
										<?php
										$i = 1;
										foreach ($listado_seleccion as $datos){
											?>
											<tr>							
												<input name="datepicker" type="hidden" id="datepicker" value="<?php echo $fecha_1; ?>"/>
												<input name="datepicker2" type="hidden" id="datepicker2" value="<?php echo $fecha_2; ?>"/>
												<td style="width:53px;"><input type="checkbox" name="usuarios_2[]" value="<?php echo $datos->id_trabajador ?>"></td>
												<td><?php echo $datos->rut?></td>
												<td><?php echo $datos->apellido_paterno?> <?php echo $datos->apellido_materno?> <?php echo $datos->nombre?></td>
												<td><?php echo $datos->cargos?></td>
												<td ><?php echo $datos->nombre_instrumento_colectivo?></td>
												<td ><?php echo $datos->empresa?></td>

											</tr>  
											<?php
											$i++;
										}  
										?>							
									</tbody>
								</table>
							</div>
							<div class="col-md-2">
							</div>								
							<div class="row">
								<div class="col-md-8"></div>
								<div class="col-md-4">
								  
									<button class="btn btn-success btn-block" type="submit" name="guardar" title="GENERAR CONSOLIDADO">
										Generar Consolidado
									</button>
								
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>