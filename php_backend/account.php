<?php
include ".././database_connection.php";
session_start();
$Error='';
if(isset($_POST['accounts_edit'])){

$first_name=$_POST['first_name'];
$last_name=$_POST['last_name'];
$org_name=$_POST['org_name'];
$birthday=$_POST['birthday'];
$location=$_POST['location'];
$email=$_POST['email'];
$no=$_POST['no'];


$filename=$_FILES['dp']['name'];
$tm= $_FILES['dp']['tmp_name'];

if(!empty($no)){
  if(!preg_match("/^[0-9]*$/",$no)){
    $Error="Enter only numbers in phone field";
  }
}
else if(!empty($email)){
if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {  $Error ="Invalid email format";}}

if(!empty($filename)){
$fileExt=explode('.',$filename);
$given=array("jpg","jpeg","png");
$fileActualExt=strtolower(end($fileExt));

if(in_array($fileActualExt,$given) && $Error==''){
$filename=time().'-'.$filename;
move_uploaded_file($tm,".././assets/profile/".$filename);

$update=mysqli_query($conn,"UPDATE accounts SET dp='$filename',first_name='$first_name',last_name='$last_name',org_name='$org_name',
 location='$location',email='$email',no='$no',birthday='$birthday' where userid={$_SESSION['userid']}");
if($update){$Error="success";}
else{$Error="n";}
}
else{$Error="Chose a file among the allowed file"  ;}

}else if(empty($filename) && $Error==''){
  $update=mysqli_query($conn,"UPDATE accounts SET first_name='$first_name',last_name='$last_name',org_name='$org_name',
   location='$location',email='$email',no='$no',birthday='$birthday' where userid={$_SESSION['userid']}");
   if($update){$Error="success";}
   else{$Error="n";}
}

echo $Error;
}
 ?>
