<?php
	$Sessao 		= $this->request->getSession();
	$listaPapeis 	= [];
	foreach($Sessao->read('Auth.User.Permissoes') as $_Papel => $_arrPermissoes) { $listaPapeis[$_Papel] = $_Papel;}

	$optionsPapeis = ['name'=>'papel',    'id'=>'inPapel',  'type'=>'select',  'class'=>'form-control', 'required'=>'required', 'label'=>['text'=>'PAPEL: Perfil - Unidade', 'class'=>'required'], 'autofocus'=>true, 'options'=>$listaPapeis, 'default'=>$Sessao->read('Auth.User.PapelAtivo')];
	$optionsEnviar = ['name'=>'inEnviar', 'id'=>'btnEnviar', 'type'=>'submit', 'class'=>'btn btn-secondary btn-submit mx-3', 'placeholder'=>'&#xf075;'];

?>

<div class="mh-100" style="height: 500px;">

	<div class="h-25 d-inline-block"></div>

	<div class="row">
		<div class="col-2"></div>

		<div class="col-8 rounded-lg border bg-light py-2 px-5">
		<?= $this->Form->create($FormTrocarPapel, ['url'=>['action'=>'trocar-papel']]); ?>
			<div class="mt-2">
				<?= $this->Form->control('papel', $optionsPapeis); ?>
			</div>

			<div class="mt-3 row text-center">
				<?= $this->Form->control('Enviar', $optionsEnviar); ?>
			</div>

		<?= $this->Form->end(); ?>
		</div>

		<div class="col-2">
		</div>
</div>

</div>