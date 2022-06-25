<?php 

use App\Library\Formulario;

echo $this->loadView("comuns/cabecalho");
echo $this->loadView("comuns/menu");

echo Formulario::titulo(
    "Sobre o Autor", 
    [
        "controller" => $this->getController(),
        "btNovo" => false,
        "acao" => $this->getAcao()
    ]);

$dbDados = $this->getDados($dbDados);

?>

<main class="container">

    <section class="mb-5">

        <form method="POST" action="<?= SITEURL . $this->getController() . '/' . $this->getAcao() ?>" enctype="multipart/form-data">

            <div class="row">

                <div class="form-group col-12 mb-4">
                    <label for="nome" class="form-label">Nome *</label>
                    <input type="text" name="nome" id="nome" class="form-control" maxlength="50" value="<?= setValue('nome', $dbDados) ?>" required autofocus>
                </div>

                <div class="form-group col-12 col-md-6 mb-4">
                    <label for="cargo" class="form-label">Cargo *</label>
                    <input type="text" name="cargo" id="cargo" class="form-control" maxlength="50" value="<?= setValue('cargo', $dbDados) ?>" required>
                </div>

                <div class="form-group col-12 col-md-6 mb-4">
                <label for="statusRegistro" class="form-label">Status de registro *</label>
                <select name="statusRegistro" id="statusRegistro" class="form-control" required>
                    <option value="" <?= setValue('statusRegistro', $dbDados) == "" ? "selected" : "" ?>>.....</option>
                    <option value="1" <?= setValue('statusRegistro', $dbDados) == "1" ? "selected" : "" ?>>Ativo</option>
                    <option value="2" <?= setValue('statusRegistro', $dbDados) == "2" ? "selected" : "" ?>>Inativo</option>
                </select>
                </div>

                <div class="form-group col-12 mb-4">
                    <label for="texto" class="form-label">Texto *</label>
                    <textarea name="texto" id="texto" class="form-control" required><?= setValue('texto', $dbDados) ?></textarea>
                </div>

                <div class="form-group col-12 col-md-6 mb-4">
                    <label for="linkFacebook" class="form-label">Facebook</label>
                    <input type="text" name="linkFacebook" id="linkFacebook" class="form-control" maxlength="100" value="<?= setValue('linkFacebook', $dbDados) ?>">
                </div>

                <div class="form-group col-12 col-md-6 mb-4">
                    <label for="linkInstagram" class="form-label">Instagram</label>
                    <input type="text" name="linkInstagram" id="linkInstagram" class="form-control" maxlength="100" value="<?= setValue('linkInstagram', $dbDados) ?>">
                </div>

                <div class="form-group col-12 col-md-6 mb-4">
                    <label for="linkTwitter" class="form-label">Twitter</label>
                    <input type="text" name="linkTwitter" id="linkTwitter" class="form-control" maxlength="100" value="<?= setValue('linkTwitter', $dbDados) ?>">
                </div>

                <div class="form-group col-12 col-md-6 mb-4">
                    <label for="linkLinkedin" class="form-label">LinkedIn</label>
                    <input type="text" name="linkLinkedin" id="linkLinkedin" class="form-control" maxlength="100" value="<?= setValue('linkLinkedin', $dbDados) ?>">
                </div>

                <div class="form-group col-12 col-md-6 mb-4">

                    <label for="fotoFile" class="form-label font-weight-bold">Foto<span class="text-danger">*</span></label>
                    <input type="file" class="form-control-file" name='fotoFile' id="fotoFile" <?= setDisable($this->getAcao()) ?> accept="image/png, image/jpeg, image/jpg" <?= $this->getAcao() == 'insert' ? 'required' : '' ?>>

                </div>
                
                <input type="hidden" name="id" value="<?= setValue('id', $dbDados) ?>">
                <input type="hidden" name="foto" value="<?= setValue('foto', $dbDados) ?>">

            </div>

            <div class="form-group col-12 col-md-4">
                <a href="<?= SITEURL ?>sobreautor" class="mr-5">Voltar</a>
                <?php if ($this->getAcao() != 'view'): ?>
                    <button type="submit" value="submit" class="button button-login">Gravar</button>
                <?php endif; ?>
            </div>

        </div>

        </form>

    </section>

</main>

<script type="text/javascript" src="<?= SITEURL ?>assets/ckeditor5/ckeditor.js"></script>

<script type="text/javascript">
    ClassicEditor
        .create( document.querySelector('#texto'))
        .catch( error => {
            console.error( error );
        })
</script>

<?= $this->loadView("comuns/rodape") ?>