<?php $this->layout('layout', ['title' => 'El Corral']) ?>
<?php $this->start('css') ?>
<?php $this->stop() ?>
<?php $this->start('vista') ?>
	<div class="card">
		<div class="card-header">
			<h2 class="card-title">Menú</h2>
			<p class="category" style="color: #000">La lista de alimentos aquí registrada es la misma lista que aparecerá en el menú de la página y en el punto de venta</p>
		</div>
		<div class="card-content">
			<div class="row">
				<div class="col-xs-3">
					<select class="selectpicker" data-style="btn btn-primary btn-block" title="Categorías" data-size="4" name="categorias" id="categorias"></select>
				</div>
				<div class="col-xs-9">
					<button type="button" class="btn btn-success" id="generar">Filtrar</button>
					<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#mplatillos">Nuevo</button>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-shopping" id="tplatillos">
					<thead>
						<tr>
							<th class="hidden"></th>
							<th class="hidden"></th>
							<th class="text-center"></th>
							<th class="text-left">Platillo</th>
							<th class="text-left">Categoría</th>
							<th class="text-right" style='width:150px'>Precio</th>
							<th class="text-center" style='width:150px'>Acciones</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- Modal para crud de platillos -->
	<div class="modal fade" tabindex="-1" role="dialog" id="mplatillos">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Platillo</h4>
				</div>
				<form id="fplatillos" enctype="multipart/form-data">
					<input type="hidden" name="cve_platillo" id="cve_platillo">
					<div class="modal-body">
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
									<label for="platillo">Platillo</label>
									<input type="text" class="form-control" name="platillo" id="platillo" required>
								</div>
								<div class="form-group">
									<label for="resenia">Reseña</label>
									<textarea rows="2" class="form-control" name="resenia" id="resenia" required></textarea>
								</div>
								<div class="form-group">
									<select class="selectpicker" data-style="btn btn-primary btn-block" title="Categoría" data-size="4" name="cve_categoria" id="cve_categoria"></select>
								</div>
								<div class="form-group">
									<label for="precio_unitario">Precio</label>
									<input type="number" class="form-control text-right" name="precio_unitario" id="precio_unitario" in="0" step="0.1" required>
								</div>
								<div class="form-group">
									<label for="estatus">Estatus</label>
									<select class="form-control" name="estatus" id="estatus">
										<option value="A">Activo</option>
										<option value="X">Suspendido</option>
									</select>
								</div>
								<label class="btn btn-default btn-file btn-block">
									Buscar Imagen <input type="file" name="imagen" id="imagen" style="display: none;">
								</label>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
						<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php $this->stop() ?>
<?php $this->start('js') ?>
	<script src="<?php echo base_url('public/js/master.js') ?>"></script>
	<script src="<?php echo base_url('public/js/menu/inicio.js') ?>"></script>
<?php $this->stop() ?>