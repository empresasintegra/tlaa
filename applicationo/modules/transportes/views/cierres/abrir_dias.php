<body>

    <form action="<?php echo base_url()?>transportes/cierres/abrir_fecha_seleccionada" role="form" id=  "form" method='post' autocomplete="off">
        <div class="panel panel-white"><br>
            
           <div class="row">
            
            <div class="col-md-1">  
            </div>
            <div class="col-md-10">
                <div class="col-md-2">  
                   Fecha Seleccionada:
               </div>
               <div class="col-md-2">
                <input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker" type="text"  size="10" value="<?php echo $fecha_1; ?>" title="Fecha" disabled />
                <input name="fecha_inicio" type="hidden"  size="10" value="<?php echo $fecha_1; ?>" title="Fecha" /> 
                </div>
                <div class="col-md-2"> 
                <input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker2" type="text" size="10" value="<?php echo $fecha_2; ?>" title="Fecha" disabled />
                <input name="fecha_fin" type="hidden"  size="10" value="<?php echo $fecha_2; ?>" title="Fecha" /> 
                </div>
                <div class="col-md-2"> 
                <button class="btn btn-success" type="submit" name="guardar" value="abrir" title="LIBERAR DÍAS"> Liberar Días</button>
                </div>
                <div class="col-md-2"> 
                <button class="btn btn-danger" type="submit" name="guardar" value="cerrar" title="ABRIR DÍAS"> Cerrar Días</button>
                </div>                
            </div>
        <div class="col-md-1">  
        </div>
        
    </div>
    <div class="panel-body">      
      <div class="row">	
         <div class="col-md-2"></div>
         <div class="col-md-8">
            <table class="table">
               <thead>	
                  <th> Fecha</th>
                  <th> Estado</th>
                  <th> Seleccionar Todos  <input type="checkbox" onchange="togglecheckboxes(this,'fechas[]')"></th>	      
              </thead>
              <tbody>
                <?php foreach ($lista_aux as $listar) { ?>
                <tr>
                    <td><?php echo $listar->fechas; ?></td>
                    <td><?php echo $listar->cierres; ?></td>
                    <td> <?php  echo $listar->check; ?>
                          <input type="hidden" name="fecha_seleccionada" value="<?php echo $listar->fechas; ?>">  
                    </td>    
                </tr>
                <?php 
            }
            ?>
        </tbody>	
    </table>
</div>	
<div class="col-md-2"></div>	

</div>
</div>
</div>
</form>
</body> 