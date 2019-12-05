<?php
	$tituloPagina = isset($tituloPagina) ? $tituloPagina : SISTEMA . ' :: '.$this->request->getParam('controller'); 
    $varJs['SISTEMA']   = "'".SISTEMA."'";
    $varJs['IP']        = "'".IP."'";
    $varJs['BASE']      = "'".$this->Url->build('/', true)."'";
    $varJs['URL']       = "'".$this->Url->build(null, true)."'";
    $varJs['tempoFlash']= isset($tempoFlash) ? $tempoFlash : 3000;
    $varJs['txtAguarde']= isset($txtAguarde) ? $txtAguarde : "'Aguarde ...'";
    $aqui = "plugin / controller / action";
    $aqui = str_replace('plugin /', $this->request->getParam('plugin'), $aqui);
    $aqui = str_replace('controller', $this->request->getParam('controller'), $aqui);
    $aqui = str_replace('action', $this->request->getParam('action'), $aqui);
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

	<div id="flash" class="container">
    	<?= $this->Flash->render() ?>

    </div><!-- fim flash -->

    <div id="cabecalho" class="container bg-white py-2 rounded-bottom shadow bottom">
        <div class="row">
            <div class="col-10">
                <span class="font-weight-bold">Usuário:</span> <?= $this->Html->link($this->request->getSession()->read('Auth.User.nome'), '/painel/info'); ?>
                <span class="mx-2">|</span>
                <span class="font-weight-bold">Papel:</span> <?= $this->Html->link($this->request->getSession()->read('Auth.User.PapelAtivo'), '/painel/escolher-papel'); ?>
            </div>
            <div class="col-2 text-right">
                <?= $this->Html->link('sair', '/logout'); ?>
            </div>
        </div>
    </div>

    <div id="menu" class="container rounded-top mt-3">
        <div class="row">
            <div class="col-8">
    	       <?= $this->element('menu'); ?>
           </div>
           <div class="col-4 mt-2 text-right">
                <small class="font-italic">Você está aqui: <?= $aqui; ?></small>
           </div>
        </div>
    </div>

    <div id="conteudo" class="container bg-white p-2 shadow left shadow right">
        <?= $this->fetch('content') ?>

    </div><!-- fim conteudo -->

    <div id="rodape" class="container rounded-bottom py-2 shadow bottom">
        <div class="row">
            <div class="col-6">
                <?= SISTEMA; ?>
            </div>

            <div class="col-6 text-right">
                <?= date('d/m/Y H:i'); ?>
            </div>
        </div>
    </div>

</div><!-- fim corpo -->

</body>
</html>