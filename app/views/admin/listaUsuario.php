<?php

use App\Library\Formulario;

echo $this->loadView("comuns/cabecalho");
echo $this->loadView("comuns/menu");

echo Formulario::titulo("Lista Usuário", [
                                            "controller" => "usuario", 
]);

?>

<script type="text/javascript" src="<?= SITEURL ?>assets/DataTables/datatables.min.js"></script>

<div class="container">

    <section class="login_box_area mb-5">
        <div class="table-responsive">

            <table id="tbListaUsuario" class="table table-hover table-bordered table-striped table-sm">
                <thead>
                    <tr class="text-weigth-bold">
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Nível</th>
                        <th>Status</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dbDados as $value): ?>
                        <tr>
                            <td><?= $value['nome'] ?></td>
                            <td><?= $value['email'] ?></td>
                            <td><?= ($value['nivel'] == 1 ? "Administrador" : "Visitante") ?></td>
                            <td><?= ($value['statusRegistro'] == 1 ? "Ativo" : "Inativo") ?></td>
                            <td>
                                <a href="<?= SITEURL ?>Usuario/form/view/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Visualizar">
                                    <i class="fa fa-eye" area-hidden="true"></i>
                                </a>
                                <a href="<?= SITEURL ?>Usuario/form/update/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Alterar">
                                    <i class="fa fa-file" area-hidden="true"></i>
                                </a>
                                <a href="<?= SITEURL ?>Usuario/form/delete/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Excluir">
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

<?= Formulario::getDataTables("tbListaUsuario") ?>

<?= $this->loadView("comuns/rodape") ?>