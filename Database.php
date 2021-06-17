<?php

    class Database
    {

        //Properties Declaration Here That Is Needed

        private $host ="localhost";
        private $user ="root";
        private $pass ="";
        private $db;
        private $table;
        private $id;
        private $conn;
        private $email;
        private $username;

        //It Connects With MySql

        public function start($db_name){
            $this->db = $db_name;
            try {
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db}",$this->user,$this->pass);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e){
                die("Failed");
            }
        }

        //It Closes Connection With MySql

        public function close(){
            $this->conn     = null;
            $this->db       = null;
            $this->table    = null;
            $this->id       = null;
            $this->email    = null;
            $this->username = null;
        }

        //It Returns All Data In Array From 
        public function show_all_data($table_name){
            $this->table = $table_name;
            $sql = "SELECT * FROM '$this->table' ";
            $result = $this->conn->prepare($sql);
            $data = array();
            while($row=$result->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;
            }
            return $data;
        }

        //It Returns A Single Line Data In  Array From 

        public function show_single_data($table_name,$id=null,$email=null,$username=null){
            $this->table = $table_name;
            $this->id = $id;
            $this->email = $email;
            $this->username = $username;
            $sql = "SELECT * FROM '$this->table' WHERE id = :id OR email = :email OR username = :username";
            $result = $this->conn->prepare($sql);
            $result->bindParam(':id',$this->id);
            $result->bindParam(':email',$this->email);
            $result->bindParam(':username',$this->username);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row;
        }

        //It Deletes Data From A Table

        public function delete($table_name,$id=null,$email=null,$username=null){
            $this->table = $table_name;
            $this->id = $id;
            $this->email = $email;
            $this->username = $username;
            $sql = "DELETE FROM '$this->table' WHERE id = :id OR email = :email OR username = :username";
            $result = $this->conn->prepare($sql);
            $result->bindParam(':id',$this->id);
            $result->bindParam(':email',$this->email);
            $result->bindParam(':username',$this->username);
            $result->execute();
            return $result->rowCount();
        }
    }