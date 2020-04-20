<?php
    // CLASSE GESTORA DA BASE DE DADOS
    class Gestor{
            
        private $db_server = 'localhost';
        private $db_name = 'ajax_bd';
        private $db_charset = 'utf8';
        private $db_username = 'root';
        PRIVATE $db_password = '';
        
        // CRUD - Create Read Update Delete
        //==================================================================
        public function EXE_QUERY($query, $parameters = null, $debug = true, $close_connection = true){
            // Executa a conexão a Database (READ/SELECT)
            $results = null;

            // Conexão
            $connection = new PDO(
                'mysql:host='.$this->db_server.
                ';dbname='.$this->db_name.
                ';charset='.$this->db_charset,
                $this->db_username,
                $this->db_password,
                array(PDO::ATTR_PERSISTENT => true));      
                
            if($debug){
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }

            // Execução
            try {
                if ($parameters != null) {
                    $gestor = $connection->prepare($query);
                    $gestor->execute($parameters);
                    $results = $gestor->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $gestor = $connection->prepare($query);
                    $gestor->execute();
                    $results = $gestor->fetchAll(PDO::FETCH_ASSOC);
                }
            } catch (PDOException $e) {        
                return false;
            }

            // Fecha Conexão
            if ($close_connection) {
                $connection = null;
            }

            // Retorna Resultados
            return $results;
        }

        //==================================================================
        public function EXE_NON_QUERY($query, $parameters = null, $debug = true, $close_connection = true){
            // Executa a Query a Database (CREATE/INSERT, UPDATE, DELETE)

            // Conexão
            $connection = new PDO(
                'mysql:host='.$this->db_server.
                ';dbname='.$this->db_name.
                ';charset='.$this->db_charset,
                $this->db_username,
                $this->db_password,
                array(PDO::ATTR_PERSISTENT => true));   

            if($debug){
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }
            
            // Execução
            $connection->beginTransaction();
            try {
                if ($parameters != null) {
                    $gestor = $connection->prepare($query);
                    $gestor->execute($parameters);
                } else {
                    $gestor = $connection->prepare($query);
                    $gestor->execute();
                }
                $connection->commit();
            } catch (PDOException $e) {            
                $connection->rollBack();
                return false;
            }

            // Fecha Conexão
            if ($close_connection) {
                $connection = null;
            }
            
            return true;
        }
    }
?>