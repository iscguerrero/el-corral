$(document).ready(function () {
/*	tipos = ObtenerTipos();
	// Cargamos los combos de la vista
	$('#selectTipos').html("<option value=''>Selecciona...</option>");
	$.each(tipos, function (key, item) {
		$('#selectTipos').append("<option value='" + item.cve_tipo + "'>" + item.tipo + "</option>");
	});
	$('.selectpicker').selectpicker("refresh");*/

	// Configuracion de la tabla de productos
	$('#platillos').bootstrapTable({
		data: ObtenerPlatillos(),
		toolbar: '#toolbar',
		clickToSelect: true,
		search: true,
		pagination: true,
		pageSize: 5,
		pageList: [5, 10, 25, 50],
		classes: 'table table-shopping',
		columns: [
			{ field: 'cve_platillo', visible: false },
			{
				field: 'url_img', title: '', align: 'center', formatter: function (value, row, index) {
					return "<div class='img-container'>< img src='./assets/images/bg1.jpg' alt= 'Agenda' ></div >";
				}
			},
			{ field: 'tipo', title: 'Tipo', align: 'left' },
			{ field: 'platillo', title: 'Platillo', align: 'left', class: 'td-product'},
			{ field: 'precio_unitario', title: 'Precio', align: 'right' },
			{ field: 'resumen', title: 'Reseña', align: 'left' },
		],
		onClickRow: function (row, $element, field) {
			selectedItem = row.cve_cat_producto;
		}
	});


});

function ObtenerPlatillos() {
	return [{
		cve_platillo: 1,
		tipo: 'Platillo',
		precio_unitario: 20,
		platillo: 'taco',
		resumen: 'taco simple de bistec'
	}]
}