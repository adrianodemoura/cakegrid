<?php
	$Sessao 		= $this->request->getSession();
	$listaPapeis 	= [];
	foreach($Sessao->read('Auth.User.Permissoes') as $_Papel => $_arrPermissoes) { $listaPapeis[$_Papel] = $_Papel;}

	$optionsPapeis = ['required'=>'required', 'label'=>['text'=>'Papel', 'class'=>'required'], 'name'=>'papel', 'id'=>'inPapel', 'class'=>'form-control', 'autofocus'=>true, 'options'=>$listaPapeis, 'default'=>$Sessao->read('Auth.User.PapelAtivo')];
	$optionsEnviar = ['name'=>'inEnviar', 'id'=>'btnEnviar', 'div'=>null, 'type'=>'submit', 'class'=>'btn btn-secondary btn-aguarde'];

?>

<div class="mh-100" style="height: 500px;">

	<div class="h-25 d-inline-block"></div>

	<div class="row">
		<div class="col-2"></div>

		<div class="col-8 rounded-lg border bg-light py-2 px-5">
		<?= $this->Form->create($EscolherPapelForm, ['class'=>'form']); ?>
			<div class="mt-2">
				<?= $this->Form->control('papel', $optionsPapeis); ?>
			</div>

			<div class="mt-3 row text-center">
				<?= $this->Form->control('Enviar', $optionsEnviar); ?>
			</div>
		<?= $this->Form->end(); ?>
		</div>

		<div class="col-2"></div>
</div>

</div>