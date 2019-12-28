<?php

$this->loadHelper('Bootstrap.Schema', ['schema'=>$schema]);

echo $this->Html->script( ['auditorias/index'],	['block'=>true] );
echo $this->Html->css( ['auditorias/index'], 	['block'=>true] );

$this->Schema->set('Auditorias.id.th', ['width'=>'80px']);
$this->Schema->set('Auditorias.id.td', ['class'=>'text-center']);
$this->Schema->set('Auditorias.ip.td', ['class'=>'text-center']);

?>

<div class="container bg-light">
	<h4>Auditoria</h4>
</div>

<div class="container">

	<?= $this->element('Bootstrap.filter'); ?>

	<?= $this->element('Bootstrap.table'); ?>

</div>