<?php

use App\Library\Formulario;

echo $this->loadView("comuns/cabecalho");
echo $this->loadView("comuns/menu");

echo Formulario::titulo(
                        "Lista Categoria", 
                        [
                            "controller" => $this->getController(), 
                        ]);

?>

<script type="text/javascript" src="<?= SITEURL ?>assets/DataTables/datatables.min.js"></script>

<div class="container">

	<section class="login_box_area mb-5">
        <div class="table-responsive">
            <table id="tbListaCategoria" class="table table-hover table-bordered table-striped table-sm">
                <thead>
                    <tr class="text-weight-bold">
                        <td>Descrição</td>
                        <td>Status</td>
                        <td>Opções</td>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($dbDados as $value): ?>

                        <tr>
                            <td><?= $value['descricao'] ?></td>
                            <td><?= $value['statusRegistro'] == 1 ? "Ativo" : "Inativo" ?></td>
                            <td>
                                <a href="<?= SITEURL ?>/categoria/form/view/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" 
                                title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>    

                                <a href="<?= SITEURL ?>/categoria/form/update/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" 
                                title="Alterar"><i class="fa fa-file" aria-hidden="true"></i></a>    

                                <a href="<?= SITEURL ?>/categoria/form/delete/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" 
                                title="Excluir"><i class="fa fa-trash" aria-hidden="true"></i></a>                               
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
	</section>
</div>

<?= Formulario::getDataTables("tbListaCategoria") ?>

<?= $this->loadView("comuns/rodape") ?>