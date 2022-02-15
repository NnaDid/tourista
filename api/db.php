<?php
   class DB{
    public $host = "localhost";
    public $user = "root"   ;
    public $pass = ""  ;
    public $db   = "tourista";

        public function con(){
            $con = new mysqli($this->host,$this->user,$this->pass,$this->db);
            if ($con->connect_errno) die(" Connection not established");
            return $con ;
        }


        public function exists($val,$table,$col){
            $con     = $this->con();
            if(!empty($val)){
            $sql       = "SELECT * FROM `".$table."` WHERE `".$col."`=?";
            $stmt      = $con->prepare($sql);
            $stmt->bind_param("s",$val);
            $exec      = $stmt->execute();
            if($exec){
            $result   = $stmt->get_result();
            $num_rows = $result->num_rows;
            if($num_rows>0){
                return true;
            }else{
                return false;
            }
            $stmt->close();
            }
            }
        }

        // Return User Details as Associative array
        public function getUserByEmail($email){
            $con        = $this->con();
            $queryRow   = $con->query("SELECT * FROM `users` WHERE `email` ='$email'")->fetch_assoc();
            return  $queryRow;
        }

        // Get User/member details by ID
        public function getUserById($uid){
            $con        = $this->con();
            $queryRow   = $con->query("SELECT * FROM `users` WHERE `id` ='$uid'")->fetch_assoc();
            return  $queryRow;
        }
        
   }
?>