<?php
use App\Library\Session;

echo $this->loadView('comuns/cabecalho');
echo $this->loadView('comuns/menu');

?>

<section>
    <div class="container">
        <div class="blog-banner">
            <div class="mt-5 mb-5 text-center">
                <h1 style="color: #DC143C;">Recuperação de Senha</h1>
                <h6 style="color: #DC143C;">Informe seu email para que podemos enviar um link para a recuperação da senha.</h6>
            </div>
        </div>
    </div>
</section>

<section class="section-margin section-login">
    
    <div class="container" style="margin-top: 100px;">
        
        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <form class="form-contact contact_form" action="<?= SITEURL . "Login/gerarLinkRecuperaSenha" ?>" method="post" id="contactForm" novalidate="novalidate">
                <div class="row">

                    <div class="col-sm-12 header-login mb-4">
                        <h6 class="intro-title header-login-title p-2 font-weight-bold">Informe seu e-mail</h6>
                    </div>        
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input class="form-control" name="email" id="email" 
                                    type="text" 
                                    placeholder="e-mail"
                                    required>
                        </div>
                    </div>
                </div>

            <?php

            if (Session::get('msgErros')) {
                ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            <?= Session::getDestroy('msgErros') ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="form-group mt-3 controls">
                    <button type="submit" class="btn btn-danger">Enviar</button>
                </div>
            </div>

        </form>

        </div>

    </div>
</section>

<?= $this->loadView('comuns/rodape') ?>