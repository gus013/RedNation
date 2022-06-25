<?php

use App\Library\ModelMain;
use App\Library\Session;

class CategoriaModel extends ModelMain
{
    public $table = "categoria";

    // Validação dos campos
    public $validationRules = [
        "descricao"  => [
            "label" => 'Descrição',
            "rules" => 'required|min:3|max:50'
        ],
        "statusRegistro"  => [
            "label" => 'Status',
            "rules" => 'required|integer'
        ],
    ]; 

    /**
     * lista
     *'
     * @return array
     */
    public function lista()
    {
        $aDados = $this->db->query(
            $this->table, 
            "all",
            [
                "orderby"   => ["descricao"]
            ]
        );
        
        return $aDados;
    }

    /**
     * menuCategorias
     *
     * @return boolean
     */
    public function menuCategoria()
    {
        if (Session::get('aMenuCategorias') == "") {
            $aDados = $this->db->query(
                $this->table, 
                "all",
                [
                    "where"     => ['statusRegistro' => 1],
                    "orderby"   => ["descricao"]
                ]
            );

            Session::set("aMenuCategorias", $aDados);
        }

        return true;
    }
}