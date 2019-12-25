<?php

echo $this->Html->script( ['auditorias/index'],	['block'=>true] );
echo $this->Html->css( ['auditorias/index'], 	['block'=>true] );

?>

<div class="container bg-light">
	<h4>Auditoria</h4>
</div>

<div class="container">

	<?= $this->element('Bootstrap.filter'); ?>

	<?= $this->element('Bootstrap.table'); ?>

</div>