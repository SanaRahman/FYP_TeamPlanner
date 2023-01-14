<?php
include_once ".././database_connection.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//-----------------------for manager_recovery requuest--------------------------
if(isset($_POST["password_recovery"])){
$email=$_POST['email'];
$verify=mysqli_query($conn,"SELECT * from accounts_manager Where gmail='$email'");
if(mysqli_num_rows($verify)>0){
  while($res=mysqli_fetch_row($verify)){
    $id=$res[0];}
    $r="manager";
  send_mail($conn,$email,$r,$id);
  echo "success";
}else {  echo "Email not found";}
}
//-------------------for member recovery requuest--------------
if(isset($_POST["password_recovery_mem"])){
  $email=$_POST['email'];
  $verify=mysqli_query($conn,"SELECT * from accounts_member Where gmail='$email'");
  if(mysqli_num_rows($verify)>0){
    while($res=mysqli_fetch_row($verify)){
    $id=$res[0];}
    $r="member";
    send_mail($conn,$email,$r,$id);
    echo "success";}
    else {  echo "Email not found";}
}

function send_mail($conn,$email,$r,$uid){
  require '../PHPMailer/src/Exception.php';
  require '../PHPMailer/src/PHPMailer.php';
  require '../PHPMailer/src/SMTP.php';

  $mail = new PHPMailer(true);

  try {
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = 'sanarahman930@gmail.com';
      $mail->Password   = 'iiuhlsnxxzzjxhgv';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->Port       = 465;

      $mail->setFrom('TeamPlanner@gmail.com', 'Team Planner');
      $mail->addAddress($email);

      $code=substr(str_shuffle('1234567890ABCDEFGHIJKLMNOPQRSTabcdefghijklmnopqrstuvwxyz'),0,10);
      $mail->isHTML(true);
      $mail->Subject = 'Password Recovery';
      $mail->Body = 'Hello Users,
      <br> Thank you for using Team TeamPlanner
      <br>Forgot your Password no worries
      <br>To reset Password click <a href="http://localhost/team_planner_refactor/password_reset.php?code='.$code.'&type='.$r.'&id='.$uid.'">here
      </a>';

      if($r=="manager"){
      $update=mysqli_query($conn,"UPDATE accounts_manager SET code='$code' where gmail='$email' ");}
      else if($r=="member"){  $update=mysqli_query($conn,"UPDATE accounts_member SET code='$code' where gmail='$email' ");}

      $mail->send();
    } catch (Exception $e) {echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";}
}

//--------------------for reset procedure----------

if(isset($_POST['password_reset'])){
 $code=$_POST['code'];
  $psw=$_POST['psw'];
  $repeat=$_POST['repeat'];
  $type=$_POST['type'];

  if(empty($psw) || empty($repeat)){
      echo "fill all fields";
  }
  else if(strlen($psw)<8){
    echo "Lenght of password shall be 8 charcters or more \n";
  }
  else if($psw!=$repeat){
    echo "Please enter same passwords in both fields";
  }else{
      $hashpsd=password_hash($psw, PASSWORD_DEFAULT);
    if($type=="manager"){
      $sql=mysqli_query($conn,"UPDATE accounts_manager SET passwod='$hashpsd',code='no' where code='$code'");
      if($sql){echo "success";}
      else{echo "error";}
    }else/*for member*/{
     $sql=mysqli_query($conn,"UPDATE accounts_member SET passwod='$hashpsd',code='no' where code='$code'");
    if($sql){echo "success";}
   }
  }
}
?>
