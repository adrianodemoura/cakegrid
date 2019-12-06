<?php
	//echo $this->Html->script( ['municipios/index'],	['block'=>true] );
	//echo $this->Html->css( ['municipios/index'], 	['block'=>true] );
	$Sessao = $this->request->getSession();

	$optionsFiltroEstado 	= ['id'=>'filtroEstado','name'=>'Municipios.estado',  'label'=>false, 'class'=>'form-control', 'options'=>$listaEstado, 'empty'=>'-- Estado --', 'value'=>$Sessao->read($chave.'.Filtro.Municipios_estado')];
	$optionsFiltrar 		= ['id'=>'btnFiltrar','name'=>'btnFiltrar', 'type'=>'submit', 'class'=>'btn btn-primary btn-aguarde', 'inputContainer'=>'{{content}}'];
	$optionsLimpar 			= ['id'=>'btnLimpar', 'name'=>'btnLimpar', 'escape'=>false, 'class'=>'btn btn-primary btn-aguarde'];
	$paginacao 				= $this->request->getParam('paging')['Municipios'];
?>

<div class="container bg-light">
	<h4>Municípios</h4>
</div>

<div class="container">
	<div class="container border my-3">
	<?= $this->Form->create('FiltroMunicipios', ['class'=>'form', 'inputContainer'=>'{{content}}']); ?>
		<div class="row py-2">
			<div class="col-3">
				<?= $this->Form->control('estado', $optionsFiltroEstado); ?>
			</div>

			<div class="col-5">
			</div>

			<div class="col-4 text-right">
				<?= $this->Form->control('Filtrar', $optionsFiltrar); ?>
				<?= $this->Html->link('<i class="fas fa-trash"></i>&nbsp;'  . __('Limpar'), '/municipios/index/limpar', $optionsLimpar); ?>
			</div>
		</div>
	<?= $this->Form->end(); ?>
	</div>
	
	<table class='table table-striped table-bordered table-sm'>
		<thead>
			<tr>
				<th class='text-center' width="100px">
					<?= $this->Paginator->sort('nome', _('Código')); ?>
				</th>
				<th class='text-center'>
					<?= $this->Paginator->sort('nome', _('Município')); ?>
				</th>
				<th class='text-center' width="50px">UF</th>
				<th class='text-center' width="220px">Estado</th>
				<th class='text-center' width="120px">Cód. Estado</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($dados as $_l => $_objMunicipio) : ?>
				<tr>
					<td class='tdId text-center'> 		<?= @$_objMunicipio->id ?> </td>
					<td class='tdNome'> 	<?= @$_objMunicipio->nome ?> </td>
					<td class='tdUf text-center'> 		<?= @$_objMunicipio->uf ?> </td>
					<td class='tdDescEstd text-left'> <?= @$_objMunicipio->desc_estd ?> </td>
					<td class='tdCodiEstd text-center'> <?= @$_objMunicipio->codi_estd ?> </td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class='row border-top py-1'>
		<div class='col-9'>
			<nav aria-label="Page navigation example">
  				<ul class="pagination small">
					<?= $this->Paginator->numbers(['templates'=>'Bootstrap.paginator-template']);?>
				</ul>
			</nav>
		</div>

		<div class='col-3 text-right font-italic pt-2'>
			exibindo <?= $paginacao['current'] ?> de <?= $this->Number->format($paginacao['count']) ?>
		</div>

	</div>
</div>
