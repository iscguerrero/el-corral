
<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<!--link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../../assets/img/favicon.png"-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Lonchería "El Corral"</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />
	<link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/paper-dashboard.css') ?>" rel="stylesheet"/>
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
	<link href="<?php echo base_url('assets/css/themify-icons.css') ?>" rel="stylesheet">
	<style>
		.login-page > .content, .lock-page > .content {
			padding-top: 12vh;
		}
	</style>
</head>

<body>
	<nav class="navbar navbar-transparent navbar-absolute">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo base_url('escritorio') ?>">El Corral</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="<?php echo base_url('menu') ?>">Menú</a>
					<li><a href="<?php echo base_url('punto') ?>">Punto</a></li>
					<li><a href="<?php echo base_url('escritorio') ?>">Escritorio</a>
					<li><a href="<?php echo base_url('gastos') ?>">Gastos</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="wrapper wrapper-full-page">
		<div class="full-page login-page" data-color="" data-image="<?php echo base_url('assets/images/bg2.jpg') ?>">
			<div class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-12">
							<div class="card card-plain" data-background="color" data-color="orange">
									<div class="card-header">
										<h3 class="card-title">Punto</h3>
									</div>
									<div class="card-content">
										<h3>Hola</h3>

									</div>
									<div class="card-footer text-center">
										<button type="submit" class="btn btn-fill btn-wd ">Let's go</button>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer class="footer footer-transparent">
				<div class="container">
					<div class="copyright">
						&copy; <script>document.write(new Date().getFullYear())</script> DG Consultora <i class="fa fa-heart"></i> ideas nacen, proyectos crecen
					</div>
				</div>
			</footer>
		</div>
	</div>
</body>
	<script src="<?php echo base_url('assets/js/jquery-3.1.1.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/perfect-scrollbar.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/es6-promise-auto.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-notify.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-switch-tags.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/sweetalert2.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-table.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/paper-dashboard.js') ?>"></script>
	<script type="text/javascript">
		$().ready(function(){
	$page = $('.full-page');
	image_src = $page.data('image');
	if (image_src !== undefined) {
		image_container = '<div class="full-page-background" style="background-image: url(' + image_src + ') "/>'
		$page.append(image_container);
	}
	setTimeout(function () {
		$('.card').removeClass('card-hidden');
	}, 700);
		});
	</script>

</html>
