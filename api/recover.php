<?php 
require_once('db.php');

class Recover extends DB{
     
    private $result = [];
    
    public function __construct(){
        $this->recoverPassword();
    }

    public function recoverPassword(){
               $con       = self::con();  
               $jsonInput = file_get_contents('php://input');  
               $obj       = json_decode($jsonInput,true);         
                   
               $email     = $obj['email']; 

                if(self::exists($email,"users","email")){			  
                $new_password  	    = substr(str_shuffle(rand(time(),time()+7)."Aab12345CcDdeFoNdaTi@zZKkL"),1,8);
                $hash_pass 			= password_hash($new_password,PASSWORD_BCRYPT); // hash the password

                $updateQuery 		= "UPDATE `users` SET `paswd`=? WHERE `email`=?";
                $stmt_update 		= $con->prepare($updateQuery);
                $stmt_update->bind_param("ss",$hash_pass,$email);

                if($stmt_update->execute()){
                $msg 	      ='<html><head><title>Password Reovery Email</title></head><body><div style ="border-bottom:3px solid #1BBC9B;">
                                 <p> A request to reset your password has been initiated </p>
                                <h3>Your New Passowrd is :</h3>
                                <p><h2>'.$new_password.'</h2></p>
                                <p>NB: If you did not initiate this action, kindly  click here &nbsp;
                                <a href ="https://www.tourista.net/block.php?block='.$email.'&uuu='.md5(time()).'" >Block</a></p> </div></body></html>';
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                $headers .= 'From: <info@tourista.net>' . "\r\n";
                                $headers .= 'Cc: support@tourista.net' . "\r\n";
                if(@mail($email,"Password Recovery",$msg,$headers)){
                    $this->result['msg'] = "Check you email to get the new password we sent you.>"; 
                }else{
                    $this->result['msg'] ='Error Sending Mail Please Try again Ensuring you have a good network connection ';
                }
                
                    $stmt_update->close();
                }
    
    
            }else{
                $this->result['msg'] = "User doen't exist";
            }
    
            $con->close();
            echo json_encode($this->result);
     }
  }

new Recover();