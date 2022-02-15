<?php
session_start();
require_once('db.php');

class Pasword extends DB{
         
    private $result = [];
    
    public function __construct(){
        $this->updatePassword($_SESSION["__USER_EMAIL"]);
    }

    private function updatePassword($email_id){ 
            $con         = self::con(); 
            $jsonInput = file_get_contents('php://input');  
            $obj       = json_decode($jsonInput,true);  

            $new_pass1   = $obj["re_password"];
            $new_pass2   = $obj["new_password"];
            $oldPass     = $obj["old-password"];
            $pwd         = $this->getUserById($id)['paswd'];
            
            if(password_verify($oldPass,$pwd)){
                if(strcasecmp($new_pass1,$new_pass2) == 0){
                    $hasPass = password_hash($new_pass1,PASSWORD_DEFAULT);
                    $sql 	 = "UPDATE `users` SET `paswd`=? WHERE `email`=?";
                    $stmt    = $con->prepare($sql);
                    $stmt->bind_param("ss",$hasPass,$email_id);
                    $exec    = $stmt->execute();
                if($exec){
                    $this->result['msg'] = "success";  
                }else{
                    $this->result['msg'] = "Update Failed!!! ".$stmt->error;
                }
                    $stmt->close(); 
                }else{
                    $this->result['msg'] = "Password Mismatch";
                }		    
            }else{
                $this->result['msg'] = "Your Old Password is not Correct ";
            }
                   

        $con->close();
        echo json_encode($this->result);
    }
    


}

$p = new Pasword();