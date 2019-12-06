<?php
	//echo $this->Html->script( ['municipios/index'],	['block'=>true] );
	//echo $this->Html->css( ['municipios/index'], 	['block'=>true] );
	$optionsFechar 	= ['id'=>'btnFechar','name'=>'btnFechar', 'escape'=>false, 'class'=>'btn btn-secondary btn-aguarde'];
	$paginacao 	= $this->request->getParam('paging')['Municipios'];
?>

<div class="container bg-light">
	<h4>Municípios</h4>
</div>

<div class="container">
	<table class='table table-striped table-bordered table-sm'>
		<thead>
			<tr>
				<th class='text-center' width="100px">
					<?= $this->Paginator->sort('nome', _('Código')); ?>
				</th>
				<th class='text-center' width="460px">
					<?= $this->Paginator->sort('nome', _('Município')); ?>
				</th>
				<th class='text-center'>UF</th>
				<th class='text-center'>Estado</th>
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
