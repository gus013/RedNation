<?php

use App\Library\ModelMain;
use App\Library\Session;

class NoticiaComentarioModel extends ModelMain
{
    public $table = "noticiacomentario";

    /**
     * lista
     *'
     * @return array
     */
    public function getComentarioNoticia($noticia_id)
    {
        $sql = "SELECT nc.*, u.nome
                FROM noticiacomentario AS nc
                INNER JOIN usuario AS u ON u.id = nc.usuario_id
                WHERE nc.noticia_id = ?
                ORDER BY created_at";

        $rsc = $this->db->dbSelect($sql, [$noticia_id]);

        return $this->db->dbBuscaArrayAll($rsc);   
    }
}