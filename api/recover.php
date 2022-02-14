<?php
session_start();
require_once('db.php');

class Recover extends DB{
     
    private $result = [];
    
    public function __construct(){
        $this->recoverPassword();
    }

    public function recoverPassword(){
           $con       = self::con(); 	
            if(!isset($_POST['token']) || !isset($_SESSION['zgits_csrf_token'])){  die(json_encode(['msg'=>"Invalid Token"]));  }
            
            if($_POST['token']==$_SESSION['zgits_csrf_token']){
                // check if token has expired zgits_csrf_expires
                if(time()>=$_SESSION['zgits_csrf_expires']){  die(json_encode(['msg'=>"OOPs!!! Please reload your page"])); }
               
                $email 				= trim($_POST['email_recover_pass']);

                if(self::exists($email,"users","email")){			  
                $new_password  	    = substr(str_shuffle(rand(time(),time()+7)."Aab12345CcDdeFoNdaTi@zZKkL"),1,8);
                $hash_pass 			= password_hash($new_password,PASSWORD_BCRYPT); // hash the password

                $updateQuery 		= "UPDATE `users` SET `pwd`=? WHERE `email`=?";
                $stmt_update 		= $con->prepare($updateQuery);
                $stmt_update->bind_param("ss",$hash_pass,$email);

                if($stmt_update->execute()){
                $msg 	      ='<html><head><title>Password Reovery Email</title></head><body><div style ="border-bottom:3px solid #1BBC9B;">
                                <h2 style ="background-color:#1BBC9B; font-weight:600;border-bottom:3px solid #1BBC9B;">ZGITS PASSWORD RECOVERY</h2>
                                <p> A request to reset your password has been initiated </p>
                                <h3>Your New Passowrd is :</h3>
                                <p><h2>'.$new_password.'</h2></p>
                                <p>NB: If you did not initiate this action, kindly  click here &nbsp;
                                <a href ="https://www.zgits.net/block.php?block='.$email.'&uuu='.md5(time()).'" >Block</a></p><address style ="padding:10px;background:#1BBC9B;font-weight:600;">
                                <img src ="https://www.zgits.net/static/img/glogo.jpg" width ="60" height=""/><a href="https://www.zgits.net">https://www.zgits.net</a></address></div></body></html>';
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                $headers .= 'From: <info@zgits.net>' . "\r\n";
                                $headers .= 'Cc: support@zgits.net' . "\r\n";
                if(@mail($email,"ZGITS Password Recovery",$msg,$headers)){
                    $this->result['msg'] = "Check you email to get the new password we sent you.";
                    unset($_SESSION['zgits_csrf_token']);
                    unset($_SESSION['zgits_csrf_token']);
                }else{
                    $this->result['msg'] ='Error Sending Mail Please Try again Ensuring you have a good network connection ';
                }
                
                    $stmt_update->close();
                }
    
    
            }else{
                $this->result['msg'] = "User doen't exist";
            }

                        
         }
    
            $con->close();
            echo json_encode($this->result);
     }
  }

new Recover();