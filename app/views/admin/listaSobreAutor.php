<?php  

use App\Library\Formulario;

echo $this->loadView("comuns/cabecalho");
echo $this->loadView("comuns/menu");

echo Formulario::titulo(
                        "Sobre o Autor", 
                        [
                            "controller" => $this->getController(), 
                        ]);

?>

<script type="text/javascript" src="<?= SITEURL ?>assets/DataTables/datatables.min.js"></script>

<div class="container">

    <div class="table-responsive">

        <table id="tbListaAutor" class="table table-hover table-bordered table-striped table-sm">

            <thead>
                <tr class="text-weight-bold">
                <td>Nome</td>
                <td>Cargo</td>
                <td>Status</td>
                <td>Opções</td>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($dbDados as $value): ?>
                        <tr>
                            <td><?= $value['nome'] ?></td>
                            <td><?= $value['cargo'] ?></td>
                            <td><?= $value['statusRegistro'] == 1 ? "Ativo" : "Inativo" ?></td>
                            <td>
                                <a href="<?= SITEURL ?>sobreautor/form/view/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>  
                                <a href="<?= SITEURL ?>sobreautor/form/update/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Alterar"><i class="fa fa-file" aria-hidden="true"></i></a>  
                                <a href="<?= SITEURL ?>sobreautor/form/delete/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Excluir"><i class="fa fa-trash" aria-hidden="true"></i></a>                
                            </td>
                        </tr>
                <?php endforeach; ?>
        
            </tbody>

        </table>

    </div>

</div>

<?= $this->loadView("comuns/rodape") ?>