<?php
	//echo $this->Html->script( ['municipios/index'],	['block'=>true] );
	//echo $this->Html->css( ['municipios/index'], 	['block'=>true] );
	$Sessao 				= $this->request->getSession();

	$configFilter =
	[
		'fields' 	=>
		[
			'estado' 	=> ['id'=>'filtroEstado','name'=>'Municipios.estado',  'label'=>false, 'class'=>'form-control',      'value'=>$Sessao->read($chave.'.Filtro.Municipios_estado'), 'options'=>$listaEstado, 'empty'=>'-- Estado --'],
			'nome' 		=> ['id'=>'filtroNome',  'name'=>'Municipios.nome',    'label'=>false, 'class'=>'form-control mx-2', 'value'=>$Sessao->read($chave.'.Filtro.Municipios_nome'), 'placeholder'=>'-- nome --']
		]
	];

	$configTable =
	[
		'modelClass' 	=> $modelClass,
		'dados' 		=> $dados,
		'paginacao' 	=> $this->request->getParam('paging')[$modelClass],
		'fields' 		=> ['id', 'nome', 'uf', 'desc_estd', 'codi_estd'],
		'schema' 		=> 
		[
			'id' 		=> ['title'=>'Código', 'sort'=>true, 'th'=>['class'=>'text-center', 'width'=>'90px'], 'td'=>['class'=>'text-center']],
			'nome' 		=> ['title'=>'Nome', 'th'=>['class'=>'text-center'], 'sort'=>true],
			'uf' 		=> ['title'=>'Uf', 'th'=>['class'=>'text-center', 'width'=>'50px'], 'td'=>['class'=>'text-center']],
			'desc_estd'	=> ['title'=>'Estado', 'th'=>['class'=>'text-center', 'width'=>'190px']],
			'codi_estd'	=> ['title'=>'Código Estado', 'th'=>['class'=>'text-center', 'width'=>'140px'], 'td'=>['class'=>'text-center']]
		],
	];
?>

<div class="container bg-light">
	<h4>Municípios</h4>
</div>

<div class="container">
	
	<?= $this->element('Bootstrap.filter', ['config'=>$configFilter]); ?>

	<?= $this->element('Bootstrap.table',  ['config'=>$configTable]); ?>

</div>
