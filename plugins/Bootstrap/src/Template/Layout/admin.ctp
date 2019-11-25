<?php
	$tituloPagina = isset($tituloPagina)
        ? $tituloPagina 
        : SISTEMA . ' :: '.$this->request->getParam('controller'); 
    $varJs['SISTEMA']   = "'".SISTEMA."'";
    $varJs['BASE']      = "'".$this->Url->build('/', true)."'";
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

    <?= $this->Html->css(['bootstrap.4.3.1.min', 'global', 'admin']) ?>
    <?= $this->Html->script(['jquery-3.4.1.min', 'bootstrap.4.3.1.min', 'global', 'admin']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>

<body>

<div id="corpo" class="container">

	<div id="flash" class="row">
    	<?= $this->Flash->render() ?>

    </div><!-- fim flash -->

    <div id="cabecalho" class="row fundo-escuro py-1">
        <div class="col-6">
        </div>
        <div class="col-6 text-right">
            <?= $this->Html->link('Sair', '/usuarios/logout'); ?>
        </div>

    </div>

    <div id="menu" class="row">
    	<?= $this->element('menu'); ?>
    </div>

    <div id="conteudo" class="row">
        <?= $this->fetch('content') ?>

    </div><!-- fim conteudo -->

    <div id="rodape" class="row fundo-claro py-2">
        <div class="col-6">

        </div>

        <div class="col-6 text-right">
            <?= SISTEMA; ?>
        </div>
    </div>

</div><!-- fim corpo -->

</body>
</html>