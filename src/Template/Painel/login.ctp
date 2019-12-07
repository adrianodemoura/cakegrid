<?php

	echo $this->Html->script( ['painel/login'],		['block'=>true] );
	echo $this->Html->css( ['painel/login'], 		['block'=>true] );

	$optionsLogin = ['required'=>'required', 'label'=>false, 'autocomplete'=>'off', 'placeholder'=>'e-mail','name'=>'email', 'id'=>'inEmail', 'class'=>'form-control', 'autofocus'=>true, 'default'=>'admin@admin.com.br'];
	$optionsSenha = ['required'=>'required', 'label'=>false, 'autocomplete'=>'off', 'placeholder'=>'senha', 'name'=>'senha', 'id'=>'inSenha', 'class'=>'form-control', 'type'=>'password', 'default'=>'admin1234'];
	$optionsEnviar= ['name'=>'inEnviar', 'id'=>'btnEnviar', 'div'=>null, 'type'=>'submit', 'class'=>'btn btn-primary btn-submit'];
?>

<div class="mh-100" style="height: 500px;">

	<div class="h-25 d-inline-block"></div>

	<div class="row">
		<div class="col-4"></div>

		<div class="col-4 rounded-lg bordered bg-info py-2 px-5">
		<?= $this->Form->create($LoginForm, ['id'=>'LoginForm', 'url'=>['action'=>'login']]); ?>
			<div class="mt-2">
				<?= $this->Form->control('email', $optionsLogin); ?>
			</div>

			<div class="mt-2">
				<?= $this->Form->control('senha', $optionsSenha); ?>
			</div>

			<div class="mt-3">
				<div class="row">
					<?= $this->Form->control('Enviar', $optionsEnviar); ?>
				</div>
			</div>
		<?= $this->Form->end(); ?>
		</div>

		<div class="col-2"></div>
</div>

</div>