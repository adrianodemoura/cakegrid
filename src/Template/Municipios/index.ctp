<?php
	//echo $this->Html->script( ['municipios/index'],	['block'=>true] );
	//echo $this->Html->css( ['municipios/index'], 	['block'=>true] );
	$Sessao 				= $this->request->getSession();
	$optionsFiltroEstado 	= ['id'=>'filtroEstado','name'=>'Municipios.estado',  'label'=>false, 'class'=>'form-control', 'options'=>$listaEstado, 'empty'=>'-- Estado --', 'value'=>$Sessao->read($chave.'.Filtro.Municipios_estado')];
	$optionsFiltroNome 		= ['id'=>'filtroNome', 'name'=>'Municipios.nome', 'label'=>false, 'class'=>'form-control mx-2', 'value'=>$Sessao->read($chave.'.Filtro.Municipios_nome'), 'placeholder'=>'-- nome --'];
	$optionsFiltrar			= ['id'=>'btnFiltrar','name'=>'btnFiltrar', 'escape'=>false, 'class'=>'btn btn-primary btn-submit'];
	$optionsLimpar 			= ['id'=>'btnLimpar', 'name'=>'btnLimpar',  'escape'=>false, 'class'=>'btn btn-primary btn-aguarde'];
	$paginacao 				= $this->request->getParam('paging')[$modelClass];

	$configTable =
	[
		'modelClass' 	=> $modelClass,
		'dados' 		=> $dados,
		'paginacao' 	=> $this->request->getParam('paging')[$modelClass],
		'fieldsTable' 	=> ['id', 'nome', 'uf', 'desc_estd', 'codi_estd'],
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
	<div class="container border my-3">
	<?= $this->Form->create('FormFiltro', ['id'=>'FormFiltro', 'url'=>['action'=>'index'], 'class'=>'form', 'templates'=>'Bootstrap.input-filter-template']); ?>
		<div class="row py-2">
			<div class="col-8">
				<div class="input-group">
					<?= $this->Form->control('estado', $optionsFiltroEstado); ?>
					<?= $this->Form->control('nome', $optionsFiltroNome); ?>
				</div>
			</div>

			<div class="col-4 text-right">
				<?= $this->Html->link('<i class="fas fa-search"></i>&nbsp;' . __('Filtrar'),'/municipios/index', $optionsFiltrar); ?>
				<?= $this->Html->link('<i class="fas fa-trash"></i>&nbsp;'  . __('Limpar'), '/municipios/index/limpar', $optionsLimpar); ?>
			</div>
		</div>
	<?= $this->Form->end(); ?>
	</div>
	
	

	<?= $this->element('Bootstrap.table', ['config'=>$configTable]); ?>

</div>
