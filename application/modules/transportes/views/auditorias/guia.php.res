<body>
  <form action="<?php echo base_url() ?>transportes/auditoria/menu" role="form" id="form" method='post' autocomplete="off">
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-10">
          <p align="left">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong><i>Auditoria de movimientos en TLA</i></strong>
          </p>
        </div>
        
        <div class="col-md-1" align="center"></div>
      </div>
      <div class="panel-body">
        <div class="row">

          <div class="col-md-1" align="center"></div>
          <div class="col-md-10" align="center">


            <table id="example1">
              <thead>           

                <th ><b>ID</b><br></th>
                <th ><b>Tabla_Registro</b><br></th>
                <th ><b>Usuario</b></th>
                <th ><b>Fecha</b></th>
                <th ><b>Acci&oacuten</b></th>
                
              </thead>
              <tbody>

                <?php 
                foreach ($tla_auditoria_registro as $datos){
                  ?>
                  <tr>

                    <td ><?php echo $datos->id?></td>
                    <td ><?php echo $datos->tabla_id?></td>
                    <td ><?php echo $datos->nombres; ?> <?php echo " " ?> <?php echo $datos->paterno; ?></td>
                    <td ><?php echo $datos->fecha?></td>                    
                     <td> <?php
		                if($datos->accion== '1') {echo 'Ingreso';} 
                        elseif($datos->accion == '2') {	echo 'Actualización';} 
                        else { echo 'Eliminación'; }                  
                                      
                    ?></td>                   
                    
                    
                  </tr>
                  <?php
                }  
                ?>

              </tbody>
            </table>
          </div>
        </div>
        
      </div>
    </div>
  </form>
  
        




    
     
  

