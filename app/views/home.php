<?php 

use App\Library\Session;

echo $this->loadView("comuns/cabecalho");
echo $this->loadView("comuns/menu");

?>

<main class="site-main" >

    <div>
        <img src="<?= SITEURL ?>assets/img/banner02.webp" height="" width="100%">
    </div>
    <section class="blog_area mt-5 ml-5">
        <div class="container" >
            <div class="row" >
                <div class="col-lg-8">
                    <div class="blog_left_sidebar">

                        <?php

                            if (count($dbDados['aNoticia']) > 0) {

                                foreach ($dbDados['aNoticia'] as $noticia) {

                                    $categoria = '';

                                    // foreach ($noticia['aCategoria'] as $valueCategoria) {
                                    //     $categoria .= ($categoria != "" ? ", " : "" ) . '<a class="active" href="' . SITEURL . 'Home/index/filtra/' . $valueCategoria['categoria_id'] . '">' . $valueCategoria['descricao'] . '</a>';
                                    // }

                                    ?>
                                    <article class="row blog_item">

                                        <div class="col-md-3">
                                            <div class="blog_info text-right">
                                                <div class="post_tag">
                                                    <?= $categoria ?>
                                                </div>
                                                <ul class="blog_meta list">

                                                    <?php 
                                                        if (Session::get("userCodigo") != "") {

                                                            if (is_null($noticia['idMarcadoLeitura'])) {
                                                                ?>
                                                                <li>
                                                                    <a href="<?= SITEURL ?>Home/noticiaLida/Marcar/<?= $dbDados['aFiltro']['categoria_id']. '/' . $dbDados['aFiltro']['pagina'] . '/' . $noticia['id'] . '/' . $noticia['id'] ?>/h">Marcar como lida
                                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <li>
                                                                    <a href="<?= SITEURL ?>Home/noticiaLida/Desmarcar/<?= $dbDados['aFiltro']['categoria_id']. '/' . $dbDados['aFiltro']['pagina'] . '/' .  $noticia['id'] . '/' . $noticia['idMarcadoLeitura'] ?>/h" class="text-success">Desmarcar Leitura
                                                                        <i class="fa fa-user text-success" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <?php
                                                            }
                                                            ?>
                                                            <?php 
                                                        } 
                                                    ?>

                                                    <li class="mt-4">
                                                        <h6>Postado em</h6>
                                                        <?= date("d", strtotime($noticia['created_at'])) . " " . mesExtenso(date("m", strtotime($noticia['created_at']))) . ", " . date("Y", strtotime($noticia['created_at'])) ?>
                                                        &nbsp;&nbsp;<i class="fa fa-calendar text-dark" aria-hidden="true"></i>
                                                    </li>
                                                    <!-- <li class="mt-4">
                                                        <?= $noticia['qtdVisualizacao'] . '  ' . ($noticia['qtdVisualizacao'] > 1 ? 'Visualizações' : 'Visualização') ?> 
                                                        &nbsp;&nbsp;<i class="fa fa-eye-slash text-dark" aria-hidden="true"></i>
                                                    </li>
                                                    <li class="mt-4">
                                                        <?= $noticia['qtdeComentarios'] . '  ' . ($noticia['qtdeComentarios'] > 1 ? "Comentários": "Comentário") ?>
                                                        &nbsp;&nbsp;<i class="fa fa-comments text-dark" aria-hidden="true"></i>
                                                    </li> -->
                                                </ul>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-9">
                                            <div class="blog_post">
                                                <div class="blog_details">
                                                    <a href="<?= SITEURL ?>Home/noticiaDetalhe/view/<?= $dbDados['aFiltro']['categoria_id']. '/' . $dbDados['aFiltro']['pagina'] . '/' . $noticia['id'] ?>">
                                                        <h2><?= $noticia['titulo'] ?></h2>
                                                    </a>
                                                    <img src="<?= SITEURL ?>uploads/noticias/<?= $noticia['imagem'] ?>" alt="">
                                                    <p>
                                                        <?= mb_strimwidth($noticia['texto'], 0 , 300, " ...") ?>
                                                    </p>
                                                    <a href="<?= SITEURL ?>Home/noticiaDetalhe/view/<?= $dbDados['aFiltro']['categoria_id']. '/' . $dbDados['aFiltro']['pagina'] . '/' . $noticia['id'] ?>" class="button button-blog bg-danger">Detalhes</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </article>

                                    <?php
                                } 

                                if ($dbDados['aFiltro']['totalPaginas'] > 1) {
                                    ?>
                                    <nav class="blog-pagination justify-content-center d-flex ">
                                            <ul class="pagination" style="color: #DC143C">

                                                <?php if ($dbDados['aFiltro']['pagina'] > 1): ?>
                                                    <li class="page-item" >
                                                        <a href="<?= SITEURL?>Home/index/pagina/<?= $dbDados['aFiltro']['categoria_id'] . '/' . ($dbDados['aFiltro']['pagina'] - 1) ?>" class="page-link bg-danger" style="color: #000">Anterior</a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php for ($xxx = 1; $xxx <= $dbDados['aFiltro']['totalPaginas']; $xxx++): ?>

                                                    <li class="page-item <?= ($xxx == $dbDados['aFiltro']['pagina'] ? 'active' : '') ?>" >
                                                        <a href="<?= SITEURL?>Home/index/pagina/<?= $dbDados['aFiltro']['categoria_id'] . '/' . $xxx ?>" class="page-link bg-danger" style="color: #000"><?= $xxx ?></a>
                                                    </li>

                                                <?php endfor; ?>

                                                <?php if (($dbDados['aFiltro']['totalPaginas'] > 1) and ($dbDados['aFiltro']['pagina'] < $dbDados['aFiltro']['totalPaginas'])): ?>
                                                    <li class="page-item" >
                                                        <a href="<?= SITEURL?>Home/index/pagina/<?= $dbDados['aFiltro']['categoria_id'] . '/' . ($dbDados['aFiltro']['pagina'] + 1) ?>" class="page-link bg-danger" style="color: #000">Próxima</a>
                                                    </li>
                                                <?php endif; ?>

                                            </ul>
                                        </nav>

                                    <?php
                                }

                            } else {
                                ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Categoria Vazia.</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php
                            }
                        
                        ?>

                    </div>
                </div>
                
                <div class="col-lg-4">                    
                    <?php require_once "home-sidebar.php" ?>
                </div>
            </div>
        </div>
    </section>

</main>

<?= $this->loadView("comuns/rodape") ?>