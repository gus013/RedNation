<?php

use App\Library\Formulario;

echo $this->loadView("comuns/cabecalho");
echo $this->loadView("comuns/menu");

echo Formulario::titulo(
                "Notícia", 
                [
                    "controller" => $this->getController(),
                    "btNovo" => false,
                    "acao" => $this->getAcao()
                ]);

$dbDados['noticia'] = $this->getDados($dbDados['noticia']);

?>

<script type="text/javascript" src="<?= SITEURL ?>assets/ckeditor5/ckeditor.js"></script>

<main class="container" onload="readlonly(<?= $this->getAcao() ?>)">
    <section class="mb-5">
        <form method="POST" action="<?= SITEURL ?>noticia/<?= $this->getAcao() ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col">
                <div class="form-group">
                    <label for="titulo" class="form-label font-weight-bold">Título<span class="text-danger">*</span></label>
                    <input type="text" name="titulo" id="titulo" class="form-control" maxlength="60" value="<?= setValue('titulo', $dbDados['noticia']) ?>" placeholder="Título da notícia" <?= setDisable($this->getAcao()) ?> autofocus required>
                </div>

                <div class="form-group">
                    <label for="texto" class="form-label font-weight-bold">Descrição<span class="text-danger">*</span></label>
                    <textarea class="form-control different-control w-100 textCKEdidor" name="texto" id="texto" <?= setDisable($this->getAcao()) ?> cols="20" rows="5" placeholder="Descreva o texto da notícia">
                        <?= setValue('texto', $dbDados['noticia']) ?>
                    </textarea>
                </div>

                <div class="row">
                    <div class="form-group col-6">
                        <label for="statusRegistro" class="form-label font-weight-bold">Status<span class="text-danger">*</span></label>
                        <select name="statusRegistro" id="statusRegistro" class="form-control" required <?= setDisable($this->getAcao()) ?>>
                            <option value="1" <?= setSelected('1', setValue('statusRegistro', $dbDados['noticia'])) ?>>
                            Ativa
                            </option>
                            <option value="2" <?= setSelected('2', setValue('statusRegistro', $dbDados['noticia'])) ?>>
                            Inativa
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <div class="form-group">
                            <label for="" class="form-label font-weight-bold">Arquivo<span class="text-danger">*</span></label>
                            <input type="file" class="form-control-file" name='imagem' id="imagem" <?= setDisable($this->getAcao()) ?> accept="image/png, image/jpeg, image/jpg" <?= $this->getAcao() == 'insert' ? 'required' : '' ?>>
                        </div>
                    </div>
                </div>
                </div>

                <div class="col-12 col-md-4">
                <table class="table table-hover table-bordered table-striped table-sm">
                    <thead>
                        <tr class="text-weigth-bold">
                            <th colspan='2'>Categorias<span class="text-danger">*</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dbDados["categoria"] as $categoria) :

                            $checked = "";

                            if (isset($dbDados["noticiaCategoria"])) {
                            foreach ($dbDados["noticiaCategoria"] as $noticiacategoria) {
                                if ($noticiacategoria['categoria_id'] == $categoria['id']) {
                                    $checked = "checked";
                                    break;
                                }
                            }
                            }
                            ?>
                            <tr>
                            <td><?= $categoria['descricao'] ?></td>
                            <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                    <input class="form-check-input" type="checkbox" id="f-option2" name="categoria[]" value="<?= $categoria['id'] ?>" <?= $checked . " " . setDisable($this->getAcao()) ?>>
                                </div>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>

                <input type="hidden" name="id" value="<?= setValue('id', $dbDados['noticia']) ?>">
                <input type="hidden" name="nomeImagem" value="<?= setValue('imagem', $dbDados['noticia']) ?>">

            </div>

            <div class="form-group col-12 col-md-4">
                <a href="<?= SITEURL ?>noticia" class="mr-5">Voltar</a>
                <?php if ($this->getAcao() != 'view') : ?>
                <button class="button button-login" type="submit" value="submit">
                    <i class="fa fa-save" area-hidden="true"></i> Gravar
                </button>
                <?php endif; ?>
            </div>
        </form>
    </section>
</main>

<?= $this->loadView('comuns/rodape'); ?>

<script>
    ClassicEditor
        .create(document.querySelector("#texto"))
        .catch(error => {
            console.error(error);
        });
</script>