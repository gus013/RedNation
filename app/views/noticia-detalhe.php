<?php

use App\Library\Formulario;
use App\Library\Session;

echo $this->loadView("comuns/cabecalho");
echo $this->loadView("comuns/menu");

$categoria = '';

foreach ($dbDados['aNoticia']['aCategoria'] as $valueCategoria) {
    $categoria .= ($categoria != "" ? ", " : "" ) . '<a class="active" href="' . SITEURL . 'Home/index/filtra/' . $valueCategoria['categoria_id'] . '">' . $valueCategoria['descricao'] . '</a>';
}

?>

<section>
    <div class="container">
        <div class="blog-banner">
            <div class="mt-5 mb-5 text-left">
                <h1 style="color: #384aeb;"><?= $dbDados['aNoticia']['titulo'] ?></h1>
            </div>
        </div>
    </div>
</section>

<section class="blog_area single-post-area py-80px section-margin--small">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 posts-list">
                <div class="single-post row">
                    <div class="col-lg-12">
                        <div class="feature-img">
                            <img class="img-fluid" src="img/blog/m-blog-ciclismo-de-estrada.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-3  col-md-3">
                        <div class="blog_info text-right">
                            <div class="post_tag">
                                <?= $categoria ?>
                            </div>
                            <ul class="blog_meta list">
                                <?php 
                                    if (Session::get("userCodigo") != "") {

                                        if (is_null($dbDados['aNoticia']['idMarcadoLeitura'])) {
                                            ?>
                                            <li>
                                                <a href="<?= SITEURL ?>Home/noticiaLida/Marcar/<?= $dbDados['aFiltro']['categoria_id']. '/' . $dbDados['aFiltro']['pagina'] . '/' . $dbDados['aNoticia']['id'] . '/' . $dbDados['aNoticia']['id'] ?>/d">Marcar como lida
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            <?php
                                        } else {
                                            ?>
                                            <li>
                                                <a href="<?= SITEURL ?>Home/noticiaLida/Desmarcar/<?= $dbDados['aFiltro']['categoria_id']. '/' . $dbDados['aFiltro']['pagina'] . '/' . $dbDados['aNoticia']['id'] . '/' . $dbDados['aNoticia']['idMarcadoLeitura'] ?>/d" class="text-success">Desmarcar Leitura
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
                                    <?= date("d", strtotime($dbDados['aNoticia']['created_at'])) . " " . mesExtenso(date("m", strtotime($dbDados['aNoticia']['created_at']))) . ", " . date("Y", strtotime($dbDados['aNoticia']['created_at'])) ?>
                                    &nbsp;&nbsp;<i class="fa fa-calendar text-dark" aria-hidden="true"></i>
                                </li>
                                <li class="mt-4">
                                    <?= $dbDados['aNoticia']['qtdVisualizacao'] . '  ' . ($dbDados['aNoticia']['qtdVisualizacao'] > 1 ? 'Visualizações' : 'Visualização') ?> 
                                    &nbsp;&nbsp;<i class="fa fa-eye-slash text-dark" aria-hidden="true"></i>
                                </li>
                                <li class="mt-4">
                                    <?= $dbDados['aNoticia']['qtdeComentarios']  . '  ' . ($dbDados['aNoticia']['qtdeComentarios'] > 1 ? "Comentários": "Comentário") ?>
                                    &nbsp;&nbsp;<i class="fa fa-comments text-dark" aria-hidden="true"></i>
                                </li>
                                <li class="mt-5">
                                    <a href="<?= SITEURL ?>Home/Index/pagina/<?= $dbDados['aFiltro']['categoria_id']. '/' . $dbDados['aFiltro']['pagina'] ?>" class="button button-blog">
                                        Voltar
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 blog_details">
                    <img src="<?= SITEURL ?>uploads/noticias/<?= $dbDados['aNoticia']['imagem'] ?>" alt="">
                        <p class="excert">
                            <?= $dbDados['aNoticia']['texto'] ?>
                        </p>
                    </div>

                </div>
                <div class="comments-area">
                    <h4><?= count($dbDados['aComentario']) ?> Comentários</h4>

                    <?php foreach ($dbDados['aComentario'] as $comentario): ?>

                        <div class="comment-list">
                            <div class="single-comment justify-content-between d-flex">
                                <div class="user justify-content-between d-flex">
                                    <div class="desc">
                                        <h5>
                                            <?= $comentario['nome'] ?>
                                        </h5>
                                        <p class="date">
                                            <?= date("d", strtotime($comentario['created_at'])) . " " . mesExtenso(date("m", strtotime($comentario['created_at']))) . ", " . date("Y", strtotime($comentario['created_at'])) ?> às <?= date("H:i:s", strtotime($comentario['created_at'])) ?>
                                        </p>
                                        <p class="comment">
                                            <?= $comentario['texto'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

                <?php if (Session::get('userCodigo') != ""): ?>
                    <div class="comment-form">
                        <h4>Deixe seu comentário</h4>
                        <?= Formulario::exibeMsgSucesso() ?>
                        <?= Formulario::exibeMsgError() ?>
                        <form method="POST" action="<?= SITEURL ?>/Noticia/comentarioInsert">
                            <div class="form-group">
                                <textarea class="form-control mb-10" rows="5" name="texto" id="texto" placeholder="Mensagem" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Mensagem'" required=""></textarea>
                            </div>

                            <input type="hidden" name="noticia_id"      id="noticia_id"     value="<?= $dbDados['aNoticia']['id'] ?>">
                            <input type="hidden" name="categoria_id"    id="categoria_id"   value="<?= $dbDados['aFiltro']['categoria_id'] ?>">
                            <input type="hidden" name="pagina"          id="pagina"         value="<?= $dbDados['aFiltro']['pagina']?>">

                            <button class="button button-postComment button--active">Enviar comentário</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <div class="blog_right_sidebar">
                    <?php require_once "home-sidebar.php"; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->loadView("comuns/rodape") ?>