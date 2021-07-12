<body>  

  <div class="panel panel-white"><br>
    <div class="row">
      <div class="col-md-10">
        <!-- Text input-->
        <div class="col-md-5">
          <div class="form-group">
            <label class="col-md-3 control-label" for="textinput">Fecha Actual</label>  
            <div class="col-md-2">
            <input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker" type="text" id="datepicker" class="datepicker" value="<?php echo $fecha_mostrar; ?>" size="10" readonly="true" title="Fecha" disabled/> 
            </div>
          </div>
        </div>
      </div><br>
      <div class="col-md-2" align="right">
      
      <form action="<?php echo base_url() ?>transportes/datos/exportacion/" method="post" target="_blank" id="FormularioExportacion">
        <a href="#"  class="botonExcel">Exportar <img style="width: 30px;" src="<?php echo base_url() ?>extras/img/excel.png"  class="botonExcel" > </a>
        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
      </form>
      
      </div>
    
      <div class="col-md-10">
        <div class="col-md-10">
         <div class="form-group">
          <label class="col-md-2 control-label" for="textinput">Vueltas</label>
          <div class="col-md-2">
            <input type="radio" class="vuelta1" name="planta" id="planta" onclick="javacript: document.getElementById('vuelta_trabajar').value = '1' " <?php if($vuelta_trabajar == 1) echo "checked" ?> > 1
          </div>
          <div class="col-md-2">
            <input type="radio" class="vuelta2" name="planta" id="planta" onclick="javacript: document.getElementById('vuelta_trabajar').value = '2' " <?php if($vuelta_trabajar == 2) echo "checked" ?> > 2
          </div>
          <div class="col-md-2">
            <input type="radio" class="vuelta3" name="planta" id="planta" onclick="javacript: document.getElementById('vuelta_trabajar').value = '3' " <?php if($vuelta_trabajar == 3) echo "checked" ?> > 3
          </div>
          <div class="col-md-2">
            <input type="radio" class="vuelta4" name="planta" id="planta" onclick="javacript: document.getElementById('vuelta_trabajar').value = '4' " <?php if($vuelta_trabajar == 4) echo "checked" ?> > 4
          </div>
          <div class="col-md-2">
            <input type="radio" class="vuelta5" name="planta" id="planta" onclick="javacript: document.getElementById('vuelta_trabajar').value = '5' " <?php if($vuelta_trabajar == 5) echo "checked" ?> > 5
          </div>
          <input type="hidden" name="fecha_mostrar" id="fecha_mostrar" value="<?php echo $fecha_mostrar ?>">
          <input type="hidden" name="vuelta_trabajar" id="vuelta_trabajar" value="<?php echo $vuelta_trabajar ?>">          
        </div>
      </div>
    </div>
    </div>
   
    <div class="panel-body">
      <div class="row">
        <div class="col-md-12" align="center">
          <form action="<?php echo base_url()?>transportes/datos/guardar_produccion" role="form" id="form1" method="post" autocomplete="off">
            <table id="example3">
              <thead>    
                <th class="center"><b>Codigo CCU</b></th>
                <th class="center"><b>Nombre Chofer</b></th>
                <th class="center"><b>Ayudante 1</b></th>
                <th class="center"><b>Ayudante 2</b></th>
                <th class="center"><b>Ayudante 3</b></th>
                <th class="center"><b>Ayudante Día</b></th>
                <th class="center"><b>Ruta</b></th>
                <th class="center"><b>Cajas Reales</b></th>
                <th class="center"><b>Clientes Reales</b></th>
                <th class="center"><b>Informacion Cajas</b></th>
                <th class="center"><b>Informacion clientes</b></th>
              </thead>
              <tbody>
                <?php
                  $i=1;
                  foreach ($lista_aux as $row) { 
                  
                 
                ?>
                <tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#FFFFFF';">
                    <td style="width:50px;"><strong><?php echo $row->codigo2?></strong></td><!--Codigo CCU-->
                    <input type="hidden" name="codigo_camion[<?php echo $i ?>]" id="codigo_camion" value="<?php echo $row->codigo?>" />
                    <input type="hidden" name="fecha_mostrar" id="fecha_mostrar" value="<?php echo $fecha_mostrar ?>"/>
                    <input type="hidden" name="vuelta_trabajar" id="vuelta_trabajar" value="<?php echo $vuelta_trabajar ?>"/>

                    <td><!--            Nombre Chofer               -->
                      <?php 
                      if ($row->chofer1_nombre == "N/D") { ?>
                       <a data-toggle="modal" href="<?php echo base_url()?>transportes/datos/modal_agregar_trabajador/<?php echo $fecha_mostrar ?>/<?php echo $vuelta_trabajar ?>/<?php echo $row->codigo?>" data-target="#modal_add_chofer">
                         <?php echo strtoupper($row->chofer1_nombre)?></a><br>
                         <?php
                       }else{ ?>
                        <a data-toggle="modal" href="<?php echo base_url()?>transportes/datos/modal_agregar_trabajador/<?php echo $fecha_mostrar ?>/<?php echo $vuelta_trabajar ?>/<?php echo $row->codigo?>" data-target="#modal_add_chofer" ><?php echo strtoupper($row->chofer1_ap." ".$row->chofer1_am." ".$row->chofer1_nombre)?></a>
                      <!--  <a class='eliminar' href="<?php //echo base_url() ?>transportes/datos/eliminar_trabajador_produccion_ch/<?php //echo $fecha_mostrar; ?>/<?php// echo $vuelta_trabajar ?>/<?php //echo $row->codigo?>/<?php// echo $row->chofer1_id; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>-->
                        <?php }
                        ?>
                      </td>

                      <td><!--          Ayudante 1             -->
                        <?php 
                          if ($row->peoneta1_nombre == "N/D") { 
                        ?>
                          <a data-toggle="modal" href="<?php echo base_url()?>transportes/datos/modal_agregar_trabajador_peoneta_1/<?php echo $fecha_mostrar ?>/<?php echo $vuelta_trabajar ?>/<?php echo $row->codigo?>" data-target="#modal_add_p_1">
                            <?php echo strtoupper($row->peoneta1_nombre)?></a>
                            <?php }else{ ?>
                            <a data-toggle="modal" href="<?php echo base_url()?>transportes/datos/modal_agregar_trabajador_peoneta_1/<?php echo $fecha_mostrar ?>/<?php echo $vuelta_trabajar ?>/<?php echo $row->codigo?>" data-target="#modal_add_p_1"><?php echo strtoupper($row->peoneta1_ap." ".$row->peoneta1_am." ".$row->peoneta1_nombre)?></a>
                            <a class='eliminar' href="<?php echo base_url() ?>transportes/datos/eliminar_trabajador_produccion_p1/<?php echo $fecha_mostrar; ?>/<?php echo $vuelta_trabajar ?>/<?php echo $row->codigo?>/<?php echo $row->peoneta1_id; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                            <?php }
                            ?>
                      </td>  

                      <td><!--           Ayudante 2               -->
                          <?php 
                              if($row->peoneta2_nombre == "N/D"){ 
                          ?>
                          <a data-toggle="modal" href="<?php echo base_url()?>transportes/datos/modal_agregar_trabajador_peoneta_2/<?php echo $fecha_mostrar ?>/<?php echo $vuelta_trabajar ?>/<?php echo $row->codigo?>" data-target="#modal_add_p_2"><?php echo strtoupper($row->peoneta2_nombre)?></a><br>
                          <?php
                        }else{ ?>
                          <a data-toggle="modal" href="<?php echo base_url()?>transportes/datos/modal_agregar_trabajador_peoneta_2/<?php echo $fecha_mostrar ?>/<?php echo $vuelta_trabajar ?>/<?php echo $row->codigo?>" data-target="#modal_add_p_2">
                            <?php echo strtoupper($row->peoneta2_ap." ".$row->peoneta2_am." ".$row->peoneta2_nombre)?></a>
                            <a class='eliminar' href="<?php echo base_url() ?>transportes/datos/eliminar_trabajador_produccion_p2/<?php echo $fecha_mostrar; ?>/<?php echo $vuelta_trabajar?>/<?php echo $row->codigo?>/<?php echo $row->peoneta2_id; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                            <?php }
                            ?>
                      </td>

                      <td><!--          Ayudante 3                -->
                          <?php  
                              if ($row->peoneta3_nombre == "N/D") { 
                          ?>
                          <a data-toggle="modal" href="<?php echo base_url()?>transportes/datos/modal_agregar_trabajador_peoneta_3/<?php echo $fecha_mostrar ?>/<?php echo $vuelta_trabajar ?>/<?php echo $row->codigo?>" data-target="#modal_add_p_3"><?php echo strtoupper($row->peoneta3_nombre)?></a>
                          <?php 
                            }else{ 
                          ?>
                            <a data-toggle="modal" href="<?php echo base_url()?>transportes/datos/modal_agregar_trabajador_peoneta_3/<?php echo $fecha_mostrar ?>/<?php echo $vuelta_trabajar ?>/<?php echo $row->codigo?>" data-target="#modal_add_p_3"><?php echo strtoupper($row->peoneta3_ap." ".$row->peoneta3_am." ".$row->peoneta3_nombre)?></a>
                            <a class='eliminar' href="<?php echo base_url() ?>transportes/datos/eliminar_trabajador_produccion_p3/<?php echo $fecha_mostrar; ?>/<?php echo $vuelta_trabajar ?>/<?php echo $row->codigo?>/<?php echo $row->peoneta3_id; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                            <?php }
                            ?>
                      </td>

                      <td><!--          Ayudante Dia             -->
                         <?php 
                             if ($row->peoneta4_nombre == "N/D") { 
                          ?>
                            <a data-toggle="modal" href="<?php echo base_url()?>transportes/datos/modal_agregar_trabajador_peoneta_4/<?php echo $fecha_mostrar ?>/<?php echo $vuelta_trabajar ?>/<?php echo $row->codigo?>" data-target="#modal_add_p_4" class="btn"><?php echo strtoupper($row->peoneta4_nombre)?></a>    
                            <?php 
                              }else{ 
                            ?>
                              <a data-toggle="modal" href="<?php echo base_url()?>transportes/datos/modal_agregar_trabajador_peoneta_4/<?php echo $fecha_mostrar ?>/<?php echo $vuelta_trabajar ?>/<?php echo $row->codigo?>" data-target="#modal_add_p_4" class="btn"><?php echo strtoupper($row->peoneta4_ap." ".$row->peoneta4_am." ".$row->peoneta4_nombre)?></a>
                              <a class='eliminar' href="<?php echo base_url() ?>transportes/datos/eliminar_trabajador_produccion_p4/<?php echo $fecha_mostrar; ?>/<?php echo $vuelta_trabajar ?>/<?php echo $row->codigo?>/<?php echo $row->peoneta4_id; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                              <?php } 
                              ?>
                     </td>               

                      <td><!--        Ruta            -->
                                 <?php if ($row->ruta_id == "") { ?>
                                  <div class="controls">
                                    <select name="id_select_ruta[<?php echo $i; ?>]" id="id_select_ruta" style="width: 90px;" >
                                      <option value="">Sel. Ruta</option>
                                      <?php foreach ($listarutas as $r) {
                                        echo '<option value="',$r->id,'">',$r->nombre_rutas,'</option>';
                                      } ?>
                                    </select>
                                  </div>
                                  <?php }else{?>
                                    <div class="controls">
                                     <?php if ($row->estado_cierre == 1) { ?>
                                     <select name="id_select_ruta[<?php echo $i; ?>]" id="id_select_ruta" style="width: 90px;" disabled>
                                      <option value="<?php echo $row->ruta_id; ?>"><?php echo $row->nombre_ruta; ?></option>
                                      <?php foreach ($listarutas as $r) {
                                        echo '<option value="',$r->id,'">',$r->nombre_rutas,'</option>';
                                      } ?>
                                    </select>  
                                     <?php } else { ?>
                                        <select name="id_select_ruta[<?php echo $i; ?>]" id="id_select_ruta" style="width: 90px;" >
                                        <option value="<?php echo $row->ruta_id; ?>"><?php echo $row->nombre_ruta; ?></option>
                                        <?php foreach ($listarutas as $r) {
                                          echo '<option value="',$r->id,'">',$r->nombre_rutas,'</option>';
                                        } ?>
                                      </select>
                                     <?php } ?>
                                      
                                    </div>
                                    <?php }?>                                                  
                      </td> 

                      <td> <!--           Cajas Realess             -->
                          <div class="form-group">
                            <div class="col-md-2">
                              <?php if ($row->estado_cierre == 1) { ?>
                              <input style="width: 90px;" id="cajas_reales[<?php echo $i ?>]" name="cajas_reales[<?php echo $i ?>]" type="text" value="<?php echo $row->caja_reales; ?>" class="form-control input-md"
                              maxlength="4" onkeypress='validate(event)' disabled />
                              <?php }else{ ?>
                              <?php if ($usuario_subtipo == 111 or $usuario_subtipo == 108) {?>
                              <input style="width: 90px;" id="cajas_reales[<?php echo $i ?>]" name="cajas_reales[<?php echo $i ?>]" type="text" value="<?php echo $row->caja_reales; ?>" class="form-control input-md"
                              maxlength="4" onkeypress='validate(event)' disabled />
                              <?php }else { ?>
                              <input style="width: 90px;" id="cajas_reales[<?php echo $i ?>]" name="cajas_reales[<?php echo $i ?>]" type="text" value="<?php echo $row->caja_reales; ?>" class="form-control input-md"
                              maxlength="4" onkeypress='validate(event)' />

                              <?php  } ?>
                              <?php } ?> 
                            </div>
                          </div>
                     </td>
                     <td><!--         Clientes Reales              -->
                          <div class="form-group">
                            <div class="col-md-2">
                            <?php if ($row->estado_cierre == 1) { ?>
                              <input style="width: 90px;" id="clientes_reales[<?php echo $i ?>]" name="clientes_reales[<?php echo $i ?>]" type="text" value="<?php echo $row->cliente_reales; ?>" class="form-control input-md" maxlength="4" onkeypress='validate(event)' disabled/>
                             <?php }else{ ?>
                              <?php if ($usuario_subtipo == 111 or $usuario_subtipo == 108) {?>
                                  <input style="width: 90px;" id="clientes_reales[<?php echo $i ?>]" name="clientes_reales[<?php echo $i ?>]" type="text" value="<?php echo $row->cliente_reales; ?>" class="form-control input-md" maxlength="4" onkeypress='validate(event)' disabled/>
                              <?php }else { ?>                
                                  <input style="width: 90px;" id="clientes_reales[<?php echo $i ?>]" name="clientes_reales[<?php echo $i ?>]" type="text" value="<?php echo $row->cliente_reales; ?>" class="form-control input-md" maxlength="4" onkeypress='validate(event)'/>
                              <?php  } ?>
                            <?php } ?>  
                            </div>
                          </div>
                    </td>

                    <td><!-- cajas ingresadas menos las cajas rechazo -->
                          <div class="form-group">
                            <div>
                            <?php if ($row->caja_original==0) {
                              echo "";
                            }else{ ?>
                            <label title="Cajas Ingresadas: <?php echo $row->caja_original?> - Cajas Rechazo: <?php echo $row->caja_rechazo?>" 
                              > <span class="badge" style="background-color:green"><?php echo $row->caja_original." - ".$row->caja_rechazo; ?></span> </label>
                        
                            <?php }?>
                            </div>
                          </div>
                    </td>

                   

                     <td>     <!--      Clientes ingresados menos los clientes  rechazo -->
                           <div class="form-group">
                                  <div>
                                  <?php if ($row->cliente_original==0) {
                                    echo "";
                                  }else{ ?>
                                  <label title="Clientes Ingresados: <?php echo $row->cliente_original?> - Clientes Rechazados: <?php echo $row->cliente_rechazo ?>">
                                  <span class="badge" style="background-color: #58ACFA "><?php echo $row->cliente_original." - ".$row->cliente_rechazo; ?></span>
                                 </label>
                                  <?php }?>
                                  </div>
                           </div>
                     </td>
               </tr>

                            <?php
                            $i++;   
                          }
                          ?>

                        </tbody>
                    </table>
                    <div class="row">
                      <div class="col-md-8"></div>
                      <div class="col-md-4">
                        <button class="btn btn-success btn-block" type="submit" name="guardar" title="GUARDAR PRODUCCIÓN TRABAJADORES">
                          Guardar Producción Vuelta <span class="badge"><?php echo $vuelta_trabajar; ?></span>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                </div>
              </div>
               </div>
               </form>
              <div class="leyenda">
                + Agregar Nuevo Registro - Eliminar Registro.
              </div>
      </body>

                          
                          <!-- Modal Agregar chofer-->
                          <div class="modal fade" id="modal_add_chofer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Listado de Choferes</h4>
                                </div>
                                <div class="modal-body">

                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- Modal Agregar peoneta 1-->
                          <div class="modal fade" id="modal_add_p_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Agregar Ayudante 1</h4>
                                </div>
                                <div class="modal-body">

                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- Modal Agregar peoneta 2-->
                          <div class="modal fade" id="modal_add_p_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Agregar Ayudante 2</h4>
                                </div>
                                <div class="modal-body">

                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- Modal Agregar peoneta 3-->
                          <div class="modal fade" id="modal_add_p_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Agregar Ayudante 3</h4>
                                </div>
                                <div class="modal-body">

                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- Modal Agregar peoneta 4-->
                          <div class="modal fade" id="modal_add_p_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Agregar Ayudante 4</h4>
                                </div>
                                <div class="modal-body">

                                </div>
                              </div>
                            </div>
                          </div>
                          <script type="text/javascript">
                            function validate(evt) {
                              var theEvent = evt || window.event;
                              var key = theEvent.keyCode || theEvent.which;
                              key = String.fromCharCode( key );
                              var regex = /[0-9]/;
                              if( !regex.test(key) ) {
                                theEvent.returnValue = false;
                                if(theEvent.preventDefault) theEvent.preventDefault();
                              }
                            }
                          </script>

     <div class="panel-body" hidden>
     <script language="javascript"> // Script para exportar a excel
            $(document).ready(function() {
              $(".botonExcel").click(function(event) {
                $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
                $("#FormularioExportacion").submit();
            });
            });
      </script>

      <div class="row">
            <table id="Exportar_a_Excel"  >
              <thead>    
                <th style="border: 1px solid black;"><b>Codigo CCU</b></th>
                <th style="border: 1px solid black;"><b>Nombre Chofer</b></th>
                <th style="border: 1px solid black;"><b>Ayudante 1</b></th>
                <th style="border: 1px solid black;"><b>Ayudante 2</b></th>
                <th style="border: 1px solid black;"><b>Ayudante 3</b></th>
                <th style="border: 1px solid black;"><b>Ayudante Dia</b></th>
                <th style="border: 1px solid black;"><b>Ruta</b></th>
                <th style="border: 1px solid black;"><b>Cajas Reales</b></th>
                <th style="border: 1px solid black;"><b>Clientes Reales</b></th>
                <th style="border: 1px solid black;"><b>Cajas Ingresadas</b></th>
                <th style="border: 1px solid black;"><b>Cajas Rechazo</b></th>
                <th style="border: 1px solid black;"><b>Clientes Ingresado</b></th>
                <th style="border: 1px solid black;"><b>Clientes Rechazo</b></th>
              </thead>
              <tbody>
                <?php
                  $i=1;
                 sort($lista_aux); // ordena de menor a mayor 
                  foreach ($lista_aux as $row) { 
                ?>
                <tr style="border-top: 1px solid #A4A4A4;">
                      <td style="width:50px;"><strong><?php echo $row->codigo2?></strong></td><!--Codigo CCU-->

                      <td style="border-collapse: background: red" ><!--            Nombre Chofer               -->
                              <?php 
                              if ($row->chofer1_nombre == "N/D") {
                                 echo "";
                                }else{
                                 echo strtoupper($row->chofer1_ap." ".$row->chofer1_am." ".$row->chofer1_nombre); }?>
                      </td>

                      <td><!--          Ayudante 1             -->
                        <?php 
                            if ($row->peoneta1_nombre == "N/D") {
                               echo "";
                              }else{ 
                          echo strtoupper($row->peoneta1_ap." ".$row->peoneta1_am." ".$row->peoneta1_nombre);
                           }
                          ?>
                      </td>  

                      <td><!--           Ayudante 2               -->
                            <?php 
                            if ($row->peoneta2_nombre == "N/D") {
                               echo "";
                              }else{ 
                           echo strtoupper($row->peoneta2_ap." ".$row->peoneta2_am." ".$row->peoneta2_nombre);
                         }
                           ?>
                      </td>

                      <td><!--          Ayudante 3                -->
                          <?php 
                            if ($row->peoneta3_nombre == "N/D") {
                               echo "";
                              }else{ 
                               echo strtoupper($row->peoneta3_ap." ".$row->peoneta3_am." ".$row->peoneta3_nombre);
                              } 
                          ?>
                      </td>

                      <td><!--          Ayudante Dia             -->
                            <?php 
                            if ($row->peoneta4_nombre == "N/D") {
                               echo "";
                              }else{ 
                          echo strtoupper($row->peoneta4_nombre);
                          }
                          ?>
                     </td>               

                      <td><!--        Ruta            -->
                            <?php 
                            if ($row->nombre_ruta == "N/D") {
                               echo " ";
                              }else{ 
                           echo $row->nombre_ruta; }?>                                              
                      </td> 

                      <td align="center"> <!-- Cajas Reales -->
                            <?php 
                              if ($row->caja_reales == 0) {
                                 echo "";
                                }else{ 
                            echo $row->caja_reales; }?>
                     </td>

                     <td align="center" id="linea2"><!-- Clientes Reales -->
                            <?php 
                              if ($row->cliente_reales == 0) {
                                 echo "";
                                }else{
                         echo $row->cliente_reales; }?>
                     </td>

                     <td align="center" style="background-color: #81F781"><!-- cajas ingresadas por teclado -->
                            <?php 
                              if ($row->caja_original == 0) {
                                 echo "";
                                }else{
                            echo $row->caja_original; }?> 
                     </td>
 
                     <td align="center" style="background-color: #81F781 "><!-- cajas rechazo -->
                            <?php 
                              if ($row->caja_original == 0) {
                                 echo "";
                                }else{
                             echo $row->caja_rechazo; }?>
                     </td>

                     <td align="center" style="background-color: #A9F5F2 " >     <!-- Clientes ingresados por teclado-->
                            <?php 
                              if ($row->cliente_original == 0) {
                                 echo "";
                                }else{
                            echo $row->cliente_original; }?> 
                     </td>

                     <td align="center" style="background-color: #A9F5F2"> <!-- Clientes rechazo -->
                            <?php 
                              if ($row->cliente_original == 0) {
                                 echo "";
                                }else{
                            echo $row->cliente_rechazo; }?>
                     </td>
               </tr>
                            <?php
                            $i++;   
                          }
                          ?>

                        </tbody>
                    </table>
                
             
              </div>