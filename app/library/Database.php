<?php
namespace App\Library;

use PDO;
use PDOException;
    class Database 
    {
        private static $dbDrive  = "";
        private static $host     = "";
        private static $port     = "";
        private static $user     = "";
        private static $password = "";
        private static $db       = "";        
        
        /**
         * Método construtor do banco de dados
         */
        public function __construct(
            $db_drive = DB_DRIVE, 
            $db_host = DB_HOST, 
            $db_port = DB_PORT, 
            $db_user = DB_USER, 
            $db_password = DB_PASSWORD, 
            $db_bdados = DB_BDADOS 
        ) {  
            self::$dbDrive  = $db_drive;
            self::$host     = $db_host;
            self::$port     = $db_port;
            self::$user     = $db_user;
            self::$password = $db_password;
            self::$db       = $db_bdados;   
        }

        /*Evita que a classe seja clonada*/
        private function __clone() {
            
        }

        /*Método que destroi a conexão com banco de dados e 
            remove da memória todas as variáveis setadas*/
        public function __destruct() {
            $this->disconnect();
            foreach ($this as $key => $value) {
                unset($this->$key);
            }
        }

        /*Metodos que trazem o conteudo da variavel desejada
        @return   $xxx = conteudo da variavel solicitada*/
        private function getDBDrive()  {return self::$dbDrive;}
        private function getHost()    {return self::$host;}
        private function getPort()    {return self::$port;}
        private function getUser()    {return self::$user;}
        private function getPassword(){return self::$password;}
        private function getDB()      {return self::$db;}

        public  function connect()
        {
            try {
                
                if ( $this->getDBDrive() == 'mysql' ) {            // MySQL

                    $this->conexao = new PDO(
                                            $this->getDBDrive().":host=".$this->getHost().";port=".$this->getPort().";dbname=".$this->getDB(), 
                                            $this->getUser(), 
                                            $this->getPassword(),
                                            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
                                        );

                } else if ( $this->getDBDrive() == 'sqlsrv' ) {        // SQL Server
                    $this->conexao = new PDO($this->getDBDrive().":Server=".$this->getHost().",".$this->getPort().";DataBase=".$this->getDB(), $this->getUser(), $this->getPassword());
                }

            } catch (PDOException $i) {
                //se houver exceçao, exibe
                die("Erro: <code>" . $i->getMessage() . "</code>");
            }

            return ($this->conexao);
            
        }

        private function disconnect(){
            $this->conexao = null;
        }

        protected function getCampos(array $campos, $conector = ",")
        {
            $save['sql'] = "";
            $virgula = false;

            foreach ($campos as $key => $value) {
                $juncao = " " . $conector . " ";
                $sinal = " = ";

                if (strtoupper(substr(trim($key), 0, 2)) == "OR") {
                    $juncao = " OR ";
                    $key    = substr(trim($key), 3);
                } 

                if (strtoupper(substr(trim($key), strlen(trim($key)) -2 , 2)) == "<>") {
                    $sinal = " <> ";
                    $key = trim(str_replace('<>', "", $key));
                }

                $save['sql'] .= ($virgula ? $juncao : "" ) . "`" . $key . "` " . $sinal . " :" . $key . " ";
                $save['dados'][":" . $key] = $value;
                $virgula = true;
            }

            return $save;
        }


        /**
         * Método select que retorna um array de objetos
        *   @param string $sql
        *   @param array $params
        *   @return void
         */
        
        public function dbSelect( $sql , $params = null )
        {
            if ((gettype($params) != 'array') && (gettype($params) != "NULL") ) {
                $params = [$params];
            }
            
            $query = $this->connect()->prepare( $sql , array( PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL ) );
            $query->execute( $params );
            $rs = $query;
            
            self::__destruct();
            
            return $rs;
            
        }
        
        /**
         * query
         *
         * @param string $table 
         * @param string $tipo 
         * @param array $configs 
         * @return void
         */
        public function query($table, $tipo = "all", array $configs = [])
        {
            $save['sql'] = "";
            $save["dados"] = [];
            $save["save"] = [];
            $campos = "";

            // select

            if (!isset($configs['campos'])) {
                $campos = "*";
            } else {
                $total = count($configs['campos']);
                $i = 1;

                foreach ($configs['campos'] AS $value) {
                    $campos .= '`' . $value . '`';

                    if ($i != $total) {
                        $campos .= ", "; 
                    }

                    $i++;
                }
            }

            // where

            if (isset($configs["where"])) {
                $ret = $this->getCampos($configs['where'], "AND");
                $save["sql"] .=  "WHERE " . $ret['sql'];
                $save["save"] = array_merge($ret["dados"], $save["dados"]);
            }

            // group by

            if (isset($configs['groupby'])) {
                $ret    = '';
                $total  = count($configs['groupby']);
                $i      = 1;

                foreach ($configs['groupby'] AS $value) {
                    $ret .= "`" . $value . "`";

                    if ($i != $total) {
                        $ret .= ", ";
                    }

                    $i++;
                }

                $save['sql'] .= "GROUP BY " . $ret;
            }

            // order by

            if (isset($configs['orderby'])) {

                $ret = '';
                $total = count($configs['orderby']);
                $i = 1;

                foreach ($configs['orderby'] as $v) {
                    $ordem = '';

                    if (strpos($v, ' DESC') != false){
                        $ordem = 'DESC';
                        $v = str_replace(' DESC', "" , $v);
                    }

                    $ret .= "`" . $v . "`" . $ordem;

                    if ($i != $total) {
                        $ret .= ", ";
                    }

                    ++$i;
                }

                $save['sql'] .= "ORDER BY " . $ret;
            }

            $sql = "SELECT " . $campos . " FROM `" . $table . "`" . $save['sql'] . ";";

            $query = $this->connect()->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
            $rscDados = $query->execute($save['save']);

            if ($tipo == 'first') {
                return $this->dbBuscaArray($query);
            } elseif ($tipo == "all") {
                return $this->dbBuscaArrayAll($query);
            } elseif ($tipo == "count") {
                return $this->dbNumeroLinhas($query);
            }
        }
        
        /*
         * Método insert que insere valores no banco de dados e retorna o último id inserido
         */
        
        public function dbInsert( $sql , $params = null )
        {
            try {        
                $conexao = $this->connect();
                $query   = $conexao->prepare( $sql );
                $query->execute( $params );
                
                $rs      = $conexao->lastInsertId(); // or die(print_r($query->errorInfo(), true));
                
                self::__destruct();
                
                return $rs;

            } catch (\Exception $e) {
                echo 'Exceção capturada: '.  $e->getMessage(); exit;
            }         
        }

        /**
         * insert
         *
         * @param string $table 
         * @param array $campos 
         * @return integer
         */
        public function insert($table, $campos = [])
        {
            try {

                $save = $this->getCampos($campos);
                $fields = implode("` , `", array_keys($campos));
                $values = implode(" , ", array_keys($save['dados']));

                $sql = 'INSERT INTO `' . $table . '` (`' . $fields . '`) VALUES (' . $values . ')';

                $conexao    = $this->connect();
                $query      = $conexao->prepare($sql);
                $query->execute($save["dados"]);
    
                $rs = $conexao->lastInsertId();
    
                self::__destruct();
                
            } catch (\Exception $exc) {
                echo "Erro ao Inserir Registro, favor entrar em contato com Suporte Técnico" . $exc->getTraceAsString(); exit;
            }

            return $rs;
        }

        /* Método update que altera valores do banco de dados e retorna o número de linhas afetadas */
        
        public function dbUpdate( $sql , $params = null )
        {
            $query=$this->connect()->prepare($sql);
            $query->execute($params);
            
            $rs = $query->rowCount() or die(print_r($query->errorInfo(), true));
            self::__destruct();            
            
            return $rs;            
        }

        /**
         * update
         *
         * @param string $table 
         * @param array $conditions 
         * @param array $campos 
         * @return integer
         */
        public function update($table, $conditions, $campos)
        {
            $save       = $this->getCampos($campos);
            $condWhere  = $this->getCampos($conditions);

            $save['save'] = array_merge($save['dados'], $condWhere['dados']);

            $sql = "UPDATE `" . $table . "` SET " . $save["sql"] . " WHERE " . $condWhere["sql"] . ";";

            $query = $this->connect()->prepare($sql);
            $query->execute($save["save"]);

            $rs = $query->rowCount(); // or die(print_r($query->errorInfo(), true));
            self::__destruct();

            return $rs;
        }

        /*
         * Método delete que exclusão valores do banco de dados retorna o número de linhas afetadas
         */
        
        public function dbDelete($sql,$params=null)
        {            
            $query = $this->connect()->prepare($sql);
            
            try {                
                $query->execute($params);
                $rs = $query->rowCount();                 
            } catch (\Exception $exc) {
                echo "Erro ao Excluir Registro, favor entrar em contato com Suporte Técnico" . $exc->getTraceAsString();
            }

            self::__destruct();
            
            if ($rs == array()) {
                return false;
            } else {
                return $rs;
            }
        }

        /**
         * delete
         *
         * @param string $table 
         * @param array $conditions 
         * @return void
         */
        public function delete($table, $conditions)
        {
            $save = $this->getCampos($conditions);
            $sql  = "DELETE FROM {$table} WHERE " . $save['sql'] . ";";

            $query = $this->connect()->prepare($sql);

            try {
                $query->execute($save['dados']);
                $rs = $query->rowCount() || die(print_r($query->errorInfo(), true));
            } catch (\Exception $exc) {
                echo "Error ao excluir registro, favor entrar em contato com suporte técnico: " . $exc->getTraceAsString();
            }

            self::__destruct();

            if ($rs == []) {
                return false;
            } else {
                return $rs;
            }
        }
    
        /*
         * Método que retornar a posição atual do registro (OBJ)
         */

        public function dbBuscaDados( $rscPdo )
        {
            return $rscPdo->fetch(PDO::FETCH_OBJ);
        }
        
        /*
         * Método que retornar todos os registros (OBJ)
         */

        public function dbBuscaDadosAll( $rscPdo )
        {
            return $rscPdo->fetchAll(PDO::FETCH_OBJ);
        }
        
        /*
         * Método que retornar a posição atual do registro (matriz)
         */

        public function dbBuscaArray( $rscPdo )
        {
            return $rscPdo->fetch(PDO::FETCH_ASSOC);
        }
        
        /*
         * Método que retornar a posição atual do registro (matriz)
         */

        public function dbBuscaArrayAll( $rscPdo )
        {
            return $rscPdo->fetchall(PDO::FETCH_ASSOC);
        }
        
        /*
         * Método que retornar o Numero de linhas Selecionadas
         */
        
        public function dbNumeroLinhas( $rscPdo )
        {
            return $rscPdo->rowCount();
        }

        /*
         * Método que retornar o Numero de Colunas Selecionadas
         */
        
        public function dbNumeroColunas( $rscPdo )
        {
            return $rscPdo->columnCount();
        }            
        
        public function dbResultado( $rscRes , $CampoRetorno )
        {
            $rowResX = $this->dbBuscaArray( $rscRes );
            
            return $rowResX[ $CampoRetorno ];
        }

    }