<?php

use App\Library\Formulario;
use App\Library\Session;

echo $this->loadView('comuns/cabecalho');
echo $this->loadView('comuns/menu');

?>

<script type="text/javascript" src="<?= SITEURL; ?>assets/js/usuario.js"></script>

<section>
    <div class="container">
        <div class="blog-banner">
            <div class="mt-5 mb-5 text-left">
                <h1 style="color: #384aeb;">Trocar Senha</h1>
            </div>
        </div>
    </div>
</section>

<div class="container" style="margin-top: 70px;">

    <div class="row justify-content-center">

        <div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 div_login">                    

            <div class="card">

                <div class="card-body">

                    <form method="POST" id="recuperaSenhaform" class="form-horizontal" role="form" 
                        action="<?= SITEURL ?>Usuario/atualizaTrocaSenha">

                        <input type="hidden" name="id" id="id" value="<?= Session::get('userCodigo') ?>">
                        
                        <div style="margin-bottom: 25px" class="input-group">
                            <label class="ml-1">Usuário: <b><?= Session::get('userLogin') ?></b></label>                            
                        </div>

                        <div style="margin-bottom: 25px" class="control-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i> Senha Atual</span>
                            <div class="controls">
                                <input name="senhaAtual" id="senhaAtual" type="password" class="form-control" required="required">
                            </div>
                        </div>

                        <div style="margin-bottom: 25px" class="control-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i> Nova Senha</span>
                            <div class="controls">
                                <input name="novaSenha" id="novaSenha" type="password" class="form-control" required="required"
                                        onkeyup="checa_segur_senha( 'novaSenha', 'msgSenhaNova', 'btEnviar' );">
                                <div id="msgSenhaNova" class="msgNivel_senha"></div>
                            </div>
                        </div>

                        <div style="margin-bottom: 25px" class="control-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i> Confirme a nova senha</span>
                            <div class="controls">
                                <input name="novaSenha2" id="novaSenha2" type="password" class="form-control" placeholder="Nova senha" required="required"
                                        onkeyup="checa_segur_senha( 'novaSenha2', 'msgSenhaNova2', 'btEnviar' );">
                                <div id="msgSenhaNova2" class="msgNivel_senha"></div>
                            </div>
                        </div>

                        <div style="margin-top:10px" class="form-group">
                            <!-- Button -->
                            <div class="col-xs-2 controls">
                                <button class="btn btn-outline-primary btnCustomAzul" id="btEnviar" disabled>Atualizar</button>
                            </div>

                            <div class="col-xs-10 controls mt-2">
                                <?php 

                                    if (!empty(Session::get("msgErros"))) {
                                        ?>
                                        <div class="alert alert-danger" role="alert">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            <?= Session::getDestroy("msgErros") ?>
                                        </div>     
                                        <?php
                                    }

                                    if (!empty(Session::get("msgSucesso"))) {
                                        ?>                                    
                                        <div class="alert alert-success" role="alert">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            <?= Session::getDestroy("msgSucesso") ?>
                                        </div>      
                                        <?php
                                    }
                                ?>
                            </div>

                        </div>

                    </form>     

                </div>
            </div>

            <br>
            <br>

        </div>  

    </div>
    
</div>  

<?= $this->loadView('comuns/rodape') ?>