<?php

echo $this->loadView("comuns/cabecalho");
echo $this->loadView("comuns/menu");

?>

<section>
    <div class="container">
        <div class="blog-banner">
            <div class="mt-5 mb-5 text-left">
                <h1 style="color: #384aeb;">Sobre o Autor</h1>
            </div>
        </div>
    </div>
</section>

<main class="site-main">

    <section class="blog_area">
        <div class="container">
            <div class="row">

                <div class="col-lg-8">
                    <div class="blog_left_sidebar">

                        <article class="row mt-5">
                            <p class="col-12 text-center">
                                <img class="author_img rounded-circle" style="width: 250px; height: 250px;" src="<?= SITEURL ?>uploads/autor/<?= $dbDados['aAutor']['foto'] ?>" alt="">
                            </p>
                            
                            <h4 class="col-12 text-center"><?= $dbDados['aAutor']['nome'] ?></h4>
                            <p class="col-12 text-center"><?= $dbDados['aAutor']['cargo'] ?></p>

                            <p class="col-12 text-center social_icon" style="font-size: 24px;">

                                <a href="<?= $dbDados['aAutor']['linkFacebook'] ?>" tile="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="<?= $dbDados['aAutor']['linkInstagram'] ?>" title="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="<?= $dbDados['aAutor']['linkTwitter'] ?>" title="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="<?= $dbDados['aAutor']['linkLinkedin'] ?>" title="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>

                            </p>
                            <p class="col-12">
                                <?= $dbDados['aAutor']['texto'] ?>
                            </p>
                            <div class="br"></div>
                        </article>
                    </div>
                </div>

                <div class="col-lg-4">
                    <?php require_once("home-sidebar.php") ?>
                </div>

            </div>
        </div>
    </section>
</main>

<?= $this->loadView("comuns/rodape") ?>