<?php $this->layout('Layout', ['title'=>'mSV::Escritorio', 'sitepage'=>'Escritorio'])?>
<?php $this->start('css')?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/morris.css') ?>">
<?php $this->stop()?>
<?php $this->start('vista')?>
<div class="row">
	<div class="col-xs-offset-0 col-xs-12 col-sm-4 col-md-4 col-lg-3">
		<div class="card">
			<div class="card-content">
				<div class="row">
					<div class="col-xs-4">
						<div class="icon-big icon-success text-center">
							<i class="ti-export"></i>
						</div>
					</div>
					<div class="col-xs-8">
						<div class="numbers">
							<p>Ventas</p>
							<font id="ventas"></font>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-offset-0 col-xs-12 col-sm-4 col-md-4 col-lg-3">
		<div class="card">
			<div class="card-content">
				<div class="row">
					<div class="col-xs-4">
						<div class="icon-big icon-warning text-center">
							<i class="ti-wallet"></i>
						</div>
					</div>
					<div class="col-xs-8">
						<div class="numbers">
							<p>Gastos</p>
							<font id="gastos"></font>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-offset-0 col-xs-12 col-sm-4 col-md-4 col-lg-6">
		<button type="button" class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#mgasto">Nuevo Gasto</button>
	</div>
</div>
<hr>
<div class="card">
	<div class="card-content">
		<div class="numbers pull-left">
			<font id="tvxh"></font>
		</div>
		<h6 class="big-title">
			<span class="text-muted">Ventas por hora en el día</span>
		</h6>
		<div id="vxh"></div>
	</div>
</div>
<div class="card">
	<div class="card-content">
		<div class="numbers pull-left">
			<font id="tvxd"></font>
		</div>
		<h6 class="big-title">
			<span class="text-muted">Ventas del último mes por día</span>
		</h6>
		<div id="vxd"></div>
	</div>
</div>
<div class="card">
	<div class="card-content">
		<div class="numbers pull-left">
			<font id="tvxm"></font>
		</div>
		<h6 class="big-title">
			<span class="text-muted">Ventas del último año por mes</span>
		</h6>
		<div id="vxm"></div>
	</div>
</div>
<div class="card">
	<div class="card-content">
		<div class="numbers pull-left">
			<font id="tvxa"></font>
		</div>
		<h6 class="big-title">
			<span class="text-muted">Ventas por año</span>
		</h6>
		<div id="vxa"></div>
	</div>
</div>
<div class="card">
	<div class="card-content">
		<div class="row">
			<div class="col-xs-12">
				<form action="#" id="fparametros" class="form-inline">
					<input type="text" class="form-control datepicker" name="fi" id="fi" placeholder="Fecha Inicial" required>
					<input type="text" class="form-control datepicker" name="ff" id="ff" placeholder="Fecha Final" required>
					<button type="submit" class="btn btn-primary">Generar</button>
				</form>
			</div>
		</div>
		<div class="nav-tabs-navigation">
			<div class="nav-tabs-wrapper">
				<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
					<li class="active"><a href="#rventas" data-toggle="tab">Ventas</a></li>
					<li><a href="#rgastos" data-toggle="tab">Gastos</a></li>
				</ul>
			</div>
		</div>
		<div id="my-tab-content" class="tab-content text-center">
			<div class="tab-pane active" id="rventas">
				<table id="tventas"></table>
			</div>
			<div class="tab-pane" id="rgastos">
				<table id="tgastos"></table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="mgasto">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Nuevo Gasto</h4>
			</div>
			<form id="fgasto">
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="importe">Importe</label>
								<input type="text" class="form-control" name="importe" id="importe" required>
							</div>
							<div class="form-group">
								<label for="gasto">Gasto</label>
								<textarea name="gasto" id="gasto" rows="3" class="form-control"></textarea>
							</div>
							<button type="submit" class="btn btn-primary btn-fill pull-rigth">Guardar</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php $this->stop()?>
<?php $this->start('js')?>
	<script src="<?php echo base_url('assets/js/raphael-min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/morris.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-table.js')?>"></script>
	<script src="<?php echo base_url('assets/js/locale/bootstrap-table-es-MX.min.js')?>"></script>
	<script src="<?php echo base_url('public/js/master.js') ?>"></script>
	<script src="<?php echo base_url('public/js/escritorio/inicio.js') ?>"></script>
<?php $this->stop()?>