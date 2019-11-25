<?php ?>
<nav class="navbar navbar-expand-sm">

  <!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="<?= $this->Url->build('/', true); ?>">Início</a>
    </li>
    
    <!-- Cadastros -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Cadastros</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="<?= $this->Url->build('/auditoria'); ?>">Auditoria</a>
        <a class="dropdown-item" href="<?= $this->Url->build('/permissoes'); ?>">Permissões</a>
        <a class="dropdown-item" href="<?= $this->Url->build('/usuarios'); ?>">Usuários</a>
      </div>
    </li>

    <!-- Ferramentas -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Ferramentas</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">Enviar e-mail</a>
      </div>
    </li>


    <!-- Relatórios -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Relatórios</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">Relatórios de Usuários</a>
      </div>
    </li>

    <!-- Ajuda -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Ajuda</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">Manual</a>
        <a class="dropdown-item" href="<?= $this->Url->build('/ajuda/sobre'); ?>">Sobre</a>
      </div>
    </li>
  </ul>
</nav>