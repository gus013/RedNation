<?php

use App\Library\ControllerMain;
use App\Library\Redirect;
use App\Library\Session;
use App\Library\Validator;
use App\Library\UploadImages;

class SobreAutor extends ControllerMain
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
        $this->loadView("admin/listaSobreAutor", $this->model->lista());
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
            $aDados = $this->model->getById($this->getId());
        }

        $this->loadView("admin/formSobreAutor", $aDados);
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
            return Redirect::page("SobreAutor/form/update");
        } else {

            // pega o nome com codigo aleatorio gerado pela lib
            $nomeRetornado = UploadImages::upload($_FILES, 'autor');

            // se não for boolean, significa que está tudo OK
            if (!is_bool($nomeRetornado)) {

                if ($this->model->insert([
                        "nome"              => $post["nome"],
                        "cargo"             => $post["cargo"],
                        "texto"             => $post["texto"],
                        "statusRegistro"    => $post['statusRegistro'],
                        "linkFacebook"      => $post["linkFacebook"],
                        "linkInstagram"     => $post["linkInstagram"],
                        "linkTwitter"       => $post["linkTwitter"],
                        "linkLinkedin"      => $post["linkLinkedin"],
                        "texto"             => $post["texto"],
                        "foto"              => $nomeRetornado       
                ])) {
                    return Redirect::page("SobreAutor", ["msgSucesso" => "Registro atualizado com sucesso."]);
                } else {
                    Session::set( 'inputs' , $post );
                    return Redirect::page('SobreAutor/form/insert', ['msgError' => 'Falha ao tentar atualizar o registro na base de dados.']);
                }

            } else {
                Session::set('inputs' , $post);
                return Redirect::page('SobreAutor/form/insert', ['msgError' => 'Falha ao fazer upload.']);
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
            return Redirect::page("SobreAutor/form/update");
        } else {

            $nomeArquivo = "";

            // se foi anexada alguma imagem
            if (!empty($_FILES['fotoFile']['name'])) {
                /*envia para o método de upload o $_FILES, a pasta
                para salvar o arquivo e o nome do arquivo antigo*/
                $nomeArquivo = UploadImages::upload($_FILES, 'autor', $post['foto']);
            } else {
                $nomeArquivo = $post['foto'];
            }

            if ($this->model->update(
                    $post["id"],
                    [
                    "nome"              => $post["nome"],
                    "cargo"             => $post["cargo"],
                    "texto"             => $post["texto"],
                    "statusRegistro"    => $post['statusRegistro'],
                    "linkFacebook"      => $post["linkFacebook"],
                    "linkInstagram"     => $post["linkInstagram"],
                    "linkTwitter"       => $post["linkTwitter"],
                    "linkLinkedin"      => $post["linkLinkedin"],
                    "texto"             => $post["texto"],
                    "foto"              => $nomeArquivo
                    ]
            )) {
                Session::set("msgSucesso", "Registro atualizado com sucesso.");
            } else {
                Session::set('msgError', 'Falha ao tentar atualizar o registro na base de dados.');
            }

            return Redirect::page("SobreAutor");
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
        } else {
            Session::set('msgError', 'Falha ao tentar excluir o registro na base de dados.');
        }

        return Redirect::Page("SobreAutor");
    }
}