<?php

use App\Library\ModelMain;
use App\Library\Session;

class NoticiaModel extends ModelMain
{
    public $table = "noticia";

    // Validação dos campos
    public $validationRules = [
        "titulo"  => [
            "label" => 'Titulo',
            "rules" => 'required|min:3|max:60'
        ],
        "texto"  => [
            "label" => 'Descrição',
            "rules" => 'required|min:5'
        ],
        "statusRegistro"  => [
            "label" => 'Status',
            "rules" => 'required|integer'
        ],
    ]; 

    /**
     * lista as notícias
     *
     * @return array
     */
    public function getAll($id = '')
    {
        $sql = '';

        if (!empty($id)) {
            $sql = "
                SELECT *
                FROM {$this->table}
                WHERE noticia.id = $id
            ";
        } else {
            $sql = "
                SELECT noticia.*, usuario.nome
                FROM {$this->table}
                INNER JOIN usuario ON usuario.id = noticia.usuario_id
            ";
        }

        $rsc = $this->db->dbSelect($sql);

        $aDados = $this->db->dbBuscaDadosAll($rsc);

        return $aDados;
    }

    /**
     * getNoticiaCategoria
     *
     * @param  int $id
     * @return array
     */
    public function getNoticiaCategoria($id)
    {
        $rsc = $this->db->dbSelect(
            "SELECT nc.categoria_id, c.descricao
            FROM noticiacategoria as nc
            INNER JOIN categoria as c ON nc.categoria_id = c.id
            WHERE nc.noticia_id = ?
            ORDER BY c.descricao",
            [
                $id
            ]
        );

        if ($this->db->dbNumeroLinhas($rsc) > 0) {
            return $this->db->dbBuscaArrayAll($rsc);
        } else {
            return [];
        }
    }

