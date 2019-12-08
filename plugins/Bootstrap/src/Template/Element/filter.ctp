<?php
use Cake\Utility\Inflector;
$totalFiltros = $this->request->getParam('totalFiltros');

$config['btnFiltrar']	= isset($config['btnFiltrar'])  ? $config['btnFiltrar']     : ['id'=>'btnFiltrar','name'=>'btnFiltrar', 'escape'=>false, 'class'=>'btn btn-primary btn-aguarde btn-submit'];
$config['btnLimpar']	= isset($config['btnLimpar'])   ? $config['btnLimpar']      : ['id'=>'btnLimpar', 'name'=>'btnLimpar',  'escape'=>false, 'class'=>'btn btn-primary btn-aguarde'];
$config['url']          = isset($config['url'])         ? $config['url']            : $this->Url->build('/', true).'/'.Inflector::dasherize($this->request->getParam('controller')).'/index';
$config['fields']       = isset($config['fields'])      ? $config['fields']         : [];

if ( count($config['fields']) ) :
?>
<div class="container border my-3">
<?= $this->Form->create('FormFiltro', ['id'=>'FormFiltro', 'url'=>$config['url'], 'class'=>'form', 'templates'=>'Bootstrap.input-filter-template']); ?>
    <div class="row py-2">
        <div class="col-8">
            <div class="input-group">
                <?php foreach($config['fields'] as $_field => $_arrOptions) : ?>
                <?= $this->Form->control($_field, $_arrOptions); ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-4 text-right">
            <?= $this->Html->link('<i class="fas fa-search"></i>&nbsp;' . __('Filtrar'),$config['url'], $config['btnFiltrar']); ?>
            <?php if ( $totalFiltros>0 ) : ?>
            <?= $this->Html->link('<i class="fas fa-trash"></i>&nbsp;'  . __('Limpar').' ('.$totalFiltros.')', $config['url'].'/limpar', $config['btnLimpar']); ?>
            <?php endif; ?>
        </div>
    </div>
<?= $this->Form->end(); ?>
</div>
<?php endif; ?>