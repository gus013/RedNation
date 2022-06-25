<?php

use App\Library\ControllerMain;
use App\Library\Redirect;
use App\Library\Session;
use App\Library\Email;

class Login extends ControllerMain 
{
    public function signIn()
    {
        $UsuarioModel = $this->loadModel("Usuario");
        $post = $this->getPost();

        // super usário
        $superUser = $UsuarioModel->criaSuperUser();

        if ($superUser > 0) {          // 1=Falhou criação do super user; 2=sucesso na criação do super user
            return Redirect::page("home/login");
        }

        // Buscar usuário na base de dados

        $aUsuario = $UsuarioModel->getUserEmail($post['email']);

        if (count($aUsuario) > 0 ) {

            // validar a senha            
            if (!password_verify(trim($post["senha"]), $aUsuario['senha']) ) {
                Session::set("msgError", 'Usuário e ou senha inválido.');
                return  Redirect::page("Home/login");
            }
            
            // validar o status do usuário            
            if ($aUsuario['statusRegistro'] == 2 ) {
                Session::set("msgError", "Usuário Inativo, não será possível prosseguir !");
                return Redirect::page("Home/login");
            }

            //  Criar flag's de usuário logado no sistema
            
            Session::set("userCodigo", $aUsuario['id']);
            Session::set("userLogin", $aUsuario['nome']);
            Session::set("userEmail", $aUsuario['email']);
            Session::set("userNivel", $aUsuario['nivel']);
            
            // Direcionar o usuário para página home
            return Redirect::page("Home/homeAdmin");
            //

        } else {
            Session::set('msgError', 'Usuário e ou senha inválido.');
            return Redirect::page("Home/login");
        }
    }

    /**
     * signOut
     *
     * @return void
     */
    public function signOut()
    {
        Session::destroy('userCodigo');
        Session::destroy('userLogin');
        Session::destroy('userEmail');
        Session::destroy('userNivel');
        
        return Redirect::Page("Home");
    }

    /**
     * solicitaRecuperacaoSenha - Carrega a view para recuperação de senha
     *
     * @return void
     */
    public function solicitaRecuperacaoSenha() 
    {
        $this->loadView("admin/formSolicitaRecuperacaoSenha");
    }

    /*
    *   Envia e-mail com link para recuperação da senha
    */

    public function gerarLinkRecuperaSenha() 
    {
        $post           = $this->getPost();
        $usuarioModel   = $this->loadModel("Usuario");
        
        $user           = $usuarioModel->getUserEmail($post['email']);

        if (!$user) {

            return Redirect::page("Login/solicitaRecuperacaoSenha", [
                "msgErros" => "Não foi possivel localizar o e-mail na base de dados !"
            ]);

        } else {

            $created_at = date('Y-m-d H:i:s');
            $chave      = sha1($user['id'] . $user['senha'] . date('YmdHis', strtotime($created_at)));
            $cLink      = SITEURL . "Login/recuperarSenha/recuperaSenha/" . $chave;

            $corpoEmail = '
                Você solicitou a recuperação de sua senha? <br><br>
                Caso tenha solicitação clique no link a seguir para prosseguir <a href="'. $cLink . '" title="Recuperar a senha">Recuperar a senha</a> <br><br>
                Att: <br><br>
                Equipe Netto Blog
            ';

            $lRetMail = Email::enviaEmail(
                'iigustavow@gmail.com',                               /* Email do Remetente*/
                'REDNATION',                                   /* Nome do Remetente */
                'REDNATION - Recuperação de senha.',    /* Assunto do e-mail */
                $corpoEmail,                                            /* Corpo do E-mail */
                $user['email']                                          /* Destinatário do E-mail */
            );

            if ($lRetMail) {

                // Gravar o link no banco de dados
                $usuarioRecuperaSenhaModel = $this->loadModel("UsuarioRecuperaSenha");

                // Desativando solicitações antigas

                $usuarioRecuperaSenhaModel->desativaChaveAntigas($user["id"]);

                // Inserindo nova solicitação

                $resIns = $usuarioRecuperaSenhaModel->insert([
                    "usuario_id" => $user["id"], 
                    "chave" => $chave,
                    "created_at" => $created_at
                ]);

                if ($resIns) {
                    return Redirect::page("Home/Login", [
                        "msgSucesso" => "Link para recuperação da senha enviado com sucesso! Verifique seu e-mail."
                    ]);   
                } else {
                    return Redirect::page("Login/solicitaRecuperacaoSenha", [
                        "msgErros" => "Ocorreu uma falha ao resgistrar o link de recuperação da senha, favor descartar o e-mail recibido e solictar no link mais tarde."
                    ]);   
                }

            } else {

                return Redirect::page("Login/solicitaRecuperacaoSenha", [
                    "msgErros" => "Não foi possivel enviar o e-mail, favor tentar mais tarde."
                ]);      

            }
        }
    }


