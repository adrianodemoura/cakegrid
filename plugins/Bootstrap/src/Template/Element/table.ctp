<?php
    $schema     = $this->request->getParam('schema');
    $modelClass = $this->request->getParam('modelClass');
    $paginacao  = $this->request->getParam('paging')[$modelClass];
?>
<table class='table table-striped table-bordered table-sm'>
    <thead>
        <tr>
            <?php foreach($schema as $_l => $_field) : 
                $th     = isset($schema['th'])              ? $schema['th'] : null;
                $title  = isset($schema['title'])           ? $schema['title'] : $_field;
                $thHtml = $title;
                if ( isset($schema['sort']) )
                {
                    $thHtml = $this->Paginator->sort($_field, $title);
                }
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
                    foreach($config['fields'] as $_l2 => $_field) :
                    $td     = isset($schema['td']) ? $schema['td'] : null;
                    $field  = $_field;
                    $vlr    = $_Entity->$field;
                    if ( strpos($field,'.')>-1 )
                    {
                        $vlr = '';
                        $arrField = explode('.', $field); 
                        foreach( $_Entity[$arrField[0]] as $_l3 => $_arrFields)
                        {
                            $vlr .= $_arrFields[$arrField[1]].', ';
                        }
                    }
                ?>

                <td <?php if ( isset($td) ) { foreach($td as $_tag => $_vlr) { echo "$_tag='$_vlr' "; }} ?>>
                    <?= $vlr ?>
                </td>

                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class='row border-top py-1'>
    <div class='col-9'>
        <?php if ( $paginacao ) : ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination small">
                <?php echo $this->Paginator->numbers(['templates'=>'Bootstrap.paginator-template', 'first'=>1]);?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>

    <div class='col-3 text-right font-italic pt-2'>
        exibindo <?= @$paginacao['current'] ?> de <?= @$this->Number->format($paginacao['count']) ?>
    </div>
</div>