    /**
     * insert
     *
     * @param  array $dados
     * @return boolean
     */
    public function insertNoticia($dados, $nomeImagem)
    {
        // insert tabela noticia
        $rsc = $this->db->insert(
            $this->table, 
            [
                "titulo"            => $dados['titulo'],
                "texto"             => $dados['texto'],
                "statusRegistro"    => $dados['statusRegistro'],
                "imagem"            => $nomeImagem,
                "usuario_id"        => Session::get('userCodigo')
            ]
        );

        foreach ($dados['categoria'] as $categoria) {

            // insert tabela noticiacategoria
            $this->db->insert(
                "noticiacategoria",
                [
                    "noticia_id"    => $rsc ,
                    "categoria_id"  => $categoria
                ]
            );
        }

        if ($rsc > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * update
     *
     * @param  array $dados
     * @return boolean
     */
    public function updateNoticia($dados, $nomeImagem)
    {
        $rsc = 1;

        // select que busca os dados antigos, antes do update
        $select = $this->db->dbSelect(
            "SELECT * FROM noticia WHERE id = ?",
            [
                $dados["id"]
            ]
        );

        $select = $this->db->dbBuscaArrayAll($select);
        $select = $select[0];

        $alterado = false;

        // verifica se alterou algum campo
        if (
            $select["titulo"] != $dados["titulo"] ||
            $select["texto"] != $dados["texto"] ||
            $select["statusRegistro"] != $dados["statusRegistro"] ||
            $select["imagem"] != $nomeImagem
        ) {
            $alterado = true;
        }

        // se foi alterado, da update
        if ($alterado) {

            $rsc = $this->db->update(
                $this->table, 
                [
                    "id" => $dados["id"]
                ], 
                [
                    "titulo"            => $dados["titulo"],
                    "texto"             => $dados["texto"],
                    "statusRegistro"    => $dados["statusRegistro"],
                    "imagem"            => $nomeImagem
                ]
            );
        }

        // deleta todos os registros da tabela noticia categoria da noticia alterada
        $rsc = $this->db->delete("noticiacategoria", ["noticia_id" => $dados["id"]]);

        // insere novamente as categorias selecionadas
        foreach ($dados['categoria'] as $categoria) {

            $rsc3 = $this->db->insert(
                "noticiacategoria", 
                [ 'noticia_id' => $dados["id"], 'categoria_id' => $categoria ]
            );

        }

        if ($rsc > 0 || $rsc3 > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * delete
     *
     * @param  integer $id
     * @return boolean
     */
    public function deleteNoticia($id)
    {
        // delete na tabela noticiacategoria
        $rsc = $this->db->delete("noticiacategoria", ["noticia_id" => $id]);

        // delete na tabela noticia
        $rsc2 = $this->db->delete($this->table, ["id" => $id]);

        if ($rsc > 0 || $rsc2 > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * CategoriaQuantidadeNoticias
     *
     * @return array
     */
    public function CategoriaQuantidadeNoticias()
    {
        $sql = "SELECT nc.categoria_id, c.descricao, COUNT(*) AS qtde
                FROM noticiacategoria AS nc
                INNER JOIN categoria AS c ON c.id = nc.categoria_id
                GROUP BY nc.categoria_id
                ORDER BY c.descricao";

        $rsc = $this->db->dbSelect($sql);

        return $this->db->dbBuscaArrayAll($rsc);       
    }

    /**
     * CategoriaQuantidadeNoticias
     *
     * @return array
     */
    public function NoticasMaisPopulares()
    {
        $sql = "SELECT id, titulo, qtdVisualizacao, imagem
                FROM noticia 
                ORDER BY qtdVisualizacao DESC
                LIMIT 4";

        $rsc = $this->db->dbSelect($sql);

        return $this->db->dbBuscaArrayAll($rsc);       
    }


    /**
     * getNoticiaComentarioQuantidade
     *
     * @param integer $noticia_id 
     * @return integer
     */
    public function getNoticiaComentarioQuantidade($noticia_id)
    {
        $qtde = $this->db->query(
            "noticiacomentario", 
            "count",
            [
                "where"     => ["noticia_id" => $noticia_id]
            ]
        );
        
        return $qtde;
    }
    
    /**
     * lista as notícias
     *
     * @return array
     */
    public function listaNoticiasHome($retorno = 0, $categoria_id = 0, $inicio = 0, $fim = 3)
    {
        $filtra = "";
        $join = "";
        $parametros = [];

        if (($categoria_id != 0)) {
            $join = " LEFT JOIN noticiacategoria AS nc ON nc.noticia_id = noticia.id ";
            $filtra .= " AND nc.categoria_id = ? ";
            $parametros = [$categoria_id];
        }

        $sql = "
            SELECT noticia.*, usuario.nome, nl.id AS idMarcadoLeitura
            FROM {$this->table}
            INNER JOIN usuario ON usuario.id = noticia.usuario_id
            LEFT JOIN noticialida AS nl ON nl.noticia_id = noticia.id
            " . $join . 
            " WHERE noticia.statusRegistro = 1 " .  $filtra . "
            ORDER BY created_at DESC
        ";

        if ($retorno == 1) {
            $sql .= " LIMIT " . $inicio . "," . $fim;
        }

        $rsc = $this->db->dbSelect($sql, $parametros);

        if ($retorno == 0) {
            return $this->db->dbNumeroLinhas($rsc);
        } else {

            $aDados = $this->db->dbBuscaArrayAll($rsc);

            for ($xxx = 0; $xxx < count($aDados); $xxx++) {
                $aDados[$xxx]['aCategoria'] = $this->getNoticiaCategoria($aDados[$xxx]['id']);
                $aDados[$xxx]['qtdeComentarios'] = $this->getNoticiaComentarioQuantidade($aDados[$xxx]['id']);
            }
    
            return $aDados;
        }
    }


    /**
     * lista as notícias
     *
     * @return array
     */
    public function noticiasIdDetalhe($noticia_id)
    {
        $sql = "
            SELECT noticia.*, usuario.nome, nl.id AS idMarcadoLeitura
            FROM {$this->table}
            INNER JOIN usuario ON usuario.id = noticia.usuario_id
            LEFT JOIN noticialida AS nl ON nl.noticia_id = noticia.id
            WHERE noticia.id = ? 
        ";

        $rsc = $this->db->dbSelect($sql, [$noticia_id]);

        $aDados = $this->db->dbBuscaArray($rsc);

        $aDados['aCategoria']       = $this->getNoticiaCategoria($aDados['id']);
        $aDados['qtdeComentarios']  = $this->getNoticiaComentarioQuantidade($aDados['id']);

        return $aDados;
    }
}