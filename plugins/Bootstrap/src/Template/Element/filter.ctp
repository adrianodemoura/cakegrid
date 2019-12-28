<?php
use Cake\Utility\Inflector;
$modelClass     = $this->request->getParam('modelClass');
$chave          = $this->request->getParam('chave');
$schema         = $this->Schema->fields();
$filterFields   = $this->request->getParam('filterFields');
$filterStatics  = @$this->request->getParam('filterStatics');
$totalRegs      = $this->request->getParam('paging')[$modelClass]['count'];
$Sessao         = $this->request->getSession();
$totalFilters   = $Sessao->read($chave.'.totalFiltros');

$config['btnFiltrar']	= isset($config['btnFiltrar'])  ? $config['btnFiltrar']   : ['id'=>'btnFiltrar','name'=>'btnFiltrar', 'escape'=>false, 'class'=>'btn btn-primary btn-sm btn-aguarde btn-submit'];
$config['btnLimpar']	= isset($config['btnLimpar'])   ? $config['btnLimpar']    : ['id'=>'btnLimpar', 'name'=>'btnLimpar',  'escape'=>false, 'class'=>'btn btn-primary btn-sm btn-aguarde', 'title'=>__('Limpar '. $this->Number->format($totalFilters) .' filtro(s) ...')];
$config['btnExportar']	= isset($config['btnExportar']) ? $config['btnExportar']  : ['id'=>'btnExportar','name'=>'btnExportar','escape'=>false,'class'=>'btn btn-primary btn-sm btn-aguarde btn-exportar', 'title'=>__('Exportar '. $this->Number->format($totalRegs).' registro(s) ...')];
$config['url']          = isset($config['url'])         ? $config['url']          : $this->Url->build('/', true).'/'.Inflector::dasherize($this->request->getParam('controller')).'/index';
$config['fields']       = isset($config['fields'])      ? $config['fields']       : [];

?>
<div class="div-form-filter container border my-3">
<?= $this->Form->create('FormFiltro', ['id'=>'FormFiltro', 'url'=>$config['url'], 'class'=>'form', 'templates'=>'Bootstrap.input-filter-template']); ?>
    <div class="row py-2">
        <div class="col-7">
            <div class="input-group">
            <?php
                foreach($filterFields as $_l => $_field) : 
                    if ( !@$schema[$_field]['filter'] ) continue; 
                    $field      = Inflector::camelize(str_replace('.','_',$_field));
                    $title      = isset($schema[$_field]['title']) ? $schema[$_field]['title'] : $field;
                    $arrOptions = ['id'=>'Filter'.$field, 'name'=>$field, 'label'=>false, 'class'=>'form-control ml-1', 'placeholder'=>'--'.$title.' --', 'title'=>$title, 'value'=>$Sessao->read($chave.'.filtros.'.$field)];
                    if ( isset($filterStatics[$field]) ) $arrOptions['readonly'] = 'readonly';

                    echo $this->Form->control($_field, $arrOptions);
                endforeach;
            ?>
            </div>
        </div>

        <div class="col-5 text-right mt-1">
            <?= $this->Html->link('<i class="fas fa-search"></i>&nbsp;' . __('Filtrar'),$config['url'], $config['btnFiltrar']); ?>
            <?php if ( $totalRegs>0 ) : ?>
            <?= $this->Html->link('<i class="fas fa-file-csv"></i>&nbsp;'  . __('Exportar').' ('. $this->Number->format($totalRegs) .')', $config['url'].'/exportar', $config['btnExportar']); ?>
            <?php endif; ?>
            <?php if ( $totalFilters>0 ) : ?>
            <?= $this->Html->link('<i class="fas fa-trash"></i>&nbsp;'  . __('Limpar').' ('.$totalFilters.')', $config['url'].'/limpar', $config['btnLimpar']); ?>
            <?php endif; ?>
        </div>
    </div>
<?= $this->Form->end(); ?>
</div>