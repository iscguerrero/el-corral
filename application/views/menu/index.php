<?php $this->layout('layout', ['title' => 'El Corral']) ?>
<?php $this->start('css') ?>

<?php $this->stop() ?>
<?php $this->start('vista') ?>
	<div class="card">
		<div class="card-header">
			<h2 class="card-title">Lista de productos activos en el menú</h2>
			<p class="category" style="color: #000">Los productos aquí listados son los que aparacen en el menú de la página y en el menú del punto de venta</p>
		</div>
		<div class="card-content">
			<div class="row">
				<div class="col-xs-12">
					<button class="btn btn-primary btn-lg">Nuevo</button>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-shopping">
					<thead>
						<tr>
							<th class="text-center"></th>
							<th></th>
							<th class="text-right">Precio</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="img-container">
									<img src="./assets/images/0302-steak.png" alt="Agenda">
								</div>
							</td>
							<td class="td-product">
								<strong>Tacos</strong>
								<p>Taco simple tortilla normal.</p>
							</td>
							<td class="td-number">
								<small>&dollar;</small>10
							</td>
						</tr>
						<tr>
							<td>
								<div class="img-container">
									<img src="./assets/images/0302-steak.png" alt="Agenda">
								</div>
							</td>
							<td class="td-product">
								<strong>Tacos</strong>
								<p>Taco simple tortilla normal.</p>
							</td>
							<td class="td-number">
								<small>&dollar;</small>10
							</td>
						</tr>
						<tr>
							<td>
								<div class="img-container">
									<img src="./assets/images/0302-steak.png" alt="Agenda">
								</div>
							</td>
							<td class="td-product">
								<strong>Tacos</strong>
								<p>Taco simple tortilla normal.</p>
							</td>
							<td class="td-number">
								<small>&dollar;</small>10
							</td>
						</tr>
						<tr>
							<td>
								<div class="img-container">
									<img src="./assets/images/0302-steak.png" alt="Agenda">
								</div>
							</td>
							<td class="td-product">
								<strong>Tacos</strong>
								<p>Taco simple tortilla normal.</p>
							</td>
							<td class="td-number">
								<small>&dollar;</small>10
							</td>
						</tr>
						<tr>
							<td>
								<div class="img-container">
									<img src="./assets/images/0302-steak.png" alt="Agenda">
								</div>
							</td>
							<td class="td-product">
								<strong>Tacos</strong>
								<p>Taco simple tortilla normal.</p>
							</td>
							<td class="td-number">
								<small>&dollar;</small>10
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php $this->stop() ?>
<?php $this->start('js') ?>
	<script src="<?php echo base_url('public/js/menu/index.js') ?>"></script>
<?php $this->stop() ?>