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


        public function listUsers(){
            $con    = $this->con();
            $query  = $con->query("SELECT * FROM `users`");
            $output = '<table border="1" style="width:100%; paddig:20px; border:1px solid #ccc;">
                        <tr style="paddig:20px; border:1px solid #ccc;">
                            <th style="paddig:20px; border:1px solid #ccc;">SN</th>
                            <th style="paddig:20px; border:1px solid #ccc;">Name</th>
                            <th style="paddig:20px; border:1px solid #ccc;">Email</th>
                            <th style="paddig:20px; border:1px solid #ccc;">User Level</th> 
                            <th style="paddig:20px; border:1px solid #ccc;">Action</th>
                        </tr>';
         $counter =0;
          while($row = $query->fetch_assoc()){ 
            $output.='<tr style="paddig:20px; border:1px solid #ccc;">
                        <td style="paddig:20px; border:1px solid #ccc;">'.(++$counter).'</td>
                        <td style="paddig:20px; border:1px solid #ccc;">'.$row['name'].'</td>
                        <td style="paddig:20px; border:1px solid #ccc;">'.$row['email'].'</td>
                        <td style="paddig:20px; border:1px solid #ccc;">'.$row['level'].'</td>
                        <td style="paddig:20px; border:1px solid #ccc;"><a href="?uid='.$row['id'].'">Delete</a> <a href="?edit='.$row['id'].'">Edit</a> </td>
                    </tr>';
          }
          $output.='</table>';
          echo $output;

        }
        
   }
?>