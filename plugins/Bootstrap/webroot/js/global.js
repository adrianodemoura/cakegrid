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

	$(".btn-submit").click(function(e)
	{
		let tipoElemento = e.target.localName
		
		switch (tipoElemento)
		{
			case 'input':
				$(this).html(txtAguarde).prop('disabled', 'disabled').addClass('btn-bloqueado')
				this.form.submit()
				return false;
				break;
				
			case 'a':
				txtAguarde = '<i class="fas fa-sync-alt" aria-hidden="true"></i>&nbsp;'+txtAguarde
				$(this).html(txtAguarde).prop('disabled', 'disabled').addClass('btn-bloqueado')
				return true;
				break;
		}
	})
})