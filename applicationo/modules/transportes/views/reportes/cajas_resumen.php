<body>
	<form action="<?php echo base_url()?>transportes/reportes/reporte_por_trabajador" role="form" id="form1" method="post" autocomplete="off">	
		<div class="panel panel-white">
			<div class="row">
			</div><br>
			<div class="row">
				<div class="col-md-8"></div>
				<div class="col-md-2">
					<?php if ($usuario_subtipo != 109) { ?>
						<button id="myButtonControlID" class="btn btn-green">Exportar a Excel</button>	
					<?php } ?>
						
				</div>
			</div><br>

			<div class="panel panel-body">
			<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8">
						<table class="table table-bordered">
							<thead>
								<th>Rut</th>								
								<th>Nombres</th>
								<th>Cajas</th>
								<th>Clientes</th>
								<th>Vueltas</th>
								<th>Fallas</th>								
							</thead>
							<tbody>
								<?php foreach ($listar_reporte as $row) {?>
									<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#FFFFFF';">	
										<td><?php echo $row->rut; ?></td>
										<td><?php echo $row->ap." ". $row->am." ".$row->nombre; ?></td>	
										<td><?php echo $row->caja; ?></td>										
										<td><?php echo $row->clientes; ?></td>

										<td><?php echo $row->vueltas; ?></td>
										
										<td><?php echo $row->falla; ?></td>
										
									</tr>
								<?php } ?>
									
							</tbody>
						</table>
					</div>
					<div class="col-md-2"></div>				
			</div>
		</div>
</body>

<div id="divTableDataHolder" style="display:none">
	<meta content="charset=UTF-8"/>
	<table class="table table-bordered">
		<thead>
			<th>Rut</th>								
			<th>Nombres</th>
			<th>Contrato</th>
			<th>Cargo</th>
			<th>Cajas</th>
			<th>Clientes</th>
			<th>Vueltas</th>
			<th>Fallas</th>
		</thead>
		<tbody>
			<?php foreach ($listar_reporte as $row) {?>
			<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#FFFFFF';">	
				<td><?php echo $row->rut; ?></td>
				<td><?php echo $row->ap." ". $row->am." ".$row->nombre; ?></td>
				<?php switch ($row->colectivo) { 
					case '21':?>
						<td>Sindicato</td>
					<?php break;
					case '22': ?>
						<td>Convenio</td>
					<?php	break;
					case '23': ?>
						<td>No Tiene</td>
					<?php	break;
					
					default:
						# code...
						break;
				} ?>
				<?php switch ($row->cargo) { 
					case '72':?>
						<td>Chofer</td>
					<?php break;
					case '73': ?>
						<td>Ayudante</td>
					<?php 	break;
					default:
						# code...
						break;
				} ?>
				<td><?php echo $row->caja; ?></td>
				<td><?php echo $row->clientes; ?></td>										
				<td><?php echo $row->vueltas; ?></td>
				<td><?php echo $row->falla; ?></td>
				
			</tr>
			<?php } ?>

		</tbody>
	</table>
</div>