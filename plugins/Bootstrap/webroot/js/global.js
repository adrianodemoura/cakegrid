$(document).ready(function()
{
	if (typeof $("#flash") !== 'undefined')
	{
		$("#flash").delay(tempoFlash).promise().done(function()
		{
			$(this).slideUp('slow');
		})
	}

	$('.form-aguarde').submit(function()
	{
		$(this).find(':submit').val(txtAguarde).prop('disabled', 'disabled').addClass('btn-bloqueado')
	})

	$(".btn-aguarde").click(function(e)
	{
		let tipoElemento = e.target.localName

		switch (tipoElemento)
		{		
			case 'a':
			case 'i':
				if ( !$(this).hasClass('btn-bloqueado') )
				{
					let htmlAntigo = $(this).html();
					$(this).html('<i class="fas fa-sync-alt" aria-hidden="true"></i>&nbsp;'+txtAguarde).addClass('btn-bloqueado')
					if ( $(this).hasClass('btn-submit') )
					{
						$(this).closest("form").submit()
						return false
					} else if ( $(this).hasClass('btn-exportar') )
					{
						$(this).delay(1000).promise().done(function()
						{
							$(this).removeClass('btn-bloqueado').html(htmlAntigo);
						})
						return true;
					} else
					{
						return true;
					}
				} else
				{
					console.log('aguarde o carregamento da página !')
					return false
				}
				break;
		}
	})
})