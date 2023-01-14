<?php
session_start();

Class project{

    function join_project($code,$conn){
      $uname=  $_SESSION['username'];
      $uid= $_SESSION['userid'];
      $mail=  $_SESSION['email'];
      $pid;
      $already=false;
      $exists=false;

      $sql="SELECT * FROM projects WHERE projectid=?;";
      $stmt=mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql)){
        echo '<script>alert("Error line 16")</script>';
         exit();
      }
      else{
      mysqli_stmt_bind_param($stmt,"s",$code);
      mysqli_stmt_execute($stmt);
      $result=mysqli_stmt_get_result($stmt);
      if($row=mysqli_fetch_assoc($result)){
      //echo '<script>alert("Project Found")</script>';
      $pname=$row['projectname'];
      $pid=$row['projectid'];
       $exists=true;
      }
     }

      if($exists==true){
    $sql= "SELECT * FROM member_list WHERE projectid ='$code' AND membername = '$uname'";
    $result = $conn->query($sql);
     if ($result->num_rows > 0) {
  // output data of each row
     while($row = $result->fetch_assoc()) {
       $already=true;
      return 0;
     }
      }
     else {

       $sql = "INSERT INTO member_list (projectid,projectname,memberid,membername,gmail)
       VALUES ('$code', '$pname', '$uid','$uname','$mail')";
       if ($conn->query($sql) === TRUE) {
         return 1;
        // $_SESSION['joined']='joined';
        // echo '<script>alert("added to the project sucessfully" )</script>';
       }
       else {
       echo '<script>alert("Project not joined" )</script>';
       }
     }
    }//if exists ends


    if($exists==false){
        // echo '<script>alert("No such project exists")</script>';
      //  $_SESSION['p_not_found']="p_not_found";
      return 2;
     }

}//join function ends


function check_project_name($pname,$depname,$description,$start_date,$end_date,$conn){
    $sql1="SELECT projectname FROM projects WHERE projectname=?";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql1)){
    exit();
    }
    else{
     mysqli_stmt_bind_param($stmt,"s",$pname);
     mysqli_stmt_execute($stmt);
     mysqli_stmt_store_result($stmt);
     $result_check=mysqli_stmt_num_rows($stmt);
     if($result_check>0){
       return 0;
      }
      else{
        $this->generate_key($pname,$depname,$description,$start_date,$end_date,$conn);
        return 1;
      }
}
}

function generate_key($pname,$depname,$description,$start_date,$end_date,$conn){

  $keyLenght=8;
  $str="012345678abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRST";
  $randstr=substr(str_shuffle($str),0,$keyLenght);
  //keys if key is present inside databse
  $checkKey= $this->check_key($conn,$randstr);
  //key alreday exists in the database.
  while($checkKey==true){
      $randstr=substr(str_shuffle($str),0,$keyLenght);
      $checkKey->check_key($conn,$randstr);
  }
   $this-> add_project($pname,$depname,$description,$start_date,$end_date,$randstr,$conn);
}

function check_key($conn,$randstr){

  $keyexists=0;
  $sql="SELECT * FROM projects";
  $result=mysqli_query($conn,$sql);

  while($row=mysqli_fetch_assoc($result)){
    if($row['projectid']==$randstr){
    $keyexists=true;
    break;
    }
    else{
    $keyexists=false;
    }
  }
   return $keyexists;
}


public  function add_project($pname,$depname,$descrip,$start_date,$end_date,$randstr,$conn){
    $managerid=$_SESSION['userid'];
    $managername= $_SESSION['username'];
    $status="On-Progress";
    $sql = "INSERT INTO projects (projectid,projectname,department,description,managerid,managername,datee,end_date,status,noft,Progress)
    VALUES ('$randstr', '$pname', '$depname','$descrip','$managerid','$managername','$start_date','$end_date','$status',0,0)";
   if ($conn->query($sql) === TRUE) {
   //take the project id and create a chat group for it.
     $last_id=mysqli_insert_id($conn);

     $sql=mysqli_query($conn,"SELECT projectid FROM projects Where id=$last_id");
     $id=mysqli_fetch_row($sql);
     $this->create_group($conn,$pname,$id[0]);

  $_SESSION['code']=$randstr;
  return 1;
   }
else {

$_SESSION['success']="";
}
}

