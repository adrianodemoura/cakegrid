<?php
if ( !isset($params['escape']) || $params['escape'] !== false )
{
    $message = h($message);
}
?>
<div class="mensagem sucesso" onclick="this.classList.add('ocultar')" title="clique aqui para ocultar"><?= $message ?></div>
