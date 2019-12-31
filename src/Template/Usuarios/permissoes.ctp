<?php 
    $Sessao     = $this->request->getSession();
    $papelAtivo = $Sessao->read('User.PapelAtivo');
?>
<div>
    <?php debug($Sessao->read('User.Permissoes.$papelAtivo')); ?>
</div>