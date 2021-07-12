<body>
  <form action="<?php echo base_url('/transportes/informes/resumen_preventa_rechazo') ?>" role="form" id="form" method='post' autocomplete="off">
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-10">
          <div class="col-md-2" align="center">
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <p align="left"><b><font style="font-size: 15px;" color="#006B12">Seleccione Mes:</font></b></p>         
          </div>
          <div class="col-md-2">
            <br>&nbsp;&nbsp;&nbsp;&nbsp;
            <input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker" type="text" id="datepicker" class="datepicker" value="<?php echo $fecha; ?>" size="10" readonly="true" title="Fecha a Gestionar Merma"/>
          </div>
          <!-- <a  style="margin-left: 20px;" data-toggle="modal" href="<?php echo base_url()?>transportes/informes/rechazos_2017">Actualizar ingreso produccion</a> -->
        </div>
        <div class="col-md-1" align="center"></div>
      </div>
      <div class="panel-body">
          <?php  echo $exito; ?>        
       <div class="col-md-1"></div>
       <div class="col-md-10">
        <table class="table" id="encCol" align="center">
          <thead>              
            <tr>                
            <th><b>Año-Mes-Día</b></th>
              <th><b>Preventas</b></th>
              <th><b>Rechazos</b></th>
            </tr>
          </thead>
          <tbody>                       
            <?php
               if ($lista_aux != FALSE){
                    foreach ($lista_aux as $row){ 
                        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
                        $diasemana = $dias[date('N', strtotime($row->fechas))];
            ?>
                <tr>
                  <td><?php echo $row->fechas; echo " ".$diasemana; ?></td>

                  <td>
                        <?php 
                           switch ($row->preventa) {
                           case '1':
                        ?>
                          <i title="Preventa Ingresado" class="fa fa-thumbs-up" style="color: green;"></i>
                        <?php 
                           break;
                           case '0':
                        ?>
                            <?php if ($diasemana == "DomingoS") {
                            ?>
                               <i title="Descanso" class="fa fa-lock" style="color: black;"></i>
                           <?php 
                             }else{ 
                           ?>
                              <a data-toggle="modal" href="<?php echo base_url()?>transportes/informes/subir_preventa_modal/<?php echo $row->fechas?>" data-target="#modal_preventa"><i title="Ingrese Preventa" class="fa fa-thumbs-down" style="color: red;"></i></a>
                        <?php }
                           break;
                           default:
                           break;
                         }
                        ?> 
                  </td>
                   <td>
                        <?php 
                            switch ($row->rechazos) {
                            case '1':
                        ?>
                             <i title="Rechazo Ingresado" class="fa fa-thumbs-up" style="color: green;"></i>
                        <?php
                            break;
                            case '0':
                        ?>
                                   <?php if ($diasemana == "DomingoS") {
                            ?>
                               <i title="Descanso" class="fa fa-lock" style="color: black;"></i>
                           <?php 
                             }else{ 
                           ?>
                                <a data-toggle="modal" href="<?php echo base_url()?>transportes/informes/subir_rechazo_modal/<?php echo $row->fechas?>" data-target="#modal_rechazo"><i title="Ingrese Rechazo" class="fa fa-thumbs-down" style="color: red;"></i></a>
                        <?php }
                            break;
                            default:       
                            break;
                        }
                        ?>
                  </td>
                </tr>                  

                  <?php
                }
              }else{
                ?>
                    <td colspan="16" style="text-align:center"><p style="color:#088A08; font-weight: bold;">NO EXISTEN REGISTROS EN LA BASE DE DATOS</p></td>
              <?php
                }
              ?>         
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-md-8"></div>
          <div class="col-md-4">
            <button class="btn btn-yellow btn-block" type="submit" name="enviar" value="enviar" title="Guardar y/o Actualizar estado Activo/Inactivo del Trabajador">
              Cerrar Mes
            </button>
          </div>
        </div>
        <br>
      </div>
    </div>
  </form>
</body>
<!--Modal sube preventa-->
<div class="modal fade" id="modal_preventa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!--Modal sube rechazo-->
<div class="modal fade" id="modal_rechazo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body"></div>
    </div>
  </div>
</div>
