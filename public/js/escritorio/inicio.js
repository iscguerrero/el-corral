$(document).ready(function () {
	$selectedItem = '';
	// Obtenemos la venta del ultimo mes
	var data = ajax('ObtenerData', { fi: '01-Enero-2018', ff: '27-Marzo-2018' });
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
					return "<button type='buton' class='btn btn-sm btn-primary imprimir'><i class='fa fa-file-pdf-o'></i></button>";
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
	// Configuracion de la tabla de resumen de gastos
	$('#tgastos').bootstrapTable({
		data: [],
		columns: [
			{ field: 'gasto', title: 'Gasto', align: 'left' },
			{ field: 'fecha', title: 'Fecha', align: 'center' },
			{
				field: 'importe', title: 'Importe', align: 'right', formatter: function (value, row, index) {
					return formato_numero(value, 2, '.', ',');
				}
			}
		]
	});
	// Generamos los reportes de resumen de ventas y gastos
	$('#fparametros').submit(function (e) {
		e.preventDefault();
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
					$('#tventas').bootstrapTable('load', data.rventas);
					$('#tgastos').bootstrapTable('load', data.rgastos);
					swal.close();
				}
			}
		});
	});
	$('#mgasto').on('hidden.bs.modal', function (e) {
		$('#gasto, #importe').val();
	})

	// Guardamos un nuevo gasto
	$('#fgasto').submit(function (e) {
		e.preventDefault();
		str = $('#fgasto').serialize();
		$.ajax({
			url: 'NuevoGasto',
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
	});

});