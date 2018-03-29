$(document).ready(function () {
	$selectedItem = $selectedGasto = '';
	// Obtenemos la venta del ultimo mes
	var data = ajax('ObtenerData', null);
	// Tarjetones
	$('#ventas').html('$' + formato_numero(data.ventas, 2, '.', ','));
	$('#gastos').html('$' + formato_numero(data.gastos, 2, '.', ','));	// Venta del mes por dia
	$tvxh = 0;
	$.each(data.ventasxhora, function (i, item) {
		$tvxh = $tvxh + parseFloat(item.total);
	});
	$('#tvxh').text(formato_numero($tvxh, 2, '.', ','));
	Morris.Area({
		element: 'vxh',
		behaveLikeLine: true,
		data: data.ventasxhora,
		xkey: 'fecha',
		ykeys: ['total'],
		labels: ['Venta'],
		parseTime: false,
		lineColors: ['#7AC29A'],
		resize: true
	});
	// Venta del mes por dia
	$tvxd = 0;
	$.each(data.ventasxdia, function (i, item) { 
		$tvxd = $tvxd + parseFloat(item.total);
	});
	$('#tvxd').text(formato_numero($tvxd, 2, '.', ','));
	Morris.Area({
		element: 'vxd',
		behaveLikeLine: true,
		data: data.ventasxdia,
		xkey: 'fecha',
		ykeys: ['total'],
		labels: ['Venta'],
		parseTime: false,
		lineColors: ['#7AC29A'],
		resize: true
	});
	// Venta del año por mes
	$tvxm = 0;
	$.each(data.ventasxmes, function (i, item) {
		$tvxm = $tvxm + parseFloat(item.total);
	});
	$('#tvxm').text(formato_numero($tvxm, 2, '.', ','));
	Morris.Area({
		element: 'vxm',
		behaveLikeLine: true,
		data: data.ventasxmes,
		xkey: 'fecha',
		ykeys: ['total'],
		labels: ['Venta'],
		parseTime: false,
		lineColors: ['#7AC29A'],
		resize: true
	});
	// Ventas por año del periodo seleccionado
	$tvxa = 0;
	$.each(data.ventasxanio, function (i, item) {
		$tvxa = $tvxa + parseFloat(item.total);
	});
	$('#tvxa').text(formato_numero($tvxa, 2, '.', ','));
	Morris.Area({
		element: 'vxa',
		behaveLikeLine: true,
		data: data.ventasxanio,
		xkey: 'fecha',
		ykeys: ['total'],
		labels: ['Venta'],
		parseTime: false,
		lineColors: ['#7AC29A'],
		resize: true
	});
	// Configuracion de la tabla de resumen de ventas
	$('#tventas').bootstrapTable({
		data: [],
		clickToSelect: true,
		columns: [
			{
				field: 'folio', title: 'Folio', align: 'left', formatter: function (value, row, index) {
					return 'F' + value;
				}
			},
			{ field: 'fecha', title: 'Fecha', align: 'center'},
			{
				field: 'total', title: 'Total', align: 'right', formatter: function (value, row, index) {
					return formato_numero(value, 2, '.', ',');
				}
			},
			{
				field: 'efectivo', title: 'Efectivo', align: 'right', formatter: function (value, row, index) {
					return formato_numero(value, 2, '.', ',');
				}
			},
			{
				align: 'center', formatter: function (value, row, index) {
					return "<button type='buton' class='btn btn-sm btn-primary imprimir'><i class='fa fa-file-pdf-o'></i></button> <button type='button' class='btn btn-primary btn-sm quitar'><i class='fa fa-times-circle'></i></button>";
				}
			}
		],
		onClickRow: function (row, $element, field) {
			$selectedItem = row.folio;
		}
	});
	// Imprimir el ticket de compra
	$('#tventas tbody').on('click', 'button.imprimir', function () {
		window.open('../punto/Ticket/' + $selectedItem);
	});
	// Para cancelar una venta
	$('#tventas tbody').on('click', 'button.quitar', function () {
		cancelarVenta($selectedItem);
	});
	// Configuracion de la tabla de resumen de gastos
	$('#tgastos').bootstrapTable({
		data: [],
		clickToSelect: true,
		columns: [
			{ field: 'id' },
			{ field: 'gasto', title: 'Gasto', align: 'left' },
			{ field: 'fecha', title: 'Fecha', align: 'center' },
			{
				field: 'importe', title: 'Importe', align: 'right', formatter: function (value, row, index) {
					return formato_numero(value, 2, '.', ',');
				}
			},
			{
				align: 'center', formatter: function (value, row, index) {
					return "<button type='button' class='btn btn-primary btn-sm quitar'><i class='fa fa-times-circle'></i></button>";
				}
			}
		],
		onClickRow: function (row, $element, field) {
			$selectedGasto = row.id;
		}
	});
	// Para cancelar una gasto
	$('#tgastos tbody').on('click', 'button.quitar', function () {
		cancelarGasto($selectedGasto);
	});
	// Generamos los reportes de resumen de ventas y gastos
	$('#fparametros').submit(function (e) {
		e.preventDefault();
		cargarResumen();
	});
	$('#mgasto').on('hidden.bs.modal', function (e) {
		$('#gasto, #importe').val('');
	})

	// Guardamos un nuevo gasto
	$('#fgasto').submit(function (e) {
		e.preventDefault();
		nuevoGasto();
	});

});

