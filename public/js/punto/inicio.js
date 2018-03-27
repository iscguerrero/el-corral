$(document).ready(function () {
	$partidas = []; $selectedItem = '';
	// Renderizamos el menu del restaurante
	$menu = ajax('../menu/obtenerPlatillos', { categoria: 1 })
	$.each($menu, function (i, item) { 
		renderItem($('#rowmenu'), { cve_platillo: item.cve_platillo, platillo: item.platillo, precio_unitario: formato_numero(item.precio_unitario, 2, '.', ','), url_img: item.url_img }, 'orange');
	});
	$bebidas = ajax('../menu/obtenerPlatillos', { categoria: 2 })
	$.each($bebidas, function (i, item) {
		renderItem($('#rowbebidas'), { cve_platillo: item.cve_platillo, platillo: item.platillo, precio_unitario: formato_numero(item.precio_unitario, 2, '.', ','), url_img: item.url_img }, 'green');
	});
	// Abrir el modal para solicitar la cantidad de piezas por platillo
	$('a.platillo').on('click', function (e) {
		e.preventDefault();
		$this = $(this);
		$cve_platillo = $this.attr('id');
		$platillo = $this.children().eq(0).children().eq(1).children().eq(0).children().eq(1).children().eq(0).text();
		$precio_unitario = $this.children().eq(0).children().eq(1).children().eq(0).children().eq(1).children().eq(2).text();
		$('#cve_platillo').val($cve_platillo);
		$('#platillo').val($platillo);
		$('#precio_unitario').val($precio_unitario);
		$('#mpiezas').modal('show');
	});
	$('#mpiezas').on('shown.bs.modal', function (e) {
		$('#piezas').val('').focus();
	}).on('hidden.bs.modal', function (e) {
		$('#piezas, #cve_platillo, #precio_unitario, #platillo').val('');
		});
	// Agregar la fila a la lista del pedido
	$('#fpiezas').submit(function (e) {
		e.preventDefault();
		$precio_unitario = $('#precio_unitario').val();
		$flag = false;
		$.each($partidas, function (i, item) {
			if ($('#cve_platillo').val() == item.cve_platillo) {
				$partidas[i].piezas = parseFloat($partidas[i].piezas) + parseFloat($('#piezas').val());
				$partidas[i].total = parseFloat($precio_unitario.replace('$', '').replace(',', '')) * parseFloat($partidas[i].piezas)
				$flag = true;
			}
		});
		if ($flag == false) {
			$row = {
				'cve_platillo': $('#cve_platillo').val(),
				'platillo': $('#platillo').val(),
				'precio_unitario': $('#precio_unitario').val(),
				'piezas': $('#piezas').val(),
				'total': parseFloat($precio_unitario.replace('$', '').replace(',', '')) * parseFloat($('#piezas').val())
			};
			$partidas.push($row);
		}
		$('#partidas').bootstrapTable('load', $partidas);
		actualizarTotal();
		$('#mpiezas').modal('hide');
	});
	// Configuracion de la tabla de partidas del pedido
	$('#partidas').bootstrapTable({
		data: $partidas,
		toolbar: '#toolbar',
		clickToSelect: true,
		columns: [
			{ field: 'cve_platillo', visible: false },
			{ field: 'platillo', title: '', align: 'left' },
			{
				field: 'piezas', title: 'Piezas', align: 'right', formatter: function (value, row, index) {
					return formato_numero(value, 2, '.', ',');
				}
			},
			{
				field: 'precio_unitario', title: 'Precio', align: 'right', formatter: function (value, row, index) {
					return value;
				}
			},
			{
				field: 'total', title: 'Total', align: 'right', formatter: function (value, row, index) {
					return formato_numero(value, 2, '.', ',');
				}
			},
			{
				title: '', align: 'right', formatter: function (value, row, index) {
					return "<button type='button' class='btn btn-primary quitar'><i class='fa fa-times-circle'></i></button>";
				}
			}
		],
		onClickRow: function (row, $element, field) {
			$selectedItem = row.cve_platillo;
		}
	});
	// Borrar la fila seleccionada
	$('#partidas tbody').on('click', 'button.quitar', function () {
		console.log('hol');
		$('#partidas').bootstrapTable('remove', { field: 'cve_platillo', values: [$selectedItem] });
		actualizarTotal();
	});
	// Funcion para cancelar la venta
	$('#cancelar').click(function () {
		limpiar();
	});
	// Funcion para finalizar la venta
	$('#finalizar').click(function () {
		$partidas = $('#partidas').bootstrapTable('getData');
		if ($partidas.length == 0) {
			swal({
				html: '<h3>Estás registrando una venta en ceros</h3>',
				showConfirmButton: true,
				type: 'info',
			});
			return false;
		}
		$.ajax({
			url: 'EjecutarVenta',
			type: 'POST',
			async: true,
			cache: false,
			dataType: 'json',
			data: { partidas: $partidas, efectivo: $('#efectivo').val() },
			beforeSend: function () {
				swal({
					type: 'info',
					html: '<h3>Espera un momento...</h3>',
					showConfirmButton: false,
					allowOutsideClick: false,
					allowEscapeKey: false
				});
			},
			success: function (data) {
				if (data.bandera == false) {
					swal({
						title: "Atiende!",
						html: data.msj,
						buttonsStyling: true,
						confirmButtonClass: "btn btn-warning btn-fill",
						type: 'warning'
					});
					return false
				} else {
					swal({
						type: 'question',
						title: "Éxito!",
						html: 'La venta se registro con éxito! </br> ' + data.msj + '</br> ¿Deseas imprimir el ticket de venta?',
						buttonsStyling: true,
						showCancelButton: true,
						confirmButtonText: 'Si',
						cancelButtonText: 'No',
						confirmButtonColor: '#d33',
						cancelButtonColor: '#3085d6',
						confirmButtonClass: "btn btn-primary btn-fill",
						cancelButtonClass: "btn btn-default btn-fill"
					}).then(function (isConfirm) {
						limpiar();
						window.open('Ticket/' + data.folio);
					}, function () {
						limpiar();
					});
				}
			}
		});
	});

});

// Funcion para actualizar el total de la tabla
function actualizarTotal() {
	$total = 0;
	$.each($partidas, function (i, item) {
		$total = $total + item.total;
	});
	$('#ttotal').html(formato_numero($total, 2, '.', ','));
}

// Funcion para renderizar un item del menu en la vista
function renderItem($parent, $item, $color) {
	$parent.append(
		"<div class='col-xs-6 col-sm-4 col-md-4 col-lg-3'>" +
		"	<a class='platillo' href='#' id=" + $item.cve_platillo + ">" +
		"		<div class='card card-user' data-background-color='" + $color + "'>" +
		"			<div class='image'>" +
		"			<img src='../assets/images/logo.jpeg' alt='...' />" +
		"			</div>" +
		"			<div class='card-content'>" +
		"				<div class='author'>" +
		"					<img class='avatar border-white' src='../" + $item.url_img + "' alt='...' />" +
		"					<h4 class='card-title'><font>" + $item.platillo + "</font><br />" +
		"						<small>$" + formato_numero($item.precio_unitario, 2, '.', ',') + "</small>" +
		"					</h4>" +
		"				</div>" +
		"			</div>" +
		"		</div>" +
		"	</a>" +
		"</div>"
	);
}

// Funcion para limpiar el punto de venta
function limpiar() {
	$('#partidas').bootstrapTable('removeAll');
	$('#efectivo').val('');
	$('#ttotal').html('');
}