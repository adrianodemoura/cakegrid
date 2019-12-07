$(document).ready(function()
{
	if (typeof $("#flash") !== 'undefined')
	{
		$("#flash").delay(tempoFlash).promise().done(function()
		{
			$(this).slideUp('slow');
		})
	}

	$(".btn-submit").click(function(e)
	{
		$(this).closest("form").submit()
	})

	$(".btn-aguarde").click(function(e)
	{
		let tipoElemento = e.target.localName

		switch (tipoElemento)
		{
			case 'input':
				$(this).val(txtAguarde).prop('disabled', 'disabled').addClass('btn-bloqueado')
				this.form.submit()
				return false
				break;
				
			case 'a':
				if ( !$(this).hasClass('btn-bloqueado') )
				{
					$(this).html('<i class="fas fa-sync-alt" aria-hidden="true"></i>&nbsp;'+txtAguarde).addClass('btn-bloqueado')
				} else
				{
					console.log('aguarde o carregamento da página !')
					return false
				}
				break;
		}
	})
})