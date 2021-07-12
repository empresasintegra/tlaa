<body>
	<div class="panel panel-white">
		<div class="row">
			<div class="col-md-10">
				<div class="col-md-2" align="center">
					<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<p align="left"><b><font style="font-size: 15px;" color="#006B12">Seleccione Rango Fecha</font></b></p>         
				</div>
				<div class="form-style" id="contact_form">
					<div class="col-md-2">
						<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<label for="datepicker">Fecha Inicio</label>
						<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="fecha_desde" type="text" id="datepicker" class="datepicker" value="<?php echo $fecha; ?>" size="10" readonly="true" title="Fecha Desde"/>
					</div>
					<div class="col-md-2" style="margin-top: 15px;">
						<br>&nbsp;&nbsp;
						<button id="calcula_boton" type="submit" class="btn btn-success">Calcular</button>
					</div>
				</div>				
			</div>
		</div>
		
	</div>	
</body>