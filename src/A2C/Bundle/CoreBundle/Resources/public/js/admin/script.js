jQuery(function($) {
	
	$('button[data-target="#modalDelete"]').on('click', modalDeleteOpen);

	$('a, button[title]').tooltip({});

	$('form').validate({
		ignore: [],
		errorPlacement: function(error, element) {},
		invalidHandler: validateInvalidHandlers
	});

	$('.chosen').chosen({
		width: '100%',
		no_results_text: 'Nenhum resultado encontrado:'
	}).on('change', function() {
		if ($(this).hasClass('required')) {
			if ($(this).val())
				$(this).next('.chosen-container').find('.chosen-choices').removeClass('error');
			else $(this).next('.chosen-container').find('.chosen-choices').addClass('error');
		}
	});

	$('.date').datepicker({
		autoclose: true,
		format: 'dd/mm/yyyy',
		language: 'pt-BR'
	});
});

function modalDeleteOpen(e) {
	e.preventDefault();

	var $form = $(this).closest('form');
	
	$('#modalDelete').find('a.confirm_delete').on('click', function() {
		$form.submit();
	});
}

function validateInvalidHandlers(event, validator) {
	var $el;
	$(validator.errorList).each(function(i, field) {
		var $el = $(field.element);

		if ($el.hasClass('chosen'))
			$el.next('.chosen-container').find('.chosen-choices').addClass('error');
	});
}

$.extend($.validator.messages, {
	required: "Este campo &eacute; obrigatório.",
	remote: "Por favor, corrija este campo.",
	email: "Por favor, forne&ccedil;a um endere&ccedil;o eletr&ocirc;nico v&aacute;lido.",
	url: "Por favor, forne&ccedil;a uma URL v&aacute;lida.",
	date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
	dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).",
	number: "Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.",
	digits: "Por favor, forne&ccedil;a somente d&iacute;gitos.",
	creditcard: "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
	equalTo: "Por favor, forne&ccedil;a o mesmo valor novamente.",
	accept: "Por favor, forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.",
	maxlength: $.validator.format("Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres."),
	minlength: $.validator.format("Por favor, forne&ccedil;a ao menos {0} caracteres."),
	rangelength: $.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento."),
	range: $.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1}."),
	max: $.validator.format("Por favor, forne&ccedil;a um valor menor ou igual a {0}."),
	min: $.validator.format("Por favor, forne&ccedil;a um valor maior ou igual a {0}.")
});

$.fn.datepicker.dates['pt-BR'] = {
	days: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
	daysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
	daysMin: ['Do', 'Se', 'Te', 'Qu', 'Qu', 'Se', 'Sá', 'Do'],
	months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
	monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
	today: 'Hoje',
	clear: 'Limpar'
};