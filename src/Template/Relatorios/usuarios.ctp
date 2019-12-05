<?php
	echo $this->Html->script( ['relatorios/usuarios'],	['block'=>true] );
	echo $this->Html->css( ['relatorios/usuarios'],		['block'=>true] );
	$optionsExportar 	= ['id'=>'btnExportar', 'name'=>'btnExportar', 	'escape'=>false, 'class'=>'btn btn-primary  btn-wait-download'];
	$optionsFechar 		= ['id'=>'btnFechar', 	'name'=>'btnFechar', 	'escape'=>false, 'class'=>'btn btn-secondary btn-wait'];
?>

<div class="container bg-light">
	<h4>Relatório de Usuários</h4>
</div>

<div class="container">
	<table class='table table-striped'>
		<thead>
			<tr>
				<th>#</th>
				<th>Nome</th>
				<th>e-mail</th>
			</tr>
		</thead>
	</table>
</div>

<div class="container">
	
	<?= $this->Html->link('<i class="fas fa-file-csv"></i>&nbsp;'  . __('Exportar'), ['action'=>'/usuarios/exportar'], $optionsExportar); ?>
	<?= $this->Html->link('<i class="fas fa-arrow-alt-circle-left"></i>&nbsp;'  . __('Fechar'), ['action'=>'/relatorios/index'], $optionsFechar); ?>
	
</div>