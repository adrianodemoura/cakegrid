<?php

echo $this->Html->script( ['auditorias/index'],	['block'=>true] );
echo $this->Html->css( ['auditorias/index'], 	['block'=>true] );
$Sessao = $this->request->getSession();

$configFilter =
[
	'fields' 	=>
	[
		'descricao'	=> ['id'=>'filtroDescricao',  'name'=>'Auditorias.descricao', 'label'=>false, 'class'=>'form-control mx-2', 'value'=>$Sessao->read($chave.'.Filtro.Auditorias_descricao'), 'placeholder'=>'-- descrição --'],
		'ip'		=> ['id'=>'filtroIp',  'name'=>'Auditorias.ip', 'label'=>false, 'class'=>'form-control mx-2', 'value'=>$Sessao->read($chave.'.Filtro.Auditorias_ip'), 'placeholder'=>'-- ip --']
	]
];

$configTable =
[
	'fields' 	=> ['id', 'motivo', 'ip', 'descricao', 'data', 'nome_usuario'],
	'schema' 	=>
	[
		'id' 			=> ['title'=>'Código', 'sort'=>true],
		'descricao' 	=> ['title'=>'Descrição'],
		'ip' 			=> ['title'=>'Ip'],
		'nome_usuario' 	=> ['title'=>'Usuário']
	]
];

?>

<div class="container bg-light">
	<h4>Auditoria</h4>
</div>

<div class="container">

	<?= $this->element('Bootstrap.filter', ['config'=>$configFilter]); ?>

	<?= $this->element('Bootstrap.table',  ['config'=>$configTable] ); ?>

</div>