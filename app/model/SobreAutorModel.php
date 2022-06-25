<?php

use App\Library\ModelMain;

class SobreAutorModel extends ModelMain
{
    public $table = "sobreoautor";

    // Validação dos campos
    public $validationRules = [
        "nome"  => [
            "label" => 'Nome',
            "rules" => 'required|min:3|max:50'
        ],
        "cargo"  => [
            "label" => 'Cargo',
            "rules" => 'required|min:3|max:50'
        ],
        "texto"  => [
            "label" => 'Texto',
            "rules" => 'required|min:3'
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
                "orderby"   => ["nome"]
            ]
        );
        
        return $aDados;
    }


    /**
     * getAutorAtivo
     *
     * @return void
     */
    public function getAutorAtivo()
    {
        $sql = "
            SELECT *
            FROM {$this->table}
            WHERE statusRegistro = 1
            ORDER BY id DESC 
        ";

        $rsc = $this->db->dbSelect($sql);

        $aDados = $this->db->dbBuscaArray($rsc);

        return $aDados;
    }
}