<?php
$qry='';
if($_SESSION['login_user']=="manager"){
  $qry="SELECT * from accounts_manager am INNER JOIN accounts a where am.userid=a.userid and am.userid={$_SESSION['userid']}";
}else{  $qry="SELECT * from accounts_member am INNER JOIN accounts a where am.userid=a.userid and am.userid={$_SESSION['userid']} ";
}
$profile=mysqli_query($conn,$qry);
$row=mysqli_fetch_assoc($profile);
$dp=$row['dp'];
$username=$row['username'];

 ?>
<head><link href="styles/navbar.css" rel="stylesheet"></head>
<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-primary navbar-dark ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <?php //if(isset($_SESSION['login_id'])): ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
      </li>
    <?php// endif; ?>
      <li>
        <a class="nav-link text-white"  href="./" role="button"> <large><b><?php echo "Team Planner" //echo $_SESSION['system']['name'] ?></b></large></a>
      </li>
    </ul>


     <div  class="navbar" >
      <div  class="navbar_right">

      <div  class="notifications">
      <div id="msg" class="icon_wrap"><i class="far fa-envelope"><span  class="badge badge-danger" id="msg_count" ></span></i></div>
      <div class="notification_dd">
      <ul id="message_alert"  class="notification_ul msg">
      </ul>
      </div>
      </div>

    <div  class="notifications">
    <div  id="alert" class="icon_wrap"><i class="far fa-bell">
    <span  class="badge badge-danger" id="alert_count" ></span></i></div>
    <div class="notification_dd">
    <ul  id="alert_show" class="notification_ul"></ul>
    </div>
    </div>

     <div class="profile">
      <div class="icon_wrap">
        <img  style="  border-radius: 50%; height:40px; width:40px; " src="assets/profile/<?php echo $dp;?>" alt="">
        <span class="name"><?php echo $username;?></span>
        <i class="fas fa-chevron-down"></i>
       </div>

    <div class="profile_dd">
    <ul class="profile_ul">
    <li><a class="" href="logout&session_check.php?logout=1"><span class="picon"><i class="fas fa-sign-out-alt"></i></span>Logout</a></li>
    <li><a class="settings" href="./index.php?page=accounts"><span class="picon"><i class="fas fa-user-alt"></i></span>Profile</a></li>
    </ul>
    </div>
    </div>

  </div>
   </div>

  </nav>
<?php
if(isset($_SESSION['login_user'])) {?>
  <script src="./navbar_ajax.js"></script><?php  } ?>
