<?php

	echo $this->Html->script( ['painel/login'],	['block'=>true] );
	echo $this->Html->css( ['painel/login'], 	['block'=>true] );

	$optionsLogin = ['required'=>'required', 'label'=>false, 'autocomplete'=>'off', 'placeholder'=>'e-mail','name'=>'email', 'id'=>'inEmail', 'class'=>'form-control', 'autofocus'=>true, 'default'=>'admin@admin.com.br'];
	$optionsSenha = ['required'=>'required', 'label'=>false, 'autocomplete'=>'off', 'placeholder'=>'senha', 'name'=>'senha', 'id'=>'inSenha', 'class'=>'form-control', 'type'=>'password', 'default'=>'admin1234'];
	$optionsEnviar= ['name'=>'inEnviar', 'id'=>'btnEnviar', 'type'=>'submit', 'class'=>'btn btn-secondary btn-aguarde'];
	$optionsFechar= ['name'=>'inFechar', 'id'=>'btnFechar', 'type'=>'button', 'class'=>'btn btn-secondary btn-aguarde ml-3', 'label'=>false];

?>
<div class="d-flex vh-100">
 	<div class="d-flex w-100 justify-content-center align-self-center">

		<div class="col-4 rounded-lg fundo-escuro py-2 px-5">
			<?= $this->Form->create($LoginForm, ['class'=>'form']); ?>
			<div class="row mt-2">
				<?= $this->Form->control('email', $optionsLogin); ?>
			</div>

			<div class="row mt-2">
				<?= $this->Form->control('senha', $optionsSenha); ?>
			</div>

			<div class="row mt-3">
				<?= $this->Form->control('Enviar', $optionsEnviar); ?>
				<?= $this->Form->control('Fechar', $optionsFechar); ?>
			</div>

			<?= $this->Form->end(); ?>
		</div>

 	</div>
</div>
