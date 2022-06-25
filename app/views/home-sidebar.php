<!-- <div class="blog_right_sidebar">

    <aside class="single_sidebar_widget post_category_widget">
        <h4 class="widget_title">Categorias de Posts</h4>
        <ul class="list cat-list">

            <?php foreach ($dbDados['aCategoriaQtde'] as $value): ?>

                <li>
                    <a href="<?= SITEURL ?>Home/Index/filtro/<?= $value['categoria_id'] ?>" class="d-flex justify-content-between">
                        <p><?= $value['descricao'] ?></p>
                        <p><?= $value['qtde'] ?></p>
                    </a>
                </li>

            <?php endforeach; ?>

        </ul>
        <div class="br"></div>
    </aside>

    <aside class="single_sidebar_widget popular_post_widget">
        <h3 class="widget_title">Posts mais populares</h3>

        <?php foreach ($dbDados['aMaisPopular'] as $value) : ?>

            <div class="media post_item">
                <img src="<?= SITEURL ?>uploads/noticias/<?= $value['imagem'] ?>" height="60" width="100" alt="post">
                <div class="media-body">
                    <a href="<?= SITEURL ?>Home/noticiaDetalhe/view/<?= $dbDados['aFiltro']['categoria_id']. '/' . $dbDados['aFiltro']['pagina'] . '/' . $value['id'] ?>">
                        <h3><?= $value['titulo'] ?></h3>
                    </a>
                </div>
            </div>

        <?php endforeach; ?>
    </aside>
</div> -->