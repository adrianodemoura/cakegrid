<?php
	$tituloPagina = isset($tituloPagina)
		? $tituloPagina 
		: SISTEMA . ' :: '.$this->request->getParam('controller'); 
	$varJs['SISTEMA'] 	= "'".SISTEMA."'";
	$varJs['BASE'] 		= "'".$this->Url->build('/', true)."'";
    $varJs['URL']       = "'".$this->Url->build(null, true)."'";
    $varJs['tempoFlash']= isset($tempoFlash) ? $tempoFlash : 3000;
    $varJs['txtAguarde']= isset($txtAguarde) ? $txtAguarde : "'Aguarde ...'";
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?= $tituloPagina; ?></title>
    
    <?= $this->Html->meta('icon') ?>

<?php if ( isset($varJs) ) : ?>
    <script>
    <?php foreach($varJs as $_var => $_vlr) : ?>
    <?php echo "var $_var = $_vlr;"; ?>  
    <?php endforeach; ?>

    </script>
<?php endif; ?>

    <?= $this->Html->css(['bootstrap.4.3.1.min', 'global', 'publico']) ?>
    <?= $this->Html->script(['jquery-3.4.1.min', 'global', 'publico']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>

<body>

<div id="corpo" class="container bg-faded">

	<div id="flash" class="container">
    	<?= $this->Flash->render() ?>

    </div><!-- fim flash -->

    <div id="conteudo" class="container">
        <?= $this->fetch('content') ?>

    </div><!-- fim conteudo -->

</div><!-- fim corpo -->

</body>
</html>