function create_group($conn,$pname,$last_id){
$image="includes/default-upload-image.jpg";
$sql="INSERT INTO chat (projectid,name,img)
  VALUES ('$last_id','$pname','$image')";
   if ($conn->query($sql) === TRUE) {

  }
}

function update_project($pname,$pdep,$descrip,$date,$conn,$edate){

  $sql="UPDATE projects SET projectname='$pname',department='$pdep',description='$descrip',
  datee='$date',end_date='$edate' where projectid='{$_SESSION['edid']}'";
  //$res=mysqli_query($conn,$sql);
  if ($conn->query($sql) === TRUE) {
    //unset($_SESSION['pid']);
    //$_SESSION['update']="project_updated";
    return 1;
  }
  else {
    $_SESSION['update']="";
    }
}

function remove_member($conn,$id){
$pid=$_SESSION['ptid'];
  $sql="DELETE FROM member_list where memberid=$id AND projectid='$pid'";
  $query=mysqli_query($conn,$sql);
  if($query){
    //removing members chat.
    $this->remove_chat($conn,$id,$pid);
   //removing task details of the member.
  $ans=$this->remove_task_details($conn,$id,$pid);
  return $ans;
   }else{
  echo'<script>alert("Error in deleting line 173 project class") </script>';}
  return $ans;
}

function remove_task_details($conn,$id,$pid){
  $sql2="SELECT * FROM task where pid='$pid'";
  $query=mysqli_query($conn,$sql2);

  while($result=mysqli_fetch_assoc($query)){
    $tid=$result['tid'];

    $sql="DELETE FROM member_task where mid=$id AND tid='$tid'";
    $q=mysqli_query($conn,$sql);
    if(!$q){  echo'<script>alert("Error in deleting line 167 project class") </script>';
    }else{
      $sql2="UPDATE task SET nofmem=nofmem-1 WHERE tid=$tid";
      $query2=mysqli_query($conn,$sql2);
      if(!$query2){
            echo'<script>alert("Error decrementing no ine 125") </script>';
      }
    }
  }
  return 1;
}

function remove_chat($conn,$id,$pid){

$sqll="DELETE FROM chat_msg where projectid='$pid' AND outgoing_msg_id=$id";
$qe=mysqli_query($conn,$sqll);
if(!$qe){
    echo "<script type='text/javascript'>alert('error deleting messages in project class');</script>";}
}

function delete_project($conn,$pid){
  $sql="DELETE FROM projects where projectid='$pid'";
  $query=mysqli_query($conn,$sql);
  if($query){
  $this->delete_member_list($conn,$pid);
  //delete its chat group
  $sql=mysqli_query($conn,"DELETE FROM chat where projectid='$pid'");
  if(!$sql){  echo "<script type='text/javascript'>alert('error deleting messages in project class');</script>";}
  $sql3=mysqli_query($conn,"DELETE FROM submit_noti where projectid='$pid'");
  if(!$sql3){  echo "<script type='text/javascript'>alert('error deleting messages in project class');</script>";}
  return 1;
  }else{echo'<script>alert("Error in deleting") </script>';}
  return 1;
}

//called after a project is deleted.
function delete_member_list($conn,$pid){
  $sql="DELETE FROM member_list where projectid='$pid' ";
  $q=mysqli_query($conn,$sql);

  if($q){
    $sql2="SELECT tid FROM task where pid='$pid'";
    $query=mysqli_query($conn,$sql2);
    while($result=mysqli_fetch_assoc($query)){
    $tid=$result['tid'];

    $sql3="DELETE FROM task where tid='$tid'";
    $qe=mysqli_query($conn,$sql3);
    if($qe){
    $sql4="DELETE FROM member_task where tid=$tid";
    $qi=mysqli_query($conn,$sql4);
    if($qi){//$_SESSION["project_deleted"]="project_deleted";
    }
    }
    else{  echo'<script>alert("Error in deleting line 197 project class") </script>';}
  }
}
}

}//class ends
