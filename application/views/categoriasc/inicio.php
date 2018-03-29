<?php $this->layout('layout', ['title' => 'El Corral']) ?>
<?php $this->start('css') ?>

<?php $this->stop() ?>
<?php $this->start('vista') ?>
	<div class="card">
		<div class="card-header">
			<h2 class="card-title">Categorías</h2>
			<p class="category" style="color: #000">El catálogo de categorías son las divisiones en las que puedes clasificar los consumos del restaurante</p>
		</div>
		<div class="card-content">
			<div class="row">
				<div class="col-xs-12">
					<button class="btn btn-primary" data-toggle="modal" data-target="#mcategorias">Nueva</button>
				</div>
			</div>
			<br>
			<div class="table-responsive">
				<table class="table table-shopping" id="tcategorias">
					<thead>
						<tr>
							<th class="hidden"></th>
							<th class="text-left">Categoría</th>
							<th class="text-center" style='width:150px'>Acciones</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- Modal para crud de marcas -->
	<div class="modal fade" tabindex="-1" role="dialog" id="mcategorias">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Categorías</h4>
				</div>
				<form id="fcategorias">
					<input type="hidden" name="cve_categoria" id="cve_categoria">
					<div class="modal-body">
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
									<label for="categoria">Categoría</label>
									<input type="text" class="form-control" name="categoria" id="categoria" required>
								</div>
								<div class="form-group">
									<label for="resenia">Reseña</label>
									<textarea rows="3" class="form-control" name="resenia" id="resenia" required></textarea>
								</div>
								<div class="form-group">
									<label for="estatus">Estatus</label>
									<select class="form-control" name="estatus" id="estatus">
										<option value="A">Activo</option>
										<option value="X">Suspendido</option>
									</select>
								</div>
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
	<script src="<?php echo base_url('public/js/categorias/inicio.js') ?>"></script>
<?php $this->stop() ?>