<?php

namespace App\Library;

class ModelMain
{
    protected $db;
    public $table;
    public $validationRules;
    
    /**
     * construct
     */
    public function __construct()
    {
        $this->db = new Database();
        $validationRules = [];
    }

    /**
     * getById
     *
     * @param integer $id 
     * @return array
     */
    public function getById($id)
    {
        return $this->db->query(
            $this->table,
            'first',
            ['where' => ["id" => $id]]
        );
    }

    /**
     * insert
     *
     * @param array $dados 
     * @return boolean
     */
    public function insert($dados) 
    {
        $rsc = $this->db->insert($this->table, $dados);

        if ($rsc > 0) {
            return true;
        } else {
            return false;
        }
    } 

    /**
     * update
     *
     * @param array $dados 
     * @return boolean
     */
    public function update($id, $dados) 
    {
        $rsc = $this->db->update($this->table, ["id" => $id], $dados);

        if ($rsc > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * delete
     *
     * @param integer $id 
     * @return boolean
     */
    public function delete($id) 
    {
        $rsc = $this->db->delete($this->table, ["id" => $id]);

        if ($rsc > 0) {
            return true;
        } else {
            return false;
        }
    }
}