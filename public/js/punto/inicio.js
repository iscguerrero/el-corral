$(document).ready(function () {
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
		$row = {
			'cve_platillo': $('#cve_platillo').val(),
			'platillo': $('#cve_platillo').val(),
			'precio_unitario': $precio_unitario,
			'piezas': $('#piezas').val(),
			'total': parseFloat($precio_unitario.replace('$', '').replace(',', '')) * parseFloat($('#piezas').val())
		};

	});
	// Configuracion de la tabla de partidas del pedido
	$('#partidas').bootstrapTable({
		data: [],
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


});

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
