<body>
  <form action="<?php echo base_url() ?>transportes/auditoria/menu" role="form" id="form" method='post' autocomplete="off">
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-10">
          <p >
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            En esta secci&oacute;n usted podra:<strong><i>Auditoria de movimientos en TLA</i></strong>
          </p>
        </div>
        
        <div class="col-md-1" ></div>
      </div>
      <div class="panel-body">
        <div class="row">

          <div class="col-md-1" ></div>
          <div class="col-md-10" >


            <table id="example1" style="width:auto">
              <thead>           
                
                <th ><b>Fecha</b></th>
                <th ><b>Descripción</b></th>
                <th ><b>Usuario</b></th>
                
              
                
              </thead>
              <tbody>

                <?php 
                foreach ($tla_auditoria_registro as $datos){
                  ?>
                  <tr>
                    
                  <td ><?php echo $datos->fecha?></td> 
                  <td ><?php echo $datos->nombre?></td>
                  <td ><?php echo $datos->nombres; ?> <?php echo " " ?> <?php echo $datos->paterno; ?></td>
                
                 

                                 
                                                

                    
                     

                    
                  </tr> <?php  } ?>
                

              </tbody>
            </table>
          </div>
        </div>
        
      </div>
    </div>
  </form>
  
        




    
     
  

