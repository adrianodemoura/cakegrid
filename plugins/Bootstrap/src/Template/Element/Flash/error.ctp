<?php
if (!isset($params['escape']) || $params['escape'] !== false) { $message = h($message); }
?>
<div class="row bg-danger text-white mensagem px-3" onclick="this.classList.add('ocultar');" title="clique aqui para ocultar"><?= $message ?></div>
