<body>
 <?php //var_dump($listado);?>
  <form action="<?php echo base_url() ?>transportes/rep/verificar" role="form" id="form" method='post' autocomplete="off">
    <div class="panel panel-white"><br>
    <div class="col-md-10">
      <!-- Text input-->
      <div class="col-md-5">
        <div class="form-group">
          <label class="col-md-3 control-label" for="textinput">Fecha Actual</label>  
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
           <strong><i>Detalles</i></strong> <!--ir a filtros-->
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
                <th data-placement="top" data-toggle="popover" data-content="Vuelta n° 1" data-trigger="hover" style="width: 1%" ><b>1</b></th> 
                <th data-placement="top" data-toggle="popover" data-content="Vuelta n° 2" data-trigger="hover" style="width: 1%" ><b>2</b></th>
                <th data-placement="top" data-toggle="popover" data-content="Vuelta n° 3" data-trigger="hover" style="width: 1%" ><b>3</b></th>
                <th data-placement="top" data-toggle="popover" data-content="Vuelta n° 4" data-trigger="hover" style="width: 1%" ><b>4</b></th>
                <th data-placement="top" data-toggle="popover" data-content="Vuelta n° 5" data-trigger="hover" style="width: 1%" ><b>5</b></th> 
                <th style="width: 20%" ><b>Chofer</b></th> 
                <th style="width: 19%" ><b>Ayudante1</b></th> 
                <th style="width: 18%" ><b>Ayudante2</b></th> 
                <th style="width: 18%" ><b>Ayudante3</b></th> 
                <th style="width: 18%"><b>Ayudante4</b></th> 
              </thead>  
              <tbody>
              <?php  $comparar = "N988";
                if ($listado != false) {
                  foreach ($listado as $row) {
                    if ($comparar != $row->codigo2) {                        
              ?>
                  <tr>
                    <td><?php  echo $row->codigo2; ?></td>
                    <td><?php  echo isset($row->vuelta1)?$row->vuelta1:"0";?></td>   
                    <td><?php  echo isset($row->vuelta2)?$row->vuelta2:"0"; ?></td>
                    <td><?php  echo isset($row->vuelta3)?$row->vuelta3:"0"; ?></td>
                    <td><?php  echo isset($row->vuelta4)?$row->vuelta4:"0"; ?></td>
                    <td><?php  echo isset($row->vuelta5)?$row->vuelta5:"0"; ?></td>
                    <td><?php  echo isset($row->chofer)?$row->chofer:"N/N"; ?></td>
                    <td><?php  echo isset($row->ayudante1)?$row->ayudante1:"N/N"; ?></td>
                    <td><?php  echo isset($row->ayudante2)?$row->ayudante2:"N/N"; ?></td>
                    <td><?php  echo isset($row->ayudante3)?$row->ayudante3:"N/N"; ?></td>
                    <td><?php  echo isset($row->ayudante4)?$row->ayudante4:"N/N"; ?></td>
                  </tr>
              <?php 
                     $comparar = $row->codigo2;    
                    }
                  }
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
