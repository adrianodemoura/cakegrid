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

    <div id="cabecalho" class="row fundo-escuro py-1 rounded-bottom">
        <div class="col-6">
            <?= $this->Html->link($this->request->getSession()->read('Auth.User.email'), '/usuarios/info'); ?>
        </div>
        <div class="col-6 text-right">
            <?= $this->Html->link('sair', '/usuarios/logout'); ?>
        </div>

    </div>

    <div id="menu" class="row fundo-claro">
    	<?= $this->element('menu'); ?>
    </div>

    <div id="conteudo" class="row border p-2">
        <?= $this->fetch('content') ?>

    </div><!-- fim conteudo -->

    <div id="rodape" class="row fundo-claro py-2">
        <div class="col-6">
            <?= SISTEMA; ?>
        </div>

        <div class="col-6 text-right">
            <?= date('d/m/Y H:i'); ?>
        </div>
    </div>

</div><!-- fim corpo -->

</body>
</html>