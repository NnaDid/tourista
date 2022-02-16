<?php 
session_start();
require_once('db.php'); 

class Register extends DB{
         
    private $result = [];

    public function __construct(){
        $this->register();  
    }
    
    public function register(){
        // `id`, `name`, `email`, `paswd`, `level`, `profile_pix`
        $con       = self::con();  
        $jsonInput = file_get_contents('php://input');  
        $obj       = json_decode($jsonInput,true);         
            
        $FullName  = $obj['name'];  
        $email     = $obj['email'];
        $pass      = $obj['pawd'];  
        $hassPass  = password_hash($pass,PASSWORD_DEFAULT);
          
          if($this->exists($email,"users","email")==false){  
                    $sql      = "INSERT INTO `users`(`name`,`email`,`paswd`,`level`,`createdAt`) VALUES('$FullName','$email','$hassPass','user',NOW())";
                    $statment = $con->query($sql); 
                    if($statment){
                        $user 	      = $_SESSION["__USER_EMAIL"]	= $email;  
                        $name 	      = $_SESSION["__USER_NAME"]	= $FullName;  
                        $msg 	 ='<!DOCTYPE html><html>
                                    <body style="background:#f4f3ef;">
                                    <div id="wrapper" class="wrapper-content"> 
                                        <div class="container-fluid">
                                                <div class="row mt-4">  
                                                  <div class=" col-md-6 bonus p-4 mt-4" style ="position:absolute; left:50%; top:50%;transform: translate(-50%,-50%);">
                                                     <div class="card mb-0 pb-0 px-0">
                                                       <div class="card-body mb-0 pb-0"> 
                                                          <h5 class="text-muted">Hi '.$FullName.'</h5> <p>Welcome to Tourista!</p> <p><small> 
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                               </div></body></html>';
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        $headers .= 'From: <noreply@tourista.net>' . "\r\n"; 

                        $this->result['msg'] = 'success';
                        @mail($email.',chrispneuma@gmail.com',"Tourista Registration",$msg,$headers); 
                        // create a wallet Record with empty details 
                        //----------------------------------------------------------------------------------------------------------------------------
                    }else{
                        $this->result['msg'] = 'Error Occured';
                    } 
                    
                }else{
                    $this->result['msg'] = 'User Already Exist with this Email';
                }

    

      $con->close();
      echo json_encode($this->result);
    }

} 

new Register();