    /**
     * recuperarSenha - Abre formulário para chamada da view de recuperação da senha
     *
     * @return void
     */
    public function recuperarSenha()
    {
        $chave = $this->getid();

        $usuarioRecuperaSenhaModel  = $this->loadModel('UsuarioRecuperaSenha');
        $userChave                  = $usuarioRecuperaSenhaModel->getRecuperaSenhaChave($chave);

        if ($userChave) {

            if (date("Y-m-d H:i:s") <= date("Y-m-d H:i:s" , strtotime("+1 hours" , strtotime($userChave['created_at'])))) {

                $usuarioModel = $this->loadModel('Usuario');
                $user           = $usuarioModel->getById($userChave['usuario_id']);

                if ($user) {

                    $chaveRecSenha = sha1($userChave['usuario_id'] . $user['senha'] . date("YmdHis", strtotime($userChave['created_at'])));

                    if ($chaveRecSenha == $userChave['chave']) {

                        $dbDados = [
                            "id"    => $user['id'],
                            'nome'  => $user['nome'],
                            'usuariorecuperasenha_id' => $userChave['id']
                        ];

                        Session::destroy("msgErros");

                        // chave válida

                        $this->loadView("admin/formRecuperarSenha", $dbDados);

                        //

                    } else {
                        // Desativa chave
                        $upd = $usuarioRecuperaSenhaModel->desativaChave($userChave['id']);

                        return Redirect::page("Login/solicitaRecuperacaoSenha", [
                            "msgErros" => "Chave de recuperação da senha inválida."
                        ]); 
                    }

                } else {

                    // Desativa chave
                    $upd = $usuarioRecuperaSenhaModel->desativaChave($userChave['id']);

                    return Redirect::page("Login/solicitaRecuperacaoSenha", [
                        "msgErros" => "Chave de recuperação da senha inválida."
                    ]); 

                }
                
            } else {

                // Desativa chave
                $upd = $usuarioRecuperaSenhaModel->desativaChave($userChave['id']);

                Redirect::page("Login/solicitaRecuperacaoSenha", [
                    "msgErros" => "Chave de recuperação da senha inválida."
                ]); 
            }

        } else {
            Redirect::page("Login/solicitaRecuperacaoSenha", [
                "msgErros" => "Chave de recuperação da senha inválida (1)."
            ]);             
        }
    }

    /**
     * atualizaRecuperaSenha - Atualiza recupera a senha do usuário
     *
     * @return void
     */
    public function atualizaRecuperaSenha() 
    {
        $UsuarioModel = $this->loadModel("Usuario");

        $post           = $this->getPost();
        $userAtual      = $UsuarioModel->getById($post["id"]);
        $dbDados        = $post;
        $dbDados['nome'] = $userAtual['nome'];

        if ($userAtual) {

            if (trim($post["NovaSenha"]) == trim($post["NovaSenha2"])) {

                if ($UsuarioModel->update($post['id'], ['senha' => password_hash(trim($post["NovaSenha"]), PASSWORD_DEFAULT)])) {

                    // Desativa chave
                    $usuarioRecuperaSenhaModel = $this->loadModel('UsuarioRecuperaSenha');

                    $usuarioRecuperaSenhaModel->update($post['usuariorecuperasenha_id'], ['statusRegistro' => 2]);
                    //

                    Session::destroy("msgErros");
                    return Redirect::page("Home/Login", [
                        "msgSucesso"    => "Senha alterada com sucesso !"
                    ]);  

                } else {
                    Session::set("msgErros", "Falha na atualização da nova senha !");
                    $this->loadView("admin/formRecuperarSenha", $dbDados); 
                }

            } else {
                Session::set("msgErros", "Nova senha e conferência da senha estão divergentes !");
                $this->loadView("admin/formRecuperarSenha", $dbDados);                   
            }

        } else {
            Session::set("msgErros", "Usuário inválido !");
            $this->loadView("admin/formRecuperarSenha", $dbDados); 
        }
    }
}