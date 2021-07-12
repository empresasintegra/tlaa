	<script>
		function habilitar(value)
		{
			if(value=="1")
			{
				// deshabilitando
				document.getElementById("datepicker").disabled=true;
				document.getElementById("datepicker2").disabled=true;
				document.getElementById("codigosccu").disabled=true;
				document.getElementById("proveedores").disabled=true;
				document.getElementById("repuesto").disabled=true;

			}else if(value=="2"){
				// habilitando
				document.getElementById("datepicker").disabled=false;
				document.getElementById("datepicker2").disabled=false;
				document.getElementById("codigosccu").disabled=false;
				document.getElementById("proveedores").disabled=false;
				document.getElementById("repuesto").disabled=false;
			}
		}
	</script>
<body>
	<form action="<?php echo base_url()?>transportes/mantenciones/filtro_mantencion" method="post" onsubmit="return valida_dias_habiles()">	
		<div class="panel panel-white">
			
			<div class="row">
				<div class="col-md-2">	
				</div>
				<div class="col-md-8">
					<h3>
					<p style="color: blue;">Seleccione  filtros para  ver las mantenciones</p></h3>
				</div>
				<div class="col-md-2">	
				</div>
			</div></br>

			<div class="row">
				<div class="col-md-2">	
				</div>
				<div class="col-md-8">
					<div class="col-md-2">	
					 Mantenciones de hoy:
					</div>
					<div class="col-md-2">
						<input type="radio" title="Aplicar" name="hoy" id="hoy" value="1" onchange="habilitar(this.value);">
						<input type="radio" title="Seleccionar otros filtros" name="hoy" id="hoy"  checked value="2" onchange="habilitar(this.value);">
						 <br>
					</div>
					  
				</div>
				<div class="col-md-2">	
				</div>

			</div><br>

			<div class="row">
				<div class="col-md-2">	
				</div>
				<div class="col-md-8">
					<div class="col-md-2">	
					 Rango Fecha:
					</div>
					<div class="col-md-2">
						<input style="margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker" type="text" id="datepicker" class="datepicker" size="10"  placeholder="Desde" title="Fecha" /> 
					</div>
					<div class="col-md-2"> 
						<input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker2" type="text" id="datepicker2" class="datepicker2" size="10" placeholder="Hasta" title="Fecha" /> 
					</div>				  
				</div>
				<div class="col-md-2">	
				</div>

			</div><br>

			<div class="row">
				<div class="col-md-2">	
				</div>
				<div class="col-md-8">
					<div class="col-md-2">	
						camion
					</div>
                    <select name="codigosccu" id="codigosccu">
                      <option value="">todos</option>
                      <?php foreach ($codigosccu as $codigoccu) { ?>
                            <option  value="<?php echo $codigoccu->idcodigos_ccu ?>"><?php echo $codigoccu->codigos_ccu; ?></option>
                      <?php } ?>
                    </select>				  
				</div>
				<div class="col-md-2">	
				</div>
			</div><br>

			<div class="row">
				<div class="col-md-2">	
				</div>
				<div class="col-md-8">
					<div class="col-md-2">	
						proveedores
					</div>
  			     <select name="proveedores" id="proveedores">
                            <option value="">todos</option>
                            <?php 
                                foreach ($proveedores as $proveedor) { 
                            ?>
                                <option  value="<?php echo $proveedor->id ?>"><?php echo $proveedor->nombre_proveedor; ?></option>
                            <?php 
                                } 
                            ?>
			      </select>			  
				</div>
				<div class="col-md-2">	
				</div>
			</div><br>

			<div class="row">
				<div class="col-md-2">	
				</div>
				<div class="col-md-8">
					<div class="col-md-2">	
						repuestos
					</div>
                      <select   name="repuesto" id="repuesto" class="repuesto">
                          <option value="">todos</option>
                          <?php 
                              foreach ($repuestos as $repuesto) { 
                          ?>
                             <option  value="<?php echo $repuesto->id ?>"><?php echo $repuesto->nombre_repuesto; ?></option>
                          <?php
                              } 
                          ?>
                        </select>		  
				</div>
				<div class="col-md-2">	
				</div>
			</div><br>
				<div class="panel-body">	
				
					<div class="row">					
								<div class="col-md-2"></div>
								<div class="col-md-4"></div>
								<div class="col-md-4">
									<button class="btn btn-success btn-block" type="submit" name="guardar" title="CALCULAR BONOS">
										Generar
									</button>
								</div>
								<div class="col-md-2">
									
								</div>			
					</div><br>
				</div>
			</div>
		</div>
	</form>
</body>