<?php

	echo $this->Html->script( ['usuarios/login'],	['block'=>true] );
	echo $this->Html->css( ['usuarios/login'], 		['block'=>true] );

	$optionsLogin = ['required'=>'required', 'label'=>false, 'autocomplete'=>'off', 'placeholder'=>'e-mail','name'=>'email', 'id'=>'inEmail', 'class'=>'form-control', 'autofocus'=>true, 'default'=>'admin@admin.com.br'];
	$optionsSenha = ['required'=>'required', 'label'=>false, 'autocomplete'=>'off', 'placeholder'=>'senha', 'name'=>'senha', 'id'=>'inSenha', 'class'=>'form-control', 'type'=>'password', 'default'=>'admin1234'];
	$optionsEnviar= ['name'=>'inEnviar', 'id'=>'btnEnviar', 'div'=>null, 'type'=>'submit', 'class'=>'btn btn-secondary btn-aguarde'];
	$optionsFechar= ['name'=>'inFechar', 'id'=>'btnFechar', 'div'=>null, 'type'=>'button', 'class'=>'btn btn-secondary btn-aguarde ml-3', 'label'=>false];

?>

<div class="mh-100" style="height: 500px;">

	<div class="h-25 d-inline-block"></div>

	<div class="row">
		<div class="col-4"></div>

		<div class="col-4 rounded-lg bordered bg-info py-2 px-5">
		<?= $this->Form->create($LoginForm, ['class'=>'form']); ?>
			<div class="mt-2">
				<?= $this->Form->control('email', $optionsLogin); ?>
			</div>

			<div class="mt-2">
				<?= $this->Form->control('senha', $optionsSenha); ?>
			</div>

			<div class="mt-3">
				<div class="row">
					<div class="col-6 text-right">
						<?= $this->Form->control('Enviar', $optionsEnviar); ?>
					</div>
					<div class="col-6 text-left">
						<?= $this->Form->control('Fechar', $optionsFechar); ?>
					</div>
				</div>
			</div>
		<?= $this->Form->end(); ?>
		</div>

		<div class="col-2"></div>
</div>

</div>