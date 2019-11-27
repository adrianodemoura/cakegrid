<?php
	//echo $this->Html->script( ['usuarios/info'],	['block'=>true] );
	//echo $this->Html->css( ['usuarios/infos'], 		['block'=>true] );
	$Sessao = $this->request->getSession();
	$listaSimNao = [0=>'Não', 1=>'Sim'];
?>


<div class="container bg-light">
	<h4>Usuários - Informações</h4>
</div>

<div class="container">
	<dl class="row mt-3 mb-0">
		<dt class="col-3 px-1 text-md-right">Nome:</dt>
		<dd class="col-9 px-1"><?= $Sessao->read('Auth.User.nome'); ?>
	</dl>

	<dl class="row my-0">
		<dt class="col-3 px-1 text-right">e-mail:</dt>
		<dd class="col-9 px-1"><?= $Sessao->read('Auth.User.email'); ?>
	</dl>

	<dl class="row my-0">
		<dt class="col-3 px-1 text-right">Último Acesso:</dt>
		<dd class="col-9 px-1"><?= $Sessao->read('Auth.User.ultimo_acesso'); ?>
	</dl>
	<dl class="row my-0">
		<dt class="col-3 px-1 text-right">Ativo:</dt>
		<dd class="col-9 px-1"><?= $listaSimNao[$Sessao->read('Auth.User.ativo')]; ?>
	</dl>
</div>
