<?php $this->layout('layout', ['title' => 'El Corral']) ?>
<?php $this->start('css') ?>
<style>
	.card-user .card-content {
		min-height: 200px;
		padding: 0px 0px 0px 0px;
	}
	.card-user .author .card-title {
		color: #fff;
	}
	.card-user .author .card-title small {
		color: #fff;
	}
	.card[data-background-color="green"] {
		background: #14EF10;
	}
	.card[data-background-color="orange"] {
		background: #ED630E;
	}
</style>
<?php $this->stop() ?>
<?php $this->start('vista') ?>
<div class="card">
	<div class="card-content">
		<div class="nav-tabs-navigation">
			<div class="nav-tabs-wrapper">
				<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
					<li class="active"><a href="#menu" data-toggle="tab">Menú</a></li>
					<li><a href="#bebidas" data-toggle="tab">Bebidas</a></li>
				</ul>
			</div>
		</div>
		<div id="my-tab-content" class="tab-content text-center">
			<div class="tab-pane active" id="menu">
				<div class="row" id="rowmenu"></div>
			</div>
			<div class="tab-pane" id="bebidas">
				<div class="row" id="rowbebidas"></div>
			</div>
		</div>
		<div class="table-responsive">
			<table id="partidas">
				<tfoot>
					<tr>
						<td colspan="3"></td>
						<td class="text-right" id="ttotal"></td>
						<td></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-12">
				<div class="input-group pull-right" style="max-width: 350px">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default" id="cancelar">Cancelar</button>
					</span>
					<input type="text" class="form-control text-right" name="efectivo" id="efectivo" placeholder="Paga con...">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default" id="finalizar" >Finalizar</button>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal para capturar unidades -->
<div class="modal fade" tabindex="-1" role="dialog" id="mpiezas">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<form id="fpiezas">
				<input type="hidden" name="cve_platillo" id="cve_platillo">
				<input type="hidden" name="platillo" id="platillo">
				<input type="hidden" name="precio_unitario" id="precio_unitario">
				<div class="modal-body">
					<div class="input-group">
						<input type="number" class="form-control" name="piezas" id="piezas" placeholder="Cantidad" required>
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit">Capturar</button>
						</span>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php $this->stop() ?>
<?php $this->start('js') ?>
	<script src="<?php echo base_url('assets/js/bootstrap-table.js')?>"></script>
	<script src="<?php echo base_url('assets/js/locale/bootstrap-table-es-MX.min.js')?>"></script>
	<script src="<?php echo base_url('public/js/master.js') ?>"></script>
	<script src="<?php echo base_url('public/js/punto/inicio.js') ?>"></script>
<?php $this->stop() ?>