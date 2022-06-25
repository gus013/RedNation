<?php

use App\Library\Formulario;

echo $this->loadView("comuns/cabecalho");
echo $this->loadView("comuns/menu");

echo Formulario::titulo("Usuário", [
                                            "controller" => "usuario", 
                                            "btNovo" => false,
                                            "acao" => $this->getAcao()
    ]); 

$dbDados = $this->getDados($dbDados);

?>

<main class="container">

    <section class="mb-5">

        <form method="POST" action="<?= SITEURL ?>Usuario/<?= $this->getAcao() ?>">

            <div class="row">

                <div class="form-group col-12 col-md-8">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" name="nome" id="nome"  class="form-control" maxlength="50" 
                    value="<?= isset($dbDados['nome']) ? $dbDados['nome'] : "" ?>" 
                    required autofocus placeholder="Nome completo do usuário">
                </div>

                <div class="form-group col-12 col-md-4">
                    <label for="statusRegistro" class="form-label">Status</label>
                    <select name="statusRegistro" id="statusRegistro" class="form-control" required>
                        <option value=""  <?= isset($dbDados['statusRegistro']) ? $dbDados['statusRegistro'] == ""  ? "selected" : "" : "" ?>>.....</option>
                        <option value="1" <?= isset($dbDados['statusRegistro']) ? $dbDados['statusRegistro'] == "1" ? "selected" : "" : "" ?>>Ativo</option>
                        <option value="2" <?= isset($dbDados['statusRegistro']) ? $dbDados['statusRegistro'] == "2" ? "selected" : "" : "" ?>>Inativo</option>
                    </select>
                </div>

                <div class="form-group col-12 col-md-8">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="text" name="email" id="email"  class="form-control" maxlength="100" 
                        value="<?= isset($dbDados['email']) ? $dbDados['email'] : "" ?>" 
                        required placeholder="E-mail: seu-nome@dominio.com">
                </div>

                <div class="form-group col-12 col-md-4">
                    <label for="nivel" class="form-label">Nível</label>
                    <select name="nivel" id="nivel" class="form-control" required>
                        <option value=""   <?= isset($dbDados['nivel']) ? $dbDados['nivel'] == ""    ? "selected" : "" : "" ?>>.....</option>
                        <option value="1"  <?= isset($dbDados['nivel']) ? $dbDados['nivel'] == "1"   ? "selected" : "" : "" ?>>Administrador</option>
                        <option value="11" <?= isset($dbDados['nivel']) ? $dbDados['nivel'] == "11"  ? "selected" : "" : "" ?>>Visitante</option>
                    </select>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" name="senha" id="senha"  class="form-control" maxlength="250" 
                        value="<?= isset($dbDados['senha']) ? $dbDados['senha'] : "" ?>" 
                        required placeholder="Informe uma senha">
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="confSenha" class="form-label">Confere a senha</label>
                    <input type="password" name="confSenha" id="confSenha"  class="form-control" maxlength="250" 
                        value="<?= isset($dbDados['senha']) ? $dbDados['senha'] : "" ?>" 
                        required placeholder="Confirme a senha">
                </div>

                <input type="hidden" name="id" value="<?= isset($dbDados['id']) ? $dbDados['id'] : "" ?>">

                <div class="form-group col-12 col-md-4">
                    <?php if ($this->getAcao() != "view"): ?>
                        <button type="submit" value="submit" class="button button-login">Gravar</button>
                    <?php endif; ?>
                    <a href="<?= SITEURL ?>/Usuario" class="ml-3">Voltar</a>
                </div>

            </div>

        </form>

    </section>
    
</main>

<?= $this->loadView("comuns/rodape") ?>