// Funcion para registrar un nuevo gasto
function nuevoGasto() {
	str = $('#fgasto').serialize();
	$.ajax({
		url: 'nuevoGasto',
		type: 'POST',
		async: true,
		cache: false,
		dataType: 'json',
		data: str,
		beforeSend: function () {
			swal({
				type: 'info',
				html: '<h3>Espera un momento...</h3>',
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
				$('#mgasto').modal('hide');
				swal.close();
			}
		}
	});
}

// Funcion para cargar el resumen de ventas y gastos
function cargarResumen() {
	str = $('#fparametros').serialize();
	$.ajax({
		url: 'ObtenerResumen',
		type: 'POST',
		async: true,
		cache: false,
		dataType: 'json',
		data: str,
		beforeSend: function () {
			swal({
				type: 'info',
				html: '<h3>Espera un momento...</h3>',
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
				$tventas = $tgastos = $tutilidad = 0;
				if (data.rventas.length > 0) {
					$('#tventas').bootstrapTable('load', data.rventas);
					$.each(data.rventas, function (i, item) {
						$tventas = parseFloat($tventas) + parseFloat(item.total);
					});
				}
				if (data.rgastos.length > 0) {
					$('#tgastos').bootstrapTable('load', data.rgastos);
					$.each(data.rgastos, function (i, item) {
						$tgastos = parseFloat($tgastos) + parseFloat(item.importe);
					});
				}
				$('#erventas').html('$' + formato_numero($tventas, 2, '.', ','));
				$('#ergastos').html('$' + formato_numero($tgastos, 2, '.', ','));
				$('#erutilidad').html('$' + formato_numero($tventas - $tgastos, 2, '.', ','));

				swal.close();
			}
		}
	});
}

// Funcion para cancelar una venta
function cancelarVenta(selectedItem) {
	swal({
		type: 'question',
		title: "Espera",
		html: 'Estás a punto de cancelar esta venta ¿Deseas continuar?',
		buttonsStyling: true,
		showCancelButton: true,
		confirmButtonText: 'Si',
		cancelButtonText: 'No',
		confirmButtonColor: '#d33',
		cancelButtonColor: '#3085d6',
		confirmButtonClass: "btn btn-primary btn-fill",
		cancelButtonClass: "btn btn-default btn-fill"
	}).then(function (isConfirm) {
		borrarVenta(selectedItem);
	}, function () {
		swal.close();
	});
}

// Funcion para cancelar un gasto
function cancelarGasto(selectedGasto) {
	swal({
		type: 'question',
		title: "Espera",
		html: 'Estás a punto de cancelar este gasto ¿Deseas continuar?',
		buttonsStyling: true,
		showCancelButton: true,
		confirmButtonText: 'Si',
		cancelButtonText: 'No',
		confirmButtonColor: '#d33',
		cancelButtonColor: '#3085d6',
		confirmButtonClass: "btn btn-primary btn-fill",
		cancelButtonClass: "btn btn-default btn-fill"
	}).then(function (isConfirm) {
		borrarGasto(selectedGasto);
	}, function () {
		swal.close();
	});
}

// Funcion para borrar una venta
function borrarVenta(selectedItem) {
	$.ajax({
		url: 'borrarVenta',
		type: 'POST',
		async: true,
		cache: false,
		dataType: 'json',
		data: { folio: selectedItem},
		beforeSend: function () {
			swal({
				type: 'info',
				html: '<h3>Espera un momento...</h3>',
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
				cargarResumen();
			}
		}
	});
}

// Funcion para borrar un gasto
function borrarGasto(selectedGasto) {
	$.ajax({
		url: 'borrarGasto',
		type: 'POST',
		async: true,
		cache: false,
		dataType: 'json',
		data: { id: selectedGasto },
		beforeSend: function () {
			swal({
				type: 'info',
				html: '<h3>Espera un momento...</h3>',
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
				cargarResumen();
			}
		}
	});
}