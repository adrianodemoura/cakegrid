$(document).ready(function()
{
	if (typeof $("#flash") !== 'undefined')
	{
		$("#flash").delay(tempoFlash).promise().done(function()
		{
			$(this).slideUp('slow');
		})
	}

	$(".btn-aguarde").click(function()
	{
		txtAguarde = '<i class="fas fa-sync-alt" aria-hidden="true"></i>&nbsp;'+txtAguarde
		$(this).html(txtAguarde).prop('disabled', 'disabled').addClass('btn-bloqueado');
	})

	$(".btn-submit").click(function()
	{
		txtAguarde = '<i class="fas fa-sync-alt" aria-hidden="true"></i>&nbsp;'+txtAguarde
		$(this).html(txtAguarde).prop('disabled', 'disabled').addClass('btn-bloqueado')
		let idForm = $(this).closest("form").attr('id')
		$("#"+idForm).submit()
		return false;
	})
})