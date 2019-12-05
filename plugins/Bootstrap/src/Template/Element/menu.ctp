<?php 
    $Menu       = new Bootstrap\View\Helper\MenuHelper($this);
    $permissoes = @$this->request->getSession()->read('Auth.User.Permissoes');
    $papelAtivo = @$this->request->getSession()->read('Auth.User.PapelAtivo');
?>
<div class="row">
<nav class="navbar navbar-expand-sm">

<!-- Links -->
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="<?= $this->Url->build('/', true); ?>">Início</a>
    </li>

    <?php if (isset($permissoes[$papelAtivo])) : $menuPai=''; foreach($permissoes[$papelAtivo] as $_url => $_arrProp) : if (empty(@$_arrProp['menu'])) continue; if ($menuPai !== $_arrProp['menu']) : $menuPai = $_arrProp['menu']; ?>
    <li class="nav-item dropdown">

        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown"><?= $menuPai ?></a>

        <?= $Menu->getSubMenus($_arrProp['menu'], $permissoes[$papelAtivo]); ?>
    </li>
    <?php endif; endforeach; endif; ?>

</ul>
</nav>
</div>