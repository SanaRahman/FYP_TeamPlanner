<?php
include(".././manager_actions/project_class.php");
 include '.././database_connection.php';

$project1=new project();


if(isset($_POST["join_project"])){
$code=$_POST['code'];
if(empty($code)){
echo "Please enter a project code";
}else{
$ans=$project1->join_project($code,$conn);
}

if($ans==0){echo "You have already joined the project";}
else if($ans==1){echo "success";}
else if($ans==2){echo "This project code doesn't exists";}
}

if(isset($_GET['action'])){

  $delid=$_POST['id'];
  $sql=mysqli_query($conn,"SELECT projectid from projects where id=$delid");
  $res=mysqli_fetch_assoc($sql);
  $id=$res['projectid'];
  $ans=$project1->delete_project($conn,$id);
  echo $ans;
}

?>
