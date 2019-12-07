<table class='table table-striped table-bordered table-sm'>
    <thead>
        <tr>
            <?php foreach($config['fieldsTable'] as $_l2 => $_field) : 
                $field  = $_field;
                $th     = isset($config['schema'][$field]['th']) ? $config['schema'][$field]['th'] : null;
                $thHtml = isset($config['schema'][$field]['title']) ? $config['schema'][$field]['title'] : $field;
            ?>

            <th <?php if ( isset($th) ) { foreach($th as $_tag => $_vlr) { echo "$_tag='$_vlr' "; }} ?>>
                <?= $thHtml; ?>
            </th>

            <?php endforeach; ?>
        </tr>
    </thead>

    <tbody>
        <?php foreach($config['dados'] as $_l => $_Entity) : ?>
            <tr>
                <?php 
                    foreach($config['fieldsTable'] as $_l2 => $_field) :
                    $td     = isset($config['schema'][$_field]['td']) ? $config['schema'][$_field]['td'] : null;
                    $field  = $_field;
                ?>

                <td <?php if ( isset($td) ) { foreach($td as $_tag => $_vlr) { echo "$_tag='$_vlr' "; }} ?>>
                    <?= $_Entity->$field; ?>
                </td>

                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class='row border-top py-1'>
    <div class='col-9'>
        <nav aria-label="Page navigation example">
            <ul class="pagination small">
                <?= $this->Paginator->numbers(['templates'=>'Bootstrap.paginator-template']);?>
            </ul>
        </nav>
    </div>

    <div class='col-3 text-right font-italic pt-2'>
        exibindo <?= $config['paginacao']['current'] ?> de <?= $this->Number->format($config['paginacao']['count']) ?>
    </div>
</div>