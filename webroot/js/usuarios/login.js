$(document).ready(function()
{
	$("#btnFechar").click(function()
	{
		$(this).text(txtAguarde).prop('disabled', 'disabled')

		document.location.href = BASE
	})
})