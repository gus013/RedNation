<?php

use App\Library\Session;

$aCategoria = Session::get("aMenuCategorias");

if (is_null($aCategoria)) {
    $aCategoria = [];
}

?>

<header class="header_area">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <div class="container">
                <a class="navbar-brand logo_h" style="color: #DC143C" href="<?= SITEURL ?>"><img src="<?= SITEURL ?>assets/img/icone.png" alt="">  REDNATION</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
                        <li class="nav-item active"><a class="nav-link" style="color: #DC143C" href="<?= SITEURL . (isset($_SESSION['userCodigo']) ? "Home/homeAdmin" : "") ?>">Página Inicial</a></li>
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #DC143C">Categorias</a>
                            <ul class="dropdown-menu">

                            <?php
                                foreach ($aCategoria as $value ) {
                                    ?>
                                    <li class="nav-item"><a class="nav-link bg-dark" style="color: #DC143C" href="<?= SITEURL ?>Home/Index/filtro/<?= $value['id'] ?>"><?= $value['descricao'] ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        
                        <li class="nav-item"><a class="nav-link" style="color: #DC143C" href="<?= SITEURL ?>Home/contato">Contato</a></li>
                    </ul>
                    <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
                        <?php
                            if (!isset($_SESSION['userCodigo'])) {
                                ?>
                                <li class="nav-item"><a class="nav-link" style="color: #DC143C" href="<?= SITEURL ?>Home/login">Login</a></li>
                                <?php
                            } else {

                                if ($_SESSION['userNivel'] == 1) {
                                    ?>
                                    <li class="nav-item submenu dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #DC143C">Cadastros</a>
                                        <ul class="dropdown-menu">
                                            <li class="nav-item"><a class="nav-link bg-dark" style="color: #DC143C" href="<?= SITEURL ?>Usuario">Usuário</a></li>
                                            <li class="nav-item"><a class="nav-link bg-dark" style="color: #DC143C" href="<?= SITEURL ?>Categoria">Categoria</a></li>
                                            <li class="nav-item"><a class="nav-link bg-dark" style="color: #DC143C" href="<?= SITEURL ?>Noticia">Notícia</a></li>
                                        </ul>
                                    </li>  
                                    <?php
                                }
    
                                ?>
                                <li class="nav-item submenu dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= substr($_SESSION['userEmail'], 0 , strripos($_SESSION['userEmail'], "@") ) ?></a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item"><a class="nav-link" href="<?= SITEURL ?>Login/signOut">Sair</a></li>
                                        <li class="nav-item"><a class="nav-link" href="<?= SITEURL ?>Usuario/Perfil">Perfil</a></li>
                                        <li class="nav-item"><a class="nav-link" href="<?= SITEURL ?>Usuario/trocaSenha">Trocar Senha</a></li>
                                    </ul>
                                </li>     
                                <?php
                            }
                        ?>
                    </ul>

                </div>
            </div>
        </nav>
    </div>
</header>
