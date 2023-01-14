<?php
include(".././database_connection.php");
include(".././manager_actions/project_class.php");

$project1=new project();
$Error='';
$pname=$depname=$start_date=$end_date=$description='';

if(isset($_POST['create_project']) || isset($_POST['edit_project']) ){
    $pname=$_POST['pname'];
    $depname=$_POST['depname'];
    $description=$_POST['description'];
    $start_date=date(("Y-m-d"),strtotime($_POST['start_date']));
    $end_date=date(("Y-m-d"),strtotime($_POST['end_date']));
      $today=date("Y-m-d");

    if(empty($pname) || empty($depname) || empty($description) || empty($start_date) || empty($end_date)){
      $Error="Please fill all fields";
    }else if($start_date<$today){
    $Error="Please select a Start date greater than today";
    }else if($start_date>$end_date){
    $Error="Select a End date greater than your Start date";}
    else if(!preg_match('/^[a-zA-Z0-9\s]+$/',$pname)){
    $Error="Dont use special characters";
    }else if(!preg_match('/^[a-zA-Z0-9\s]+$/',$depname)){
    $Error="Dont use special characters";
    }

    if($Error==''){
      if(isset($_POST['create_project'])){
      $ans=$project1 -> check_project_name($pname,$depname,$description,$start_date,$end_date,$conn);
      if($ans==0){$Error="This project name is Taken";}
      else{$Error="success";}}

      else if(isset($_POST['edit_project'])){

        $ans=$project1->update_project($pname,$depname,$description,$start_date,$conn,$end_date);
        if($ans==1){$Error="success";}
        else{$Error="Problem occured Sorry try again later";}
      }
        }

    echo $Error;
}

//delete member from project.
if(isset($_GET['delete_member'])){
  $id=$_POST['id'];
  $ans=$project1->remove_member($conn,$id);
  if($ans==1){echo 1;}
}

?>
