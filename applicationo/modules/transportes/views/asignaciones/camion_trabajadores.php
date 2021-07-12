<body>
  <form action="" role="form" id="form" method='post' autocomplete="off">
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-9">
          <p align="left">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            En esta secci&oacute;n usted podra:<strong><i>asignar trabajadores a un camión</i></strong>
          </p>
        </div>
        <div class="col-md-1" align="center"></div>
      </div>
      <div class="panel-body">
        <div class="row">
        </div>
        <div class="table-responsive">
          <table id="example1">
            <thead>
              <th><b>Codigo Camión</b></th>
              <th><b>Conductor</b></th>
              <th><b>Ayudante 1</b></th>
              <th><b>Ayudante 2</b></th>
              <th><b>Ayudante 3</b></th>
              <th><b>Ayudante 4</b></th>      
            </thead>
            <tbody>
              <?php if ($lista_aux != FALSE) {
                $i=1;
                foreach ($lista_aux as $row) { ?>
                <tr>
                  <td><strong><?php echo $row->codigo2?></strong></span></td>
                  
                  <td class="center">
                    <div class="col-md-8"><?php echo strtoupper($row->chofer1_nombre." ".$row->chofer1_ap." ".$row->chofer1_am)?></div><div class="col-md-2"><a data-toggle="modal" href="<?php echo base_url()?>transportes/asignacion/modal_agregar_trabajador/<?php echo $row->codigo?>" data-target="#modal_add_chofer" class="btn btn-default btn-circle"><i class="fa fa-user"></i></a></div></td>
                    <td><div class="col-md-8"><?php echo strtoupper($row->peoneta1_nombre." ".$row->peoneta1_ap." ".$row->peoneta1_am)?></div><div class="col-md-4"><a data-toggle="modal" href="<?php echo base_url()?>transportes/asignacion/modal_agregar_trabajador_peoneta_1/<?php echo $row->codigo?>" data-target="#modal_add_p_1" class="btn btn-default btn-circle"><i class="fa fa-user"></i></a></div></td>
                    <td><div class="col-md-8"><?php echo strtoupper($row->peoneta2_nombre." ".$row->peoneta2_ap." ".$row->peoneta2_am)?></div><div class="col-md-4"><a data-toggle="modal" href="<?php echo base_url()?>transportes/asignacion/modal_agregar_trabajador_peoneta_2/<?php echo $row->codigo?>" data-target="#modal_add_p_2" class="btn btn-default btn-circle"><i class="fa fa-user"></i></a></div></td>
                    <td><div class="col-md-8"><?php echo strtoupper($row->peoneta3_nombre." ".$row->peoneta3_ap." ".$row->peoneta3_am)?></div><div class="col-md-4"><a data-toggle="modal" href="<?php echo base_url()?>transportes/asignacion/modal_agregar_trabajador_peoneta_3/<?php echo $row->codigo?>" data-target="#modal_add_p_3" class="btn btn-default btn-circle"><i class="fa fa-user"></i></a></div></td>
                    <td><div class="col-md-8"><?php echo strtoupper($row->peoneta4_nombre." ".$row->peoneta4_ap." ".$row->peoneta4_am)?></div><div class="col-md-4"><a data-toggle="modal" href="<?php echo base_url()?>transportes/asignacion/modal_agregar_trabajador_peoneta_4/<?php echo $row->codigo?>" data-target="#modal_add_p_4" class="btn btn-default btn-circle"><i class="fa fa-user"></i></a></div></td>
                    
                  </tr>

                  <?php
                  $i++;   
                }?>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </form>
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
