<?php
 function check_log($conn){
   //when join link is followed
    if(isset($_GET['open']) && !isset($_SESSION['userid'])){
      //send a open parameter.
    $code=$_GET['id'];
      header("Location:login.php?&id=$code&open=true");
    }
    else if(!isset($_SESSION['userid'])){
    header("Location:login.php");
    die;
      }

}

if(isset($_GET["logout"])){
  session_start();
  header("Location:login.php");
  session_unset();
  session_destroy();

}
?>
