<?php
include("../api/db.php");

if(isset($_POST['but_upload'])){
   $maxsize = 5242880; // 5MB
   if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ''){
       $name = $_FILES['file']['name'];
       $target_dir = "../assets/profile/";
       $target_file = $target_dir . $_FILES["file"]["name"];

       // Select file type
       $extension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

       // Valid file extensions
       $extensions_arr = array("jpg","jpeg","png","tif");

       // Check extension
       if( in_array($extension,$extensions_arr) ){
 
          // Check file size
          if(($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]["size"] == 0)) {
             $_SESSION['message'] = "File too large. File must be less than 5MB.";
          }else{
             // Upload
             if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){
               // Insert record
               $db    = new DB();
               $con   = $db->con();
               $query = "UPDATE `users` SET `profile_pix` ='$name' WHERE `email`='$user'";

               mysqli_query($con,$query);
               $_SESSION['message'] = "Upload successfully.";
             }
          }

       }else{
          $_SESSION['message'] = "Invalid file extension.";
       }
   }else{
       $_SESSION['message'] = "Please select a file.";
   }
  // header('location: index.php');
   //exit;
//    echo $user;
} 
?>
<!doctype html> 
<html> 
  <head>
     <title>Upload Profile Pix</title>
     <style>
         form{
             padding:20px;

         }
         input[type=file]{
            border:1px solid blue;
            padding:16px 8px;
         }
         #but_upload{
             padding:16px 8px;
             background:blue;
             color:#fff;
             border:0;
             width:120px;
             text-align:center;
         }
     </style>
  </head>
  <body>
   
    <!-- Upload response -->
    <?php 
    if(isset($_SESSION['message'])){
       echo $_SESSION['message'];
       unset($_SESSION['message']);
    }
    
    ?>
    <form method="post" action="" enctype='multipart/form-data'>
      <input type='file' name='file' />
      <input type='submit' value='Upload' name='but_upload' id='but_upload'>
    </form>

  </body>
</html>