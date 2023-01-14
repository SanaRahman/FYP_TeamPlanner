<?php
include_once ".././database_connection.php";
session_start();
if(isset($_SESSION['userid'])){
   $id=$_SESSION['userid'];
}

if(isset($_POST['alert'])){
  $output='';$msg='';
  if($_SESSION['login_user']=='manager'){
  $qry=" SELECT * from submit_noti where manid={$_SESSION['userid']}  and status='unseen' ORDER BY noti_id DESC";
    $output.='<h5 id="noti_head" >NEW SUBMISSIONS</h5>';
    $msg.="no recent submission";
  }else{
    $output=deadline($conn,$id,$output);
   $qry="SELECT * from task_assign_noti where memid={$_SESSION['userid']} and status='unseen' ORDER BY noti_id DESC ";

     $msg.="no recent assignment";
  }

  $sql=mysqli_query($conn,$qry);
  if(mysqli_num_rows($sql) >0){
  while($row=mysqli_fetch_assoc($sql)){
    if($_SESSION['login_user']=='manager'){
      $output=submission_alert($row,$output,$conn);
    }else{  $output=assign_alert($row,$output,$conn);}
  }
 }else{
  $output.='
 <li class="starbucks success">
  <div class="notify_data">
  <div class="title">
   No Notifications
  </div>
  <div style="color:black;" class="sub_title">
   '.$msg.'
  </div>
  </div>
  <div class="notify_status">
  <p></p>
  </div>
  </li>';
}
echo $output;
}
if(isset($_POST['message'])){
   $output='';
   $output.='<h5 id="noti_head" >MESSAGES</h5>';
   $id=$_SESSION['userid'];
   $sql2="SELECT * FROM notification_msg WHERE user_id=$id GROUP BY projectid";
   $sql=mysqli_query($conn,$sql2);
   if(mysqli_num_rows($sql) >0){
   while($row=mysqli_fetch_assoc($sql)){

    $pid=$row['projectid'];
    $noti_id=$row['noti_id'];
    $time=$row['timee'];

    $pro=mysqli_query($conn,"SELECT * from projects where projectid='$pid'");
    $res=mysqli_fetch_row($pro);
    $pname=$res[2];
     $output.='<a   href="index.php?page=view_project&project='.$pid.'&del_noti='.$noti_id.'">
      <li class=" success">
     <div class="notify_data">
     <div class="title">
      New Message
     </div>
     <div style="color:black;" class="sub_title">
      In : '.$pname.'
     </div>
     </div>
     <div style="float:right;" class="notify_status">
     <p>'.$time.'<br>'.$row['datee'].'</p>
     </div>
     </li></a>';}
    }
    else{
      $output.='
     <li class="starbucks success">
      <div class="notify_data">
      <div style="color:black;" class="sub_title">
       no recent messages
      </div>
      </div>
      <div class="notify_status">
      <p></p>
      </div>
      </li>';
      }
        echo $output;
 }

 if(isset($_POST['msg_count'])){
  $output='';
    $id=$_SESSION['userid'];
    $sql2=mysqli_query($conn,"SELECT * FROM notification_msg WHERE user_id=$id GROUP BY projectid");
    $count=mysqli_num_rows($sql2);
    if($count>0){
      $output=$count;}
    echo $output;
  }

  if(isset($_POST["alert_count"])){
    $output="";
    if($_SESSION['login_user']=="manager"){
      $qry="SELECT * from submit_noti where manid=$id and status='unseen'";
    }else{
      $qry="SELECT * from task_assign_noti where memid=$id and status='unseen'";
    }
    $sql2=mysqli_query($conn,$qry);
    $count=mysqli_num_rows($sql2);
    if($count>0){$output=$count;}
    echo $output;
   }


function submission_alert($row,$output,$conn){

$pid=$row['projectid'];
$tid=$row['task_name'];
$project=mysqli_query($conn,"SELECT p.projectname,t.tittle from projects p INNER JOIN task t on t.pid=p.projectid where p.projectid='$pid' and t.tid=$tid");
$res=mysqli_fetch_assoc($project);

  $output.='
  <a   href="index.php?page=manager_actions/view_submissions&task_id='.$row['task_name'].'&del_noti='.$row['noti_id'].'">
   <li class=" success">
   <div class="notify_icon">
  
  </div>
  <div class="notify_data">
  <div class="title">
   Project:'.$res['projectname'].'
  </div>
  <div style="color:black;" class="sub_title">
   Task: '.$res['tittle'].'<br>By: '.$row['user_name'].'
  </div>
  </div>
  <div class="notify_status">
  <p>'.$row['datee'].'</p>
  </div>
  </li></a>';
   return $output;

}

function assign_alert($row,$output,$conn){

$output.='
<a   href="index.php?page=view_project&id='.$row['pid'].'&del='.$row['noti_id'].'">
 <li class=" success">
  <div style="width:220px;" class="notify_data">
  <div class="title">
  New Assignment
  </div>
  <div style="color:black;" class="sub_title">
   '.$row['tittle'].'<br>
   In: '.$row['projectname'].'<br>
  By: '.$row['managername'].'
  </div>
  </div>
  <div  class="notify_status">
  <p>Due Date<br>'.$row['due_date'].'</p>
  </div>
  </li></a>';
  return $output;

}
function deadline($conn,$id,$output){
  $due=mysqli_query($conn,"SELECT * from task t INNER JOIN member_task m on t.tid=m.tid where m.mid=$id");
  if(mysqli_num_rows($due)>0){
  while($row=mysqli_fetch_assoc($due)){
      $info=mysqli_query($conn,"SELECT * from projects where projectid='{$row['pid']}'");
      $detail=mysqli_fetch_assoc($info);
    if(empty($row['submission_date'])){
      $due_date=$row['due_date'];
      $last_day=date('Y-m-d',strtotime('-1 day',strtotime($due_date)));
      $today=date("Y-m-d");
      if($today==$last_day){
        $output.='
        <a   href="index.php?page=view_project&id='.$row['pid'].'">
         <li class=" baskin_robbins failed">
          <div style="width:220px;" class="notify_data">
          <div class="title">
           Remainder
          </div>
          <div style="color:black;" class="sub_title">
           lastday of Submission for :<br>'.$row['tittle'].'<br>
           In :'.$detail['projectname'].'<br>

          </div>
          </div>
          <div  class="notify_status">
          <p>Due Date<br>'.$row['due_date'].'</p>
          </div>
          </li></a>';
          return $output;
      }
      }
    }
  }
}
 ?>
