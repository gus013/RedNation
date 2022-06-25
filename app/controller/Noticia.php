<?php

use App\Library\ControllerMain;
use App\Library\Redirect;
use App\Library\UploadImages;
use App\Library\Session;
use App\Library\Validator;

class Noticia extends ControllerMain
{
    public $title = 'Notícia';

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
        $this->loadView(
            'admin/listaNoticia',
            $this->model->getAll()
        );
    }

    /**
     * form
     *
     * @return void
     */
    public function form()
    {
        $this->loadHelper('Formulario');
        
        // load do model Categoria
        $categoria = $this->loadModel('Categoria');

        $this->loadView(
            'admin/formNoticia',
            [
                'categoria' => $categoria->lista(),
                'noticia' => $this->model->getById($this->getId()),
                'noticiaCategoria' => $this->model->getNoticiaCategoria($this->getId())
            ]
        );
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
            return Redirect::page("noticia/form/insert");
        } else {

            if (!isset($post['categoria'])) {
                Session::set( 'errors' , [ "categoria" => "Selecione ao menos uma categoria para a notícia."] );
                Session::set( 'inputs' , $post );
                return Redirect::page("noticia/form/update/" . $post['id'] );
            } else {

                // pega o nome com codigo aleatorio gerado pela lib
                $nomeRetornado = UploadImages::upload($_FILES, 'noticias');

                // se não for boolean, significa que está tudo OK
                if (!is_bool($nomeRetornado)) {

                    if ($this->model->insertNoticia($post, $nomeRetornado)) {
                        return Redirect::page('noticia', ['msgSucesso' => 'Notícia gravada com sucesso.']);
                    } else {
                        return Redirect::page('noticia/form/insert', ['msgError' => 'Falha ao tentar gravar a notícia na base de dados.']);
                    }

                } else {
                    Session::set( 'inputs' , $post );
                    return Redirect::page('noticia/form/insert', ['msgError' => 'Falha ao fazer upload.']);
                }
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
            return Redirect::page("noticia/form/update/" . $post['id'] );
        } else {

            if (!isset($post['categoria'])) {
                Session::set( 'errors' , [ "categoria" => "Selecione ao menos uma categoria para a notícia."] );
                Session::set( 'inputs' , $post );
                return Redirect::page("noticia/form/update/" . $post['id'] );
            } else {

                $nomeArquivo = "";

                // se foi anexada alguma imagem
                if (!empty($_FILES['imagem']['name'])) {
                    /*envia para o método de upload o $_FILES, a pasta
                    para salvar o arquivo e o nome do arquivo antigo*/
                    $nomeArquivo = UploadImages::upload($_FILES, 'noticias', $post['nomeImagem']);;
                } else {
                    $nomeArquivo = $post['nomeImagem'];
                }

                if ($this->model->updateNoticia($post, $nomeArquivo)) {
                    return Redirect::Page("noticia", ['msgSucesso' => 'Notícia atualizada com sucesso.']);
                } else {
                    return Redirect::page("noticia/form/update/" . $post['id'], ['msgError' => 'Falha ao tentar atualizar a notícia na base de dados.'] );
                }

            }
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

        if ($this->model->deleteNoticia($post['id'])) {
            
            UploadImages::delete($post['nomeImagem'], 'noticias');

            $_SESSION['msgSucesso'] = 'Notícia excluída com sucesso.';
        } else {
            $_SESSION['msgError'] = 'Falha ao tentar excluir a notícia na base de dados.';
        }

        return Redirect::Page("noticia");
    }

    /**
     * comentarioInsert
     *
     * @return void
     */
    public function comentarioInsert()
    {
        $NoticiaComentarioModel = $this->loadModel("NoticiaComentario");

        $post = $this->getPost();

        if ($NoticiaComentarioModel->insert([
            "usuario_id"    => Session::get("userCodigo"),
            "noticia_id"    => $post['noticia_id'],
            "texto"         => $post['texto']            
        ])) {

            return Redirect::page(
                'Home/noticiaDetalhe/view/' . $post['categoria_id'] . '/' . $post['pagina'] . '/' .  $post['noticia_id'],
                ['msgSucesso' => 'Comentário registrado com sucesso.']
        );

        } else {

            return Redirect::page(
                'Home/noticiaDetalhe/view/' . $post['categoria_id'] . '/' . $post['pagina'] . '/' .  $post['noticia_id'],
                ['msgError' => 'Falha ao tentar registrar o Comentário, favor tentar mais tarde.']
            );
        }
    }
}
