$(document).ready(function () {
	// Configuracion del datepicker
	$('.datepicker').datetimepicker({
		locale: 'es',
		format: 'DD-MMMM-YYYY',
		icons: {
			time: "fa fa-clock-o",
			date: "fa fa-calendar",
			up: "fa fa-chevron-up",
			down: "fa fa-chevron-down",
			previous: 'fa fa-chevron-left',
			next: 'fa fa-chevron-right',
			today: 'fa fa-screenshot',
			clear: 'fa fa-trash',
			close: 'fa fa-remove'
		}
	});
});

// Ajax generico para peticiones sincronas
var ajax = function (url, str) {
	response = [];
	$.ajax({
		url: url,
		data: str,
		type: 'POST',
		async: false,
		cache: false,
		dataType: 'json',
		success: function (json) {
			response = json;
		}
	});
	return response;
}

// Funcion para dar formato a un numero
function formato_numero(numero, decimales, separador_decimal, separador_miles) {
	numero = parseFloat(numero);
	if (isNaN(numero)) return '';
	if (decimales !== undefined) numero = numero.toFixed(decimales);
	numero = numero.toString().replace('.', separador_decimal !== undefined ? separador_decimal : ',');
	if (separador_miles) {
		var miles = new RegExp("(-?[0-9]+)([0-9]{3})");
		while (miles.test(numero)) {
			numero = numero.replace(miles, '$1' + separador_miles + '$2');
		}
	}
	return numero;
}