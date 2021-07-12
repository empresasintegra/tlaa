<div class="span2"></div>
<div class="span11">
<?php
echo @$aviso;
?>
<?php if( count($listado_noticias) > 0 ){ ?>
<table id="inbox-table">
	<tbody>
		<?php foreach($listado_noticias as $ln){ ?>
		<tr <?php if(!$ln->leido){ ?> class="unread" <?php } ?> >
			<td class="td_info"><a href="javascript:;">Administrador</a>
			<br>
			<?php $fecha = explode("-", $ln->fecha); ?>
			<?php /* CALCULO DE DIAS ATRAS */ ?>
			<?php diferencia_fechas($ln->fecha,date("Y-m-d")); ?>
			</td>
			<td class="td_message" style="width: 100%;padding-left: 20px;padding-right: 20px;">
			<p class="subject">
				<a href="<?php echo base_url().$this->uri->segment(1) ?>/<?php echo $pag_lugar ?>/detalle/<?php echo $ln->id ?>"><?php echo $ln->titulo ?></a>
			</p>
			<p>
				<?php echo $ln->texto ?>
			</p>
			<div class="ver-mas"><a href="<?php echo base_url().$this->uri->segment(1) ?>/<?php echo $pag_lugar ?>/detalle/<?php echo $ln->id ?>">Leer todo...</a></div>
			</td>
			<td style="width:100px">
				<br/>
				<?php 
				if( $ln->activo == 1 ){ echo "<div style='color:green'>Vigente</div>";} 
				else{ echo "<div style='color:red'>No Vigente</div>"; } ?>
			</td>
			<td>&nbsp;&nbsp;</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php }else{ ?>
	<p>No existen anuncios actualmente.</p>
<?php } ?>
</div>