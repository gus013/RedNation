<?php

use App\Library\ControllerMain;
use App\Library\Session;
use App\Library\Redirect;
use App\Library\Validator;

class Usuario extends ControllerMain
{
    /**
     * lista
     *
     * @return void
     */
    public function index()
    {
        // Somente pode ser acessado por usuários adminsitradores
        if (!$this->getAdministrador()) {
            return Redirect::page("Home");
        }

        $this->loadView("admin/listaUsuario", $this->model->getLista());
    }

    /**
     * form
     *
     * @return void
     */
    public function form()
    {
        // Somente pode ser acessado por usuários adminsitradores
        if (!$this->getAdministrador()) {
            return Redirect::page("Home");
        }
        
        $dbDados = [];

        if ( $this->getAcao() != 'new') {
            // buscar o usuário pelo $id no banco de dados
            $dbDados = $this->model->getById($this->getId());
        }

        $this->loadView('admin/formUsuario', $dbDados);
    }

    /**
     * new - insere um novo usuário
     *
     * @return void
     */
    public function insert()
    {
        $post = $this->getPost();

        // Valida dados recebidos do formulário
        if (Validator::make($post, $this->model->validationRules)) {
            return Redirect::page("Usuario/form/insert");
        } else {

            if ($this->model->insert([
                "statusRegistro"    => $post['statusRegistro'],
                "nivel"             => $post['nivel'],
                "nome"              => $post['nome'],
                "email"             => $post['email'],
                "senha"             => password_hash($post['senha'], PASSWORD_DEFAULT)
            ])) {
                return Redirect::page("Usuario", ["msgSucesso" => "Usuário inserido com sucesso !"]);
            } else {
                return Redirect::page("Usuario", ["msgErros" => "Falha na inserção dos dados do Usuário !"]);
            }
        }
    }


    /**
     * update
     *
     * @return void
     */    
    public function update()
    {
        $post = $this->getPost();

        // Valida dados recebidos do formulário
        if (Validator::make($post, $this->model->validationRules)) {
            return Redirect::page("Usuario/form/update");
        } else {

            if ($this->model->update($post['id'], [
                "nome"              => $post['nome'],
                "statusRegistro"    => $post['statusRegistro'],
                "nivel"             => $post['nivel'],
                "email"             => $post['email']
            ])) {
                return Redirect::page("Usuario", ["msgSucesso" => "Usuário alterado com sucesso !"]);
            } else {
                return Redirect::page("Usuario", ["msgErros" => "Falha na alteração dos dados do Usuário !"]);
            } 
        }    
    }

    /**
     * delete -   Exclui um usuário no banco de dados
     *
     * @return void
     */
    public function delete()
    {
        $post = $this->getPost();

        if ($this->model->delete($post['id'])) {
            return Redirect::page("Usuario", ["msgSucesso" => "Usuário excluído com sucesso !"]);
        } else {
            return Redirect::page("Usuario", ["msgErros" => "Falha na exclusão do Usuário !"]);
        }   
    }

    /**
     * trocaSenha - Chama a view Trocar a senha
     *
     * @return void
     */
    public function trocaSenha()
    {
        $this->loadView("admin/formTrocaSenha");
    }

    /**
     * atualizaSenha - Atualiza a senha do usuário
     *
     * @return void
     */
    public function atualizaTrocaSenha() 
    {
        $post = $this->getPost();
        $userAtual = $this->model->getById($post["id"]);

        if ($userAtual) {

            if (password_verify(trim($post["senhaAtual"]), $userAtual['senha'])) {

                if (trim($post["novaSenha"]) == trim($post["novaSenha2"])) {

                    $lUpdate = $this->model->update($post['id'], ['senha' => password_hash($post["novaSenha"], PASSWORD_DEFAULT)]);

                    if ($lUpdate) {
                        return Redirect::page("Usuario/trocaSenha", [
                            "msgSucesso"    => "Senha alterada com sucesso !"
                        ]);  
                    } else {
                        return Redirect::page("Usuario/trocaSenha", [
                            "msgErros"    => "Falha na atualização da nova senha !"
                        ]);    
                    }

                } else {
                    return Redirect::page("Usuario/trocaSenha", [
                        "msgErros"    => "Nova senha e conferência da senha estão divergentes !"
                    ]);                  
                }

            } else {
                return Redirect::page("Usuario/trocaSenha", [
                    "msgErros"    => "Senha atual informada não confere!"
                ]);               
            }
        } else {
            return Redirect::page("Usuario/trocaSenha", [
                "msgErros"    => "Usuário inválido !"
            ]);   
        }
    }

    /**
     * perfil
     *
     * @return void
     */
    public function perfil()
    {
        $this->loadHelper("formulario");
        $this->loadView("admin/formPerfil", $this->model->getById(Session::get('userCodigo')));
    }

    /**
     * atualizaPerfil
     *
     * @return void
     */
    public function atualizaPerfil()
    {
        $post = $this->getPost();

        if ($this->model->update($post['id'], ['nome' => $post['nome'], 'email' => $post['email']])) {

            Session::set("userLogin", $post['nome']);
            Session::set("userEmail", $post['email']);

            return Redirect::page("Usuario/perfil", [
                "msgSucesso"    => "Perfil atualizado com sucesso!"
            ]);  

        } else {
            return Redirect::page("Usuario/perfil", [
                "msgErros"    => "Falha na atualização do se perfil, favor tentar novamente mais tarde!"
            ]);  
        }
    }
}