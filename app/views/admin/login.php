<?php

use App\Library\Formulario;

echo $this->loadView("comuns/cabecalho");
echo $this->loadView("comuns/menu");

?>

<section>
    <div class="container">
        <div class="blog-banner">
            <div class="mt-5 mb-5 text-center">
                <h1 style="color: #DC143C;">Login</h1>
                <h6 style="color: #DC143C;">Faça o Login ou cadastra-se para ficar por dentro de tudo que acontece com o Houston Rockets!</h6>
            </div>
        </div>
    </div>
</section>

<section class="login_box_area section-margin">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="login_box">
                    <img src="<?= SITEURL ?>assets/img/login.jpg" width="1100px" height="100%">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="login_form_inner">
                    
                    <!-- <h3 class="text-danger">Entre</h3> -->

                    <form method="POST" class="row login_form" action="<?= SITEURL ?>Login/signIn" id="contactForm">

                        <div class="col-lg-12 form-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" onfocus="this.placeholder = ''" onblur="this.placeholder = 'E-mail'" required>
                        </div>
                        <div class="col-lg-12 form-group">
                            <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Senha'" required>
                        </div>
                        <div class="col-lg-12 form-group">
                            <div class="creat_account">
                                <input type="checkbox" id="f-option2" name="selector">
                                <label class="text-white" for="f-option2"><b>Mantenha-me conectado</b></label>
                            </div>
                        </div>

                        <div class="col-12">
                            <?= Formulario::exibeMsgError() ?>
                        </div>

                        <div class="col-12">
                            <?= Formulario::exibeMsgSucesso() ?>
                        </div>
                        
                        <div class="col-md-12 form-group">
                            <button type="submit" value="submit" class="btn btn-danger w-100">Entrar</button>
                            <a class="btn btn-danger w-100" href="<?= SITEURL ?>criar-nova-conta" style="color: white">Crie sua conta aqui</a>
                            <a href="<?= SITEURL ?>Login/solicitaRecuperacaoSenha" style="color: white"><b>Esqueceu a senha?</b></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->loadView("comuns/rodape") ?>