<?php
session_start();
require_once('db.php');

class Login extends DB{ 

    private $result = [];
    
    public function __construct(){
        $this->login();
    }

    private function login(){ 
                $con  = self::con(); 

                $jsonInput = file_get_contents('php://input');  
                $obj       = json_decode($jsonInput,true);         
                      
                $email     = $obj['email'];
                $pass      = $obj['pawd']; 

                if(self::exists($email,"users","email")){ 

                    $sql  		= "SELECT * FROM `users` WHERE `email`=?";
                    $stmt 		= $con->prepare($sql);
                    $stmt->bind_param("s",$email);  
    
                    if($stmt->execute()){
                        $result	  = $stmt->get_result();
                        $row      = $result->fetch_assoc();
                    if(password_verify($pass,$row['paswd'])){
                        $user 	  = $_SESSION["__USER_EMAIL"]	    = $row['email'];
                        $uid      = $_SESSION["__USER_ID"]          = $row['id']; 
                        $name     = $_SESSION["__USER_NAME"]        = $row['name']; 
    
                    if(isset($user) && isset($uid) ){
                        $this->result['msg']  = "success";  
                        $this->result['user'] = $row;  
                    }else{
                        $this->result['msg'] = "Sorry No Session Was set at this time";
                    }
                    }else{
                        $this->result['msg'] = "Incorrect Password".$stmt->error;
                    }
    
                    }

                }else{
                    die(json_encode(['msg'=>"Wrong Email or Phone Number"]));
                }	 
        

        $con->close();
        echo json_encode($this->result);
    }
    


}

$login = new Login();