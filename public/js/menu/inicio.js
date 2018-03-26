$(document).ready(function () {
	$tbody = $('#tplatillos > tbody');
	// Renderizamos el catálogo de categorias
	$categorias = ajax('../categoriasc/obtenerCategorias', null);
	$('#categorias, #cve_categoria').append("<option value=''>Categoria</option>");
	$.each($categorias, function (i, item) {
		$('#categorias, #cve_categoria').append("<option value='" + item.cve_categoria + "'>" + item.categoria + "</option>");
	});
	$('.selectpicker').selectpicker("refresh");
	// Cargamos el catalogo de platilos
	cargarPlatillos();
	// Recargar el catalogo de platillos
	$('#generar').click(function () {
		cargarPlatillos();
	});
	// Vaciamos el formulario al momento de cerrar el modal de platillos
	$('#mplatillos').on('hidden.bs.modal', function (e) {
		$('#cve_platillo, #platillo, #resenia, #precio_unitario').val('');
		$('#cve_categoria').selectpicker('val', '');
	})
	// Abrimos el formulario para editar la información de la categoría
	$('#tplatillos tbody').on('click', 'button.editar', function () {
		$tr = $(this).parent().parent();
		$cve_platillo = $tr.children().eq(0).html();
		$cve_categoria = $tr.children().eq(1).html();
		$platillo = $tr.children().eq(3).children().eq(0).html();
		$resenia = $tr.children().eq(3).children().eq(1).html();
		$precio_unitario = $tr.children().eq(5).html();
		$('#cve_platillo').val($cve_platillo);
		$('#platillo').val($platillo);
		$('#cve_categoria').selectpicker('val',$cve_categoria);
		$('#precio_unitario').val($precio_unitario);
		$('#resenia').val($resenia);
		$('#mplatillos').modal('show');
	});

	// Enviamos el formulario para editar / dar de alta un platillo
	$('#fplatillos').submit(function (e) {
		e.preventDefault();
		var f = $(this);
		var formData = new FormData(document.getElementById('fplatillos'));
		$.ajax({
			url: 'crudPlatillos',
			type: 'POST',
			async: true,
			cache: false,
			dataType: 'json',
			data: formData,
			processData: false,
			contentType: false,
			beforeSend: function () {
				swal({
					html: '<h3>Guardando datos, espera...</h3>',
					showConfirmButton: false,
					type: 'info'
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
					$.notify({
						message: data.msj
					}, {
							type: 'success'
						});
					cargarPlatillos();
					swal.close();
					$('#mplatillos').modal('hide');
				}
			}
		});
	});

});
// Funcion para obtener el catalogo de platillos
function obtenerPlatillos() {
	return ajax('obtenerPlatillos', {categoria: $('#categorias').val()});
}
// Funcion para recargar el catalogo de platillos
function cargarPlatillos() {
	$tbody.empty();
	$platillos = obtenerPlatillos();
	$.each($platillos, function (i, item) {
		$tbody.append("<tr>" +
			"<td class='hidden'>" + item.cve_platillo + "</td>" +
			"<td class='hidden'>" + item.cve_categoria + "</td>" +
			"<td>" +
				"<div class='img-container'>" +
				"<img src='../" + item.url_img + "' alt='" + item.platillo + "'>" +
				"</div>" +
			"</td>" +
			"<td class='td-product text-left'>" +
				"<strong>" + item.platillo + "</strong>" +
				"<p>" + item.resenia + "</p>" +
			"</td>" +
			"<td class='text-left'>" + item.categoria + "</td>" +
			"<td class='td-number'>" + formato_numero(item.precio_unitario, 2, '.', ',') + "</td>" +
			"<td class='text-center' style='width:150px'>" +
			"<button type='button' class='btn btn-primary editar'>Editar</button>" +
			"</td>" +
			"</tr>");
	});
}