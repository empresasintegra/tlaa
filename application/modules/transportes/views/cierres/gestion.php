<body>
    <form action="<?php echo base_url()?>transportes/cierres/continuar" role="form" id="form1" method="post" autocomplete="off">   
        <div class="panel panel-white">
            <div class="row">
                
            </div><br>
            <div class="row">
                <div class="col-md-1">  
                </div>
                <div class="col-md-10">
                    <h3>
                    <p style="color: red;">Ingrese rango para abrir días.</p></h3>
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
                    <div class="col-md-2"> 
                        <button class="btn btn-success" type="submit" name="guardar" title="CALCULAR BONOS"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>                
                </div>
                <div class="col-md-1">  
                </div>

            </div><br>
            
            <div class="panel-body">    
               
            </div>
        </div>
    </form>
</body>