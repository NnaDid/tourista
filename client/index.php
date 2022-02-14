<!DOCTYPE html>
<!-- Designined by CodingLab | www.youtube.com/codinglabyt -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> User Dashboard | Tourista</title>
    <link rel="stylesheet" href="../assets/style.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <style>
       .item{
           height:350px;width:33%;
           margin:0.33%;
           border:1px solid #cfcfcf;
           box-shadow:0px 0px 3px 0px #cfcfcf;
           padding: 4px;
       }
       .item:hover{
            border:1px solid #cfcfcf;
            box-shadow:0px 3px 3px 0px #cfcfcf;
            cursor: pointer;
            background-color: #f2f2f2;
       }
 
     </style>
   </head>
<body>
  <div class="sidebar">
    <div class="logo_content">
      <div class="logo"> 
        <div class="logo_name">Tourista</div>
      </div>
      <i class='bx bx-menu' id="btn" ></i>
    </div>
    <ul class="nav_list">
      <!-- <li>
          <i class='bx bx-search' ></i>
          <input type="text" placeholder="Search...">
        <span class="tooltip">Search</span>
      </li> -->
      <li>
        <a href="?pg=home">
          <i class='bx bx-grid-alt' ></i>
          <span class="links_name">Dashboard</span>
        </a>
        <span class="tooltip">Dashboard</span>
      </li>
      <li>
        <a href="?pg=profile">
          <i class='bx bx-user' ></i>
          <span class="links_name">Profile</span>
        </a>
        <span class="tooltip">Profile</span>
      </li>  
      <li>
        <a href="?pg=shop">
          <i class='bx bx-folder' ></i>
          <span class="links_name">Shop</span>
        </a>
        <span class="tooltip">Shop</span>
      </li>  
      <li>
        <a href="?pg=travel">
          <i class='bx bx-car' ></i>
          <span class="links_name">Travel Interests</span>
        </a>
        <span class="tooltip">Interests</span>
      </li>  
      <li>
        <a href="?pg=about">
          <i class='bx bx-user' ></i>
          <span class="links_name">About Us</span>
        </a>
        <span class="tooltip">About</span>
      </li>
    </ul>
    <div class="profile_content">
      <div class="profile">
        <div class="profile_details">
          <img src="profile.jpg" alt="">
          <div class="name_job">
            <div class="name">Prem Shahi</div>
            <div class="job">Web Designer</div>
          </div>
        </div>
        <i class='bx bx-log-out' id="log_out" ></i>
      </div>
    </div>
  </div>

  <div class="home_content" style="overflow-y:scroll;">
      <div class="text header_div">
        <h4></h4>
        <h4><i class='bx bx-log-out' id="log_out" ></i></h4>
      </div>

        <?php
            if(isset($_GET['pg'])){
                $pg = trim($_GET['pg']); 
                $pageUrl = "pages/".$pg.".php";
                if(file_exists($pageUrl)){
                    include($pageUrl);
                }else{
                    include("pages/home.php");
                }
            }else{
                include("pages/home.php");
            }

         ?>      
  </div>

  <script>
   let btn       = document.querySelector("#btn");
   let sidebar   = document.querySelector(".sidebar");
   let searchBtn = document.querySelector(".bx-search");

   btn.onclick = function() { sidebar.classList.toggle("active");}
   searchBtn.onclick = function() {sidebar.classList.toggle("active");}

  </script>

</body>
</html>
