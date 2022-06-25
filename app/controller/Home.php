<?php

use App\Library\ControllerMain;
use App\Library\Redirect;
use App\Library\Session;
use App\Library\Email;

class Home extends ControllerMain
{
    public function index()
    {
        $NoticiaModel = $this->loadModel('Noticia');
        $CategoriaModel = $this->loadModel('Categoria');

        $tamanhoPagina = 3;
        $inicio = 0;
        $aFiltro = [
            "categoria_id"  => 0,
            "pagina"        => 1,
            "totalPaginas"  => 1
        ];

        // Carrega menu Categorias
        $CategoriaModel->menuCategoria();
        //

        $totalRegistros             = $NoticiaModel->listaNoticiasHome(0, $this->getId());
        $aFiltro["totalPaginas"]    = ceil($totalRegistros / $tamanhoPagina);

        if (isset($this->dados['get']['parametros'])) {

            $parametros = explode("/", $this->dados['get']['parametros']);

            if (isset($parametros[3])) {
                $aFiltro["categoria_id"] = $parametros[3];
            }

            if (isset($parametros[2])) {
                if ($parametros[2] == "pagina") {
                    $aFiltro["pagina"] = $parametros[4];
                }
            }

        }

        if ($aFiltro["pagina"] > 0) {
            $inicio = ($aFiltro["pagina"] - 1) * $tamanhoPagina;
        }

        $this->loadHelper("datas");
        
        $this->loadView("home", [
            'aFiltro' => $aFiltro,
            "aNoticia" => $NoticiaModel->listaNoticiasHome(1, $aFiltro["categoria_id"], $inicio, $tamanhoPagina),                       // Carregando notícias
            "aCategoriaQtde" => $NoticiaModel->CategoriaQuantidadeNoticias(),       // Carregando Categorias e quantidade de notícias
            "aMaisPopular" => $NoticiaModel->NoticasMaisPopulares()
        ]);
    }

    /**
     * sobreoAutor
     *
     * @return void
     */
    public function sobreoAutor() 
    {
        $NoticiaModel = $this->loadModel('Noticia');
        $CategoriaModel = $this->loadModel('Categoria');
        $SobreAutorModel = $this->loadModel('SobreAutor');

        $this->loadView("sobre-o-autor", [
            'aFiltro' =>    ["categoria_id" => 0, "pagina" => 1],
            'aAutor' => $SobreAutorModel->getAutorAtivo(),
            "aCategoriaQtde" => $NoticiaModel->CategoriaQuantidadeNoticias(),       // Carregando Categorias e quantidad de notícias
            "aMaisPopular" => $NoticiaModel->NoticasMaisPopulares()
        ]);
    }

    /**
     * contato
     *
     * @return void
     */
    public function contato()
    {
        $this->loadView("contato");
    }

    /**
     * contatoEnviaEmail
     *
     * @return void
     */
    public function contatoEnviaEmail()
    {
        $post = $this->getPost();

        $lRetMail = Email::enviaEmail(
            $post['email'],                             /* Email do Remetente*/
            $post['nome'],                              /* Nome do Remetente */
            $post['assunto'],                           /* Assunto do e-mail */
            $post['mensagem'],                          /* Corpo do E-mail */
            "aldecirfonseca@gmail.com"                  /* Destinatário do E-mail */
        );

        if ($lRetMail) {
            return Redirect::page("Home/contato", ["msgSucesso" => "E-mail de contato enviado com sucesso, por favor aguarde que em breve retornaremos."]);
        } else {
            return Redirect::page("Home/contato", ["msgErros" => "Error ao tentar enviar o e-mail"]);
        }
    }

    /**
     * login
     *
     * @return void
     */
    public function login()
    {
        $this->loadView("admin/login");
    }

    /**
     * homeAdmin
     *
     * @return void
     */
    public function homeAdmin()
    {
        $this->loadView("admin/homeAdmin");
    }

    /**
     * NoticiaLida
     *
     * @return void
     */
    public function noticiaLida()
    {
        $NoticiaLidaModel = $this->loadModel('NoticiaLida');

        if (isset($this->dados['get']['parametros'])) {

            $parametros = explode("/", $this->dados['get']['parametros']);

            if ($this->getAcao() == 'Marcar') {         // Marca notícia como lida

                $NoticiaLidaModel->insert([
                    "usuario_id" => Session::get('userCodigo') ,
                    "noticia_id" => $parametros[6]
                ]);
    
            } else {                                    // Desmarca noticia lida
    
                $NoticiaLidaModel->delete($parametros[6]);
    
            }
            
            if ($parametros[7] == "h") {
                return Redirect::page('Home/Index/pagina/' . $parametros[3] . '/' . $parametros[4] . '/' . $parametros[5] . '/' . $parametros[6] . '/' . $parametros[7]);
            } else {
                return Redirect::page('Home/noticiaDetalhe/view/' . $parametros[3] . '/' . $parametros[4] . '/' . $parametros[5] . '/' . $parametros[6] . '/' . $parametros[7]);
            }
    
            

        } else {
            return Redirect::page("Home");
        }
    }

    /**
     * noticiaDetalhe
     *
     * @return void
     */
    public function noticiaDetalhe()
    {
        $NoticiaModel = $this->loadModel('Noticia');
        $CategoriaModel = $this->loadModel('Categoria');
        $NoticiaComentarioModel = $this->loadModel("NoticiaComentario");

        $this->loadHelper("datas");

        if (isset($this->dados['get']['parametros'])) {

            $parametros = explode("/", $this->dados['get']['parametros']);

            // Recupera dados da noticia para pegar quantidade de visualizações
            $aAtual = $NoticiaModel->getById($parametros[5]);

            // Atualiza quantidade de visualizações
            $NoticiaModel->update($parametros[5], ['qtdVisualizacao' => ($aAtual['qtdVisualizacao'] + 1)]);

            $this->loadView("noticia-detalhe", [
                'aFiltro' => [
                    "categoria_id"  => $parametros[3],
                    "pagina"        => $parametros[4]
                ],
                "aNoticia"          => $NoticiaModel->noticiasIdDetalhe($parametros[5]),                // Carregando notícias
                "aCategoriaQtde"    => $NoticiaModel->CategoriaQuantidadeNoticias(),                    // Carregando Categorias e quantidad de notícias
                "aMaisPopular"      => $NoticiaModel->NoticasMaisPopulares(),                           // Notícias mais populares
                "aComentario"       => $NoticiaComentarioModel->getComentarioNoticia($parametros[5])    // Comentários da Noticia
            ]);

        } else {
            return Redirect::page("Home");
        }           
    }
}