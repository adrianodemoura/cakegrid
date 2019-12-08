<?php

	echo $this->Html->script( ['usuarios/index'],	['block'=>true] );
	echo $this->Html->css( ['usuarios/index'], 		['block'=>true] );
	$Sessao = $this->request->getSession();

	$configFilter =
	[
		'fields' 	=>
		[
			'codigo' 	=> ['id'=>'filtroCodigo', 'name'=>'Usuarios.codigo','label'=>false, 'class'=>'form-control',      	'value'=>$Sessao->read($chave.'.Filtro.Usuarios_codigo'), 'placeholder'=>'-- código --'],
			'ativo' 	=> ['id'=>'filtroAtivo', 'name'=>'Usuarios.ativo',  'label'=>false, 'class'=>'form-control ml-1',   'value'=>$Sessao->read($chave.'.Filtro.Usuarios_ativo'), 'options'=>[0=>'Não', 1=>'Sim'], 'empty'=>'-- Ativo --'],
			'nome' 		=> ['id'=>'filtroNome',  'name'=>'Usuarios.nome',   'label'=>false, 'class'=>'form-control ml-1',	'value'=>$Sessao->read($chave.'.Filtro.Usuarios_nome'), 'placeholder'=>'-- nome --'],
			'municipio'	=> ['id'=>'filtroMunicipio','name'=>'Usuarios.municipio','label'=>false, 'class'=>'form-control selectpicker ml-1', 'data-live-search'=>true, 'value'=>$Sessao->read($chave.'.Filtro.Usuarios_municipio'), 'options'=>$listaMunicipios, 'empty'=>'-- Cidade --']
		]
	];

	$configTable =
	[
		'fields' 	=> ['id', 'nome', 'email', 'dativo', 'ultimo_acesso', 'cidade'],
		'schema' 	=> 
		[
			'id' 	=> ['title' => 'Código', 'sort'=>true, 'th'=>['class'=>'text-center'], 'td'=>['class'=>'text-center']],
			'nome' 	=> ['title' => 'Nome', 'sort'=>true],
			'email'	=> ['title' => 'e-mail'],
			'dativo'=> ['title' => 'Ativo', 'th'=>['class'=>'text-center'], 'td'=>['class'=>'text-center']],
			'ultimo_acesso'=> ['title' => 'Último Acesso', 'th'=>['class'=>'text-center'], 'td'=>['class'=>'text-center']],
			'cidade'=> ['title' => 'Cidade', 'th'=>['class'=>'text-center']],
		]
	];
?>

<div class="container bg-light">
	<h4>Usuários</h4>
</div>

<div class="container">

	<?= $this->element('Bootstrap.filter', ['config'=>$configFilter]); ?>

	<?= $this->element('Bootstrap.table',  ['config'=>$configTable]); ?>

</div>
