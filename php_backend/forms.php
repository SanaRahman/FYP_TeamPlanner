<?php
include_once ".././manager_actions/manager_class.php";
include_once ".././member_actions/member_class.php";
include ".././database_connection.php";

$manager1=new manager();
$member1=new member();

$Error='';
$username=$psw=$gmail=$repeat="";

//<--------------------validations---------------------->
if( isset($_POST["sign_manager"]) || isset($_POST["sign_member"])){

 $username=$_POST['username'];
 $psw=$_POST['psw'];
 $gmail=$_POST['gmail'];
 $repeat=$_POST['repeat'];

if(!preg_match("/^[a-zA-z0-9]*$/",$username)){  $Error="Use alphabets and numbers only";}
if (!filter_var($gmail,FILTER_VALIDATE_EMAIL)) {  $Error ="Invalid email format";}
else{
    if (stristr($gmail, '@gmail.com') === false) {$Error="Must enter a Gmail address";}
  }
if(strlen($psw)<8){  $Error="password shall be atleast 8 character long";}
if($psw!==$repeat){ $Error="Make sure to enter same passwords in both fields"; }

if(empty($Error)){
if(isset($_POST['sign_manager'])){
$man=$manager1 ->insert_new_manager($username,$psw,$gmail,$conn);
if($man==1){$Error="UserName already taken";}
elseif($man==2){$Error="This Gmail is already registered";}
else{ $Error="success";}
}

else if(isset($_POST["sign_member"])){
   $call=$member1 ->insert_new_member($username,$psw,$gmail,$conn);
   if($call==1){$Error="UserName already taken";}
   elseif($call==2){$Error="This Gmail is already registered";}
   else if($call==4){ $Error="success";}
   else if($call==5){ $Error="success";}
   }
 }

echo $Error;
}

if( isset($_GET["login_manager"]) || isset($_POST["login_member"])){

  $username=$_POST['username'];
  $psw=$_POST['psw'];
  $c=0;

if( isset($_GET["login_manager"])){
  $ans=$manager1-> manager_login($username,$psw,$conn);
  if($ans==0){$Error="Wrong Password";}
  else if($ans==1){$Error="Username doesn't exists";}
  else {$Error="success";}
 }

if( isset($_POST["login_member"])){
  $link=$_POST['link'];
  $code=$_POST['code'];
  $Error=$code.$link;
 $ans= $member1->member_login($username,$psw,$link,$code,$conn);
 if($ans==0){$Error="Incorrect Password ";}
 else if($ans==1){$Error="Username not Found";}
 else if($ans==3){$Error="link"; }
 else if($ans==4){$Error="success";}
 else{$Error="success";}

}
echo $Error;
}


?>
