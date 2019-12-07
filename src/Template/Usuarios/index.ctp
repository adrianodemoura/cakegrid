<?php

	echo $this->Html->script( ['usuarios/index'],	['block'=>true] );
	echo $this->Html->css( ['usuarios/index'], 		['block'=>true] );

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

	<?= $this->element('Bootstrap.table',  ['config'=>$configTable]); ?>

</div>
