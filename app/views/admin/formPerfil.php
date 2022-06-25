<?php

use App\Library\Formulario;

echo $this->loadView("comuns/cabecalho");
echo $this->loadView("comuns/menu");

?>

<section>
    <div class="container">
        <div class="blog-banner">
            <div class="mt-5 mb-5 text-left">
                <h1 style="color: #384aeb;">Perfil</h1>
            </div>
        </div>
        <?php
            echo Formulario::exibeMsgError();
            echo Formulario::exibeMsgSucesso();
        ?> 
    </div>
</section>

<main class="container">

    <section class="mb-5">

        <form method="POST" action="<?= SITEURL ?>Usuario/atualizaPerfil">

            <div class="row">

                <div class="form-group col-12 col-md-8">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" name="nome" id="nome"  class="form-control" maxlength="50" 
                    value="<?= setValue("nome", $dbDados) ?>" 
                    required autofocus placeholder="Nome completo do usuário">
                </div>

                <div class="form-group col-12 col-md-8">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="text" name="email" id="email"  class="form-control" maxlength="100" 
                        value="<?= setValue("email", $dbDados) ?>" 
                        required placeholder="E-mail: seu-nome@dominio.com">
                </div>

                <input type="hidden" name="id" value="<?= setValue("id", $dbDados) ?>">

            </div>

            <div class="row">
                <div class="form-group col-12 col-md-4">
                    <a href="<?= SITEURL ?>/Home" class="mr-3">Voltar</a>
                    <?php if ($this->getAcao() != "view"): ?>
                        <button type="submit" value="submit" class="button button-login">Gravar</button>
                    <?php endif; ?>                    
                </div>

            </div>

        </form>

    </section>
    
</main>

<?= $this->loadView("comuns/rodape") ?>