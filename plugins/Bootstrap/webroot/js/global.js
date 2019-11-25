$(document).ready(function()
{
	if (typeof $("#flash") !== 'undefined')
	{
		$("#flash").delay(tempoFlash).promise().done(function()
		{
			$(this).slideUp('slow');
		})
	}

	$(".form").submit(function()
	{
		let $focado = $(':focus');
		$($focado).val(txtAguarde).prop('disabled', 'disabled');
	})
})