<?php

use App\Library\Formulario;

echo $this->loadView("comuns/cabecalho");
echo $this->loadView("comuns/menu");

echo Formulario::titulo(
                        "Lista Notícia", 
                        [
                            "controller" => $this->getController(), 
                        ]);

?>

<div class="container">
    <section class="login_box_area mb-5">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped table-sm tblLista">
                <thead>
                    <tr class="text-weigth-bold">
                        <th>Título</th>
                        <th>Status</th>
                        <th>Data Criação</th>
                        <th>Imagem</th>
                        <th>Criador</th>
                        <th>Opções</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($dbDados as $value) : ?>
                        <tr>
                            <td><?= $value->titulo ?></td>
                            <td class="text-center"><?= $value->statusRegistro == 1 ? '<i title="Ativo" style="color: green;!important;" class="fas fa-check-circle"></i>' : '<i title="Inativo" style="color:red;!important;" class="fas fa-minus-circle"></i>' ?></td>
                            <td><?= date("d/m/Y H:i", strtotime($value->created_at)) ?></td>
                            <td class="text-center">
                                <a target="_blank" href="<?= SITEURL ?>uploads/noticias/<?= $value->imagem ?>">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </td>
                            <td><?= $value->nome ?? '' ?></td>
                            <td>
                                <a href="<?= SITEURL ?>noticia/form/view/<?= $value->id ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Visualizar">
                                    <i class="fa fa-eye" area-hidden="true"></i>
                                </a>
                                <a href="<?= SITEURL ?>noticia/form/update/<?= $value->id ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Alterar">
                                    <i class="fa fa-edit" area-hidden="true"></i>
                                </a>
                                <a href="<?= SITEURL ?>noticia/form/delete/<?= $value->id ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Excluir">
                                    <i class="fa fa-trash" area-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<?= Formulario::getDataTables("tbListaCategoria") ?>

<?= $this->loadView('comuns/rodape'); ?>