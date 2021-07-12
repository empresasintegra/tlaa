<script type="text/javascript">
function valida_dias_habiles(){
	var dias = document.getElementById("dias_habiles").value;
	if(confirm('Estas seguro que son ' + dias + ' dias habiles?'))
		return true;
	else
		return false;
}
</script>
<body>
	<form action="<?php echo base_url()?>transportes/bonos_trabajador/calcular_bonos_trabajador" method="post" onsubmit="return valida_dias_habiles()">	
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
                         <select name="mes" id="mes">
							<option value="<?php echo '20',date('y');?>-01-01">Enero</option>
							<option value="<?php echo '20',date('y');?>-02-01">Febrero</option>
							<option value="<?php echo '20',date('y');?>-03-01">Marzo</option>
							<option value="<?php echo '20',date('y');?>-04-01">Abril</option>
							<option value="<?php echo '20',date('y');?>-05-01">Mayo</option>
							<option value="<?php echo '20',date('y');?>-06-01">Junio</option>
							<option value="<?php echo '20',date('y');?>-07-01">Julio</option>
							<option value="<?php echo '20',date('y');?>-08-01">Agosto</option>
							<option value="<?php echo '20',date('y');?>-09-01">Septiembre</option>
							<option value="<?php echo '20',date('y');?>-10-01">Octubre</option>
							<option value="<?php echo '20',date('y');?>-11-01">Noviembre</option>
							<option value="<?php echo '20',date('y');?>-12-01">Diciembre</option>
							
						</select>

					</div>
					
					<!--<div class="col-md-2">
						<input autocomplete="off" style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker" type="text" id="datepicker" class="datepicker" size="10" value="<?php echo $fecha_inicio; ?>" placeholder="Desde" title="Fecha" required/> 
					</div>
					<div class="col-md-2"> 
						<input autocomplete="off" style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker2" type="text" id="datepicker2" class="datepicker2" size="10" placeholder="Hasta" title="Fecha" required/> 
					</div>	-->		  
				</div>
				<div class="col-md-2">	
				</div>

			</div><br>
			<div class="row">
				<div class="col-md-2">	
				</div>
				<div class="col-md-8">
				<!--	<div class="col-md-2">	
						Dias Hábiles:
					</div>
					<div class="col-md-2">
						<select name="dias_habiles" id="dias_habiles">
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
							<option value="24">24</option>
							<option value="25" selected>25</option>
							<option value="26">26</option>
						</select>
					</div>	-->			  
				</div>
				<div class="col-md-2">	
				</div>
			</div><br>
			<div class="panel-body">	
				<div class="row">
					<div class="col-md-2">
					</div>	
					<!--<div class="col-md-8">
						<div class="form-group">
							<label class="col-md-2 control-label" for="radios">Seleccione Cierre de Mes (Opcional)</label>
							<div class="col-md-4"> 
								<label class="checkbox-inline" for="cierre_mes">
									<input type="checkbox" name="cierre_mes" id="cierre_mes" value>
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