
<body>
	<form action="<?php echo base_url()?>transportes/bonos_trabajador2/calcular_bonos_trabajador2" method="post" onsubmit="return valida_dias_habiles()">	
		<div class="panel panel-white">
			<div class="row">
			</div><br>
			<div class="row">
				<div class="col-md-2">	
				</div>
				<div class="col-md-8">
					<h3>
					<p style="color: red;">Ingrese rango de fecha para calcular bonos a trabajadores.</p></h3>
				</div>
				<div class="col-md-2">	
				</div>
			</div></br>
			<div class="row">
				<div class="col-md-2">	
				</div>
				<div class="col-md-8">
					<div class="col-md-2">	
						Seleccione Fecha:
					</div>
					<div class="col-md-2">
						<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker" type="text" id="datepicker" class="datepicker" size="10" value="<?php echo $fecha_inicio; ?>" placeholder="Desde" title="Fecha" required/> 
					</div>
					<div class="col-md-2"> 
						<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker2" type="text" id="datepicker2" class="datepicker2" size="10" placeholder="Hasta" title="Fecha" autocomplete="off" required/> 
					</div>				  
				</div>
				<div class="col-md-2">	
				</div>

			</div><br>
			<div class="row">
				<div class="col-md-2">	
				</div>
				<div class="col-md-8">
					  
				</div>
				<div class="col-md-2">	
				</div>
			</div><br>
			<div class="panel-body">	
				<div class="row">
					<div class="col-md-2">
					</div>	

					<input type="hidden" name="dias_habiles" id="dias_habiles" value="0">
					<!--<div class="col-md-8">
						<div class="form-group">
							<label class="col-md-2 control-label" for="radios">Seleccione Cierre de Mes (Opcional)</label>
							<div class="col-md-4"> 
								<label class="checkbox-inline" for="cierre_mes">
									<input type="checkbox" name="cierre_mes" id="cierre_mes" value="1">
									Cerrar Mes
								</label>
							</div>
						</div>
					</div>-->
					<div class="col-md-2">
					</div>
				</div><br>
				<div class="row">					
							<div class="col-md-2"></div>
							<div class="col-md-6"></div>
							<div class="col-md-2">
								<button class="btn btn-success btn-block" type="submit" name="guardar" title="CALCULAR BONOS">
									Calcular Bonos
								</button>
							</div>
							<div class="col-md-2"></div>			
				</div><br>
				</div>
			</div>
		</div>
	</form>
</body>