<?php

use App\Library\ControllerMain;
use App\Library\Redirect;
use App\Library\Session;
use App\Library\Validator;

class Categoria extends ControllerMain
{
    /**
     * construct
     *
     * @param mixed $dados 
     */
    public function __construct($dados)
    {
        $this->auxiliarConstruct($dados);

        // Somente pode ser acessado por usuários adminsitradores
        if (!$this->getAdministrador()) {
            return Redirect::page("Home");
        }
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //$this->getAdministrador();
        $this->loadView("admin/listaCategoria", $this->model->lista());
    }

    /**
     * form
     *
     * @return void
     */
    public function form()
    {
        $this->loadHelper("formulario");

        $aDados = [
            "statusRegistro" => 1
        ];

        // recuperar os dados do $id
        if ($this->getAcao() != "insert") {
            $aDados = $this->model->getById($this->dados['id']);
        }

        $this->loadView("admin/formCategoria", $aDados);
    }

    /**
     * insert
     *
     * @return void
     */
    public function insert()
    {
        $post = $this->getPost();

        // Valida dados recebidos do formulário
        if (Validator::make($post, $this->model->validationRules)) {
            return Redirect::page("categoria/form/insert");
        } else {

            if ($this->model->insert(            [
                "descricao" => $post['descricao'],
                "statusRegistro" => $post['statusRegistro']
            ])) {
                Session::set("msgSucesso", "Registro inserido com sucesso.");
                Session::destroy("aMenuCategorias");
                $this->model->menuCategoria();
            } else {
                Session::set('msgError', 'Falha ao tentar inserir o registro na base de dados.');
            }
    
            return Redirect::page("categoria");
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
            return Redirect::page("categoria/form/update");
        } else {

            if ($this->model->update(
                    $post["id"],
                    [
                    "descricao" => $post["descricao"],
                    "statusRegistro" => $post['statusRegistro']
                    ]
            )) {
                Session::set("msgSucesso", "Registro atualizado com sucesso.");
                Session::destroy("aMenuCategorias");
                $this->model->menuCategoria();
            } else {
                Session::set('msgError', 'Falha ao tentar atualizar o registro na base de dados.');
            }

            return Redirect::page("categoria");
        }
    }

    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        $post = $this->getPost();

        if ($this->model->delete($post['id'])) {
            Session::set("msgSucesso", "Registro excluído com sucesso.");
            Session::destroy("aMenuCategorias");
            $this->model->menuCategoria();
        } else {
            Session::set('msgError', 'Falha ao tentar excluir o registro na base de dados.');
        }

        Redirect::page("categoria");
    }
}