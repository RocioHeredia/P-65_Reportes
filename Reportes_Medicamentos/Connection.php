<?php

    class Connection {
        private $host = 'localhost';
        private $user = 'root';
        private $password = '';
        private $db = 'dbs65-proyecto-salud';
        private $conect;

        public function __construct() {
            $conecctionString = 'mysql:host=' .$this->host.';dbname='.$this->db.';charset=utf8';
            try {
                $this->conect = new PDO($conecctionString, $this->user, $this->password);
                $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (Exception $e) {
                $this->conect = 'Error de Conexión';
                echo 'ERROR: '. $e->getMenssage();
            }
        }

        public function connect(){
            return $this->conect;
        }
    }
?>