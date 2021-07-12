<body>
	<form action="<?php echo base_url()?>transportes/produccion/genera_informe_general" role="form" id="form1" method="post" autocomplete="off">	
		<div class="panel panel-white">
			<div class="row">
				
			</div><br>
			<div class="row">
				<div class="col-md-1">	
				</div>
				<div class="col-md-10">
					<h3>
					<p style="color: red;">Antes de Generar Informe de Producción, favor procesar liquidaciones de sueldo para el correcto cálculo de bono de producción.</p></h3>
				</div>
			</div></br>
			<div class="row">
				<div class="col-md-1">	
				</div>
				<div class="col-md-10">
					<div class="col-md-2">	
						Seleccione Fecha:
					</div>
					<div class="col-md-2">
						<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker" type="text" id="datepicker" class="datepicker" size="10" placeholder="Desde" title="Fecha" required/> 
					</div>
					<div class="col-md-2"> 
						<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker2" type="text" id="datepicker2" class="datepicker2" size="10" placeholder="Hasta" title="Fecha" required/> 
					</div>				  
				</div>
				<div class="col-md-1">	
				</div>

			</div><br>
			
			<div class="panel-body">	
				<div class="row">

					<div class="col-md-12">
						
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
			</div>
		</div>
	</form>
</body>