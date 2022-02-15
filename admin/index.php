<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> User Dashboard | Tourista</title>
    <link rel="stylesheet" href="../assets/style.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      <li>
        <a href="#">
          <i class='bx bx-grid-alt' ></i>
          <span class="links_name">Dashboard</span>
        </a>
        <span class="tooltip">Dashboard</span>
      </li>
      <li>
        <a href="#">
          <i class='bx bx-user' ></i>
          <span class="links_name">Users</span>
        </a>
        <span class="tooltip">Users</span>
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
  <div class="home_content">
    <div class="text header_div">
       <h4>Dashboard  Content</h4>
       <h4><i class='bx bx-log-out' id="log_out" ></i></h4>
    </div>
  </div>

  <script>
   let btn = document.querySelector("#btn");
   let sidebar = document.querySelector(".sidebar");
   let searchBtn = document.querySelector(".bx-search");

   btn.onclick = function() {
     sidebar.classList.toggle("active");
   }
   searchBtn.onclick = function() {
     sidebar.classList.toggle("active");
   }

  </script>

</body>
</html>
