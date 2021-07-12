<body>
 <?php //var_dump($lista_aux);?>
  <form action="" role="form" id="form" method='post' autocomplete="off">
    <div class="panel panel-white"><br>
    <div class="col-md-10">
      <!-- Text input-->
      <div class="col-md-5">
        <div class="form-group">
          <label class="col-md-3 control-label" for="textinput">Fecha Seleccionada</label>  
          <div class="col-md-2">
            <input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker" type="text" id="datepicker" class="datepicker" value="<?php echo $fecha; ?>" size="10" readonly="true" title="Fecha"/> 
          </div>
        </div>
      </div>
    </div>
      <div class="row">
        <div class="col-md-9">
          <p align="left">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <strong style="color: green"><i>P = Produccion</i></strong> 
           <strong style="color: red"><i>R = Rechazadas</i></strong> 
          </p>
        </div>
        <div class="col-md-3" align="right">          
        </div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12" align="center">
            <table class="datatable table table-hover table-bordered">
              <thead>
                <th style="width: 2%" ><b>CCU</b></th> 
                <th style="width: 1%; color: green;" ><b>P1</b></th> 
                <th  style="width: 1%; color: red" ><b>R1</b></th> 
                <th  style="width: 1%; color: green;"><b>P2</b></th>
                <th  style="width: 1%; color: red" ><b>R2</b></th>
                <th  style="width: 1%; color: green;" ><b>P3</b></th>
                <th  style="width: 1%; color: red" ><b>R3</b></th>
                <th  style="width: 1%; color: green;" ><b>P4</b></th>
                <th  style="width: 1%; color: red" ><b>R4</b></th>
                <th  style="width: 1%; color: green;" ><b>P5</b></th> 
                <th  style="width: 1%; color: red" ><b>R5</b></th> 
                <th style="width: 17%" ><b>Chofer</b></th> 
                <th style="width: 16%" ><b>Ayudante1</b></th> 
                <th style="width: 15%" ><b>Ayudante2</b></th> 
                <th style="width: 15%" ><b>Ayudante3</b></th> 
                <th style="width: 15%"><b>Ayudante4</b></th> 
                <th style="width: 10%"><b>Fecha</b></th> 
              </thead>  
              <tbody>
              <?php  $comparar = "N988";
                if ($lista_aux != false) {
                  foreach ($lista_aux as $row) {//Inicio Foreach
              ?>
                    <?php
                        foreach ($row->adiario as $key) {
                           if ($comparar != $key->codigo2) { //Inicio If                       
                          
                       
                     ?>
                  <tr>
                    <td><?php  echo $key->codigo2; ?></td>
                    <td><?php  echo isset($key->caja1)?$key->caja1:"0";?></td> 
                    <td><?php  echo isset($key->vuelta1)?$key->vuelta1:"0";?></td>   
                    <td><?php  echo isset($key->caja2)?$key->caja2:"0";?></td>   
                    <td><?php  echo isset($key->vuelta2)?$key->vuelta2:"0"; ?></td>
                    <td><?php  echo isset($key->caja3)?$key->caja3:"0";?></td>   
                    <td><?php  echo isset($key->vuelta3)?$key->vuelta3:"0"; ?></td>
                    <td><?php  echo isset($key->caja4)?$key->caja4:"0";?></td> 
                    <td><?php  echo isset($key->vuelta4)?$key->vuelta4:"0"; ?></td>
                    <td><?php  echo isset($key->caja5)?$key->caja5:"0";?></td>   
                    <td><?php  echo isset($key->vuelta5)?$key->vuelta5:"0"; ?></td>
                    <td><?php  echo isset($key->chofer)?$key->chofer:"N/N"; ?></td>
                    <td><?php  echo isset($key->ayudante1)?$key->ayudante1:"N/N"; ?></td>
                    <td><?php  echo isset($key->ayudante2)?$key->ayudante2:"N/N"; ?></td>
                    <td><?php  echo isset($key->ayudante3)?$key->ayudante3:"N/N"; ?></td>
                    <td><?php  echo isset($key->ayudante4)?$key->ayudante4:"N/N"; ?></td>
                    <td><?php  echo isset($row->fechas)?$row->fechas:"N/N"; ?></td>
                  </tr>

              <?php 
                     $comparar = $key->codigo2;  
                      }  
                    } // Fin If
                  } // Fin Foreach
                }
              ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </form>
</body>
