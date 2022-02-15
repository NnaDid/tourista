<?php
session_start();
require_once('db.php');

class Profile extends DB{ 

    private $result = [];
    
    public function __construct(){
        $this->updateProfile($_SESSION["__USER_ID"]);
    }

    private function updateProfile($id){ 
            $con       = self::con(); 
            $jsonInput = file_get_contents('php://input');  
            $obj       = json_decode($jsonInput,true);         
                
            $name      = $obj['name'];  
            $email     = $obj['email'];

            $sql 	 = "UPDATE `users` SET `email`=?,`name`=? WHERE `id`=?";
            $stmt    = $con->prepare($sql);
            $stmt->bind_param("ssi",$email,$name,$id);
            $exec    = $stmt->execute();
            if($exec){
                $this->result['msg'] = "success"; 
            }else{
                $this->result['msg'] = "Update Failed!!! ".$stmt->error;
            }
            $stmt->close(); 	 
                    
        

        $con->close();
        echo json_encode($this->result);
    }
    


}

$p = new Profile();