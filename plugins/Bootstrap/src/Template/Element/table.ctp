<?php
    echo $this->Html->css( ['Bootstrap.table'], 	['block'=>true] );

    $fields     = $this->Schema->fields();
    $modelClass = $this->request->getParam('modelClass');
    $paginacao  = $this->request->getParam('paging')[$modelClass];
?>

<div class='row-container div-table'>
    <table class='table table-striped table-bordered table-sm'>
        <thead>
            <tr>
                <?php foreach($fields as $_field => $_arrProp) : if ( !@$_arrProp['table'] ) continue;
                    $th     = isset($_arrProp['th'])              ? $_arrProp['th'] : null;
                    $title  = isset($_arrProp['title'])           ? $_arrProp['title'] : $_field;
                    $thHtml = $title;
                    if ( isset($_arrProp['order']) ) { $thHtml = $this->Paginator->sort($_field, $title); }
                ?>

                <th <?php if ( isset($th) ) { foreach($th as $_tag => $_vlr) { echo "$_tag='$_vlr' "; }} ?>>
                    <?= $thHtml; ?>
                </th>

                <?php endforeach; ?>
            </tr>
        </thead>

        <tbody>
            <?php foreach( $this->request->getParam('data') as $_l => $_Entity ) : ?>
                <tr>
                    <?php 
                        foreach($fields as $_field => $_arrProp) : if ( !@$_arrProp['table'] ) continue;
                        $td     = isset($_arrProp['td']) ? $_arrProp['td'] : null;
                        $field  = str_replace($modelClass.'.','',$_field);
                        $vlr    = $_Entity->$field;

                        // recuperando campos belongsTo
                        if ( strpos($field,'.')>-1 )
                        {
                            $arrField   = explode( '.', strtolower($field) );
                            $vlr        = $_Entity[$arrField[0]][$arrField[1]];
                        }

                        // recuperando campos hasMany
                    ?>

                    <td <?php if ( isset($td) ) { foreach($td as $_tag => $_vlr) { echo "$_tag='$_vlr' "; }} ?>>
                        <?= $vlr ?>
                    </td>

                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class='row-container border-top py-1'>
    <div class='row'>
    <div class='col-9'>
        <?php if ( $paginacao ) : ?>
            <ul class="pagination small">
                <?php echo $this->Paginator->numbers(['templates'=>'Bootstrap.paginator-template']);?>
            </ul>
        <?php endif; ?>
    </div>

    <div class='col-3 text-right font-italic pt-2'>
        exibindo <?= @$paginacao['current'] ?> de <?= @$this->Number->format($paginacao['count']) ?>
    </div>
    </div>
</div>