<?php
	echo $this->Html->script( ['relatorios/usuarios'],	['block'=>true] );
	echo $this->Html->css( ['relatorios/usuarios'],		['block'=>true] );
	$optionsExportar 	= ['id'=>'btnExportar', 'name'=>'btnExportar', 	'escape'=>false, 'class'=>'btn btn-primary   btn-aguarde-download'];
	$optionsFechar 		= ['id'=>'btnFechar', 	'name'=>'btnFechar', 	'escape'=>false, 'class'=>'btn btn-secondary btn-aguarde'];
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
				<th>Ativo</th>
				<th>Último Acesso</th>
				<th>Município</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($this->request->data as $_l => $_arrUsuarios) : ?>
				<tr>
					<td>00</td>
					<td class='tdNome'> <?= @$_arrUsuarios->nome ?> </td>
					<td class='tdEmail'> <?= @$_arrUsuarios->email ?> </td>
					<td class='tdDativo'> <?= @$_arrUsuarios->dativo ?> </td>
					<td class='tdUltimoAcesso'> <?= @$_arrUsuarios->ultimo_acesso ?> </td>
					<td class='tdMunicipio'> <?= @$_arrUsuarios->municipio ?> </td>
				</tr>
			<?php endforeach; ?>
		</tbody>

	</table>
</div>

<div class="container">
	
	<?= $this->Html->link('<i class="fas fa-file-csv"></i>&nbsp;'  . __('Exportar'), '/relatorios/usuarios/exportar', $optionsExportar); ?>
	<?= $this->Html->link('<i class="fas fa-arrow-alt-circle-left"></i>&nbsp;'  . __('Fechar'), ['action'=>'index'], $optionsFechar); ?>
	
</div>