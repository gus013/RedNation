<?php

use App\Library\Formulario;
use App\Library\Session;

echo $this->loadView("comuns/cabecalho");
echo $this->loadView("comuns/menu");

echo Formulario::titulo(
                "Categoria", 
                [
                    "controller" => $this->getController(),
                    "btNovo" => false,
                    "acao" => $this->getAcao()
                ]);

$dbDados = $this->getDados($dbDados);

?>

<main class="container">

    <section class="mb-5">

        <form method="POST" action="<?= SITEURL . $this->getController() . '/' . $this->getAcao() ?>">

            <div class="row">

                <div class="form-group col-12 col-md-8">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" name="descricao" id="descricao" class="form-control" maxlength="50" value="<?= setValue('descricao', $dbDados) ?>" required autofocus placeholder="Descrição da Categoria">
                </div>

                <div class="form-group col-12 col-md-4">
                    <label for="statusRegistro" class="form-label">Status</label>
                    <select name="statusRegistro" id="statusRegistro" class="form-control" required>
                        <option value=""  <?= setValue('statusRegistro', $dbDados ) == ""  ? "selected" : "" ?>>.....</option>
                        <option value="1" <?= setValue('statusRegistro', $dbDados ) == "1" ? "selected" : "" ?>>Ativo</option>
                        <option value="2" <?= setValue('statusRegistro', $dbDados ) == "2" ? "selected" : "" ?>>Inativo</option>
                    </select>
                </div>

                <input type="hidden" name="id" value="<?= setValue("id", $dbDados) ?>">

                <div class="form-group col-12 col-md-4">
                    <a href="<?= SITEURL ?>/Categoria" class="mr-5">Voltar</a>
                    <?php if ($this->getAcao() != 'view'): ?>
                        <button type="submit" value="submit" class="button button-login">Gravar</button>
                    <?php endif; ?>
                </div>

            </div>

        </form>

    </section>

</main>

<?= $this->loadView("comuns/rodape") ?>