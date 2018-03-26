$(document).ready(function () {
	$tbody = $('#tcategorias > tbody');
	// Cargamos el catálogo de categorías en la vista
	cargarCategorias();
	// Vaciamos el formulario al momento de cerrar el modal de categorias
	$('#mcategorias').on('hidden.bs.modal', function (e) {
		$('#cve_categoria, #categoria, #resenia').val('');
	})
	// Abrimos el formulario para editar la información de la categoría
	$('#tcategorias tbody').on('click', 'button.editar', function () {
		$tr = $(this).parent().parent();
		$cve_categoria = $tr.children().eq(0).html();
		$categoria = $tr.children().eq(1).children().eq(0).html();
		$resenia = $tr.children().eq(1).children().eq(1).html();
		$('#cve_categoria').val($cve_categoria);
		$('#categoria').val($categoria);
		$('#resenia').val($resenia);
		$('#mcategorias').modal('show');
	});

	// Enviamos el formulario para editar / dar de alta una categoria
	$('#fcategorias').submit(function (e) {
		e.preventDefault();
		str = $('#fcategorias').serialize();
		$.ajax({
			url: 'crudCategorias',
			type: 'POST',
			async: true,
			cache: false,
			dataType: 'json',
			data: str,
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
					cargarCategorias();
					swal.close();
					$('#mcategorias').modal('hide');
				}
			}
		});
	});

});
// Funcion para obtener las categorias activas del sistema
function obtenerCategorias() {
	return ajax('obtenerCategorias', null);
}
// Funcion para recargar las categorias en la vista
function cargarCategorias() {
	$tbody.empty();
	$categorias = obtenerCategorias();
	$.each($categorias, function (i, item) {
		$tbody.append("<tr>" +
			"<td class='hidden'>" + item.cve_categoria + "</td>" +
			"<td class='td-product text-left'>" +
			"<strong>" + item.categoria + "</strong>" +
			"<p>" + item.resenia + "</p>" +
			"</td>" +
			"<td class='text-center' style='width:150px'>" +
			"<button type='button' class='btn btn-primary editar'>Editar</button>" +
			"</td>" +
			"</tr>");
	});
}