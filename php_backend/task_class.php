<?php
session_start();
//for generating notifications
include("./notifications_alerts.php");
$noti=new notification();

Class task{


  function add_new_task($tittle,$details,$date,$strallowed,$filename,$members,$conn){
    $pid=$_SESSION['ptid'];
    $nofmem=count($members);
    $sql="INSERT INTO task(pid,tittle,description,due_date,myfile,nofmem,status,Progress,filetype)
    VALUES('$pid','$tittle','$details','$date','$filename','$nofmem','pending',0,'$strallowed')";

    if($conn->query($sql)==TRUE){

    $this->update_project_task($conn,$pid);

    $sql2="SELECT tid FROM task ORDER BY tid DESC LIMIT 1";
    $query=mysqli_query($conn,$sql2);
    if( $result=mysqli_fetch_assoc($query)){
      $tid=$result['tid'];
      //assign task to all members.
      $ans=$this->add_member_task($members,$tid,$conn,$pid);
      return 1;
    }else{
    '<script>alert(" in deleting line 22 task class") </script>';}
  }
  return 1;
  }
  function update_project_task($conn,$pid){
    $sql="SELECT * FROM projects where projectid='$pid'";
    $q=mysqli_query($conn,$sql);
    if($res=mysqli_fetch_assoc($q)){
      //increase no of task in project table
      $no=$res['noft'];
      $no=$no+1;
      $progress=0;
      //calculate the progress for each task
      $per=100/$no;
      $sql="SELECT * FROM task where pid='$pid'";
      $q=mysqli_query($conn,$sql);
      while($res=mysqli_fetch_assoc($q)){
        if($res['status']=='completed'){
          //add the progress of completed task
          $progress=$progress+$per;
        }
      }
      //update the final progress and no f task after adding a new one.
      $sql2="UPDATE projects SET noft=noft+1,Progress='$progress' where projectid='$pid'";
      if(!$conn->query($sql2)){
          '<script>alert(" in uodating tasks line 14 task class") </script>';
      }
    }
  }
  function add_member_task($members,$tid,$conn,$pid){
    $i=0;    global $noti;
    foreach ($members as $selected) {
      $sql="INSERT INTO member_task(tid,mid,status)
      VALUES('$tid','$selected','pending')";
        //generate notifications for members on task is_uploaded_file
        $noti->new_task_assign_noti($conn,$selected,$tid,$pid);
       if(!$conn->query($sql)){
        echo  '<script>alert("error on line 58 task_class") </script>';
        $i++;  }
     }
    if($i==0){return 1;}
  }

function update_task($tittle,$details,$date,$strallowed,$filename,$conn){
if(empty($filename)){
  $sql="UPDATE task SET tittle='$tittle',
  description='$details',due_date='$date',filetype='$strallowed' where tid={$_SESSION['ed_task']}";
}
else{
  $sql="UPDATE task SET tittle='$tittle',
  description='$details',due_date='$date',myfile='$filename',filetype='$strallowed' where tid={$_SESSION['ed_task']}";
}
  if ($conn->query($sql) === TRUE) {
    return 1;
  }
  else {
    '<script>alert(" in deleting line49 task class") </script>';
    }

}

  function upload_members_task($filename,$manid,$iid,$due_date,$conn){
    $pid;
    $date=date("Y-m-d");
    $stat='completed';
    if($date>$due_date){
      $stat="Over Due";
    }else if($due_date<=$date){
        $stat='completed';
    }
    $sql="UPDATE member_task SET member_file='$filename',submission_date='$date',status='$stat' where tid='$iid' AND mid='$manid'";
    if ($conn->query($sql) === TRUE) {
//--------for notifications--------------
     global $noti;
      $sql2="SELECT * FROM task WHERE tid=$iid";
      $query=mysqli_query($conn,$sql2);
      if($result=mysqli_fetch_assoc($query)){
      $no=$result['nofmem'];
      $pid=$result['pid'];
      $tname=$result['tittle'];
      $one=100/$no;

      $noti->new_sub($conn,$date,$pid,$iid,$manid);

      $sql3="UPDATE task SET Progress=Progress+'$one' WHERE tid=$iid";
      if ($conn->query($sql3)){
      $sql4="SELECT Progress From task where tid=$iid";
      $query=mysqli_query($conn,$sql4);
      if($result=mysqli_fetch_assoc($query)){
      if (ceil($result['Progress'])==100){
      $sql5="UPDATE task SET status='completed' where tid=$iid";
      if (!$conn->query($sql5) ){
      '<script>alert(" on line 70 class") </script>';}
        else{$this->update_task_progress($pid,$conn);}
        }
        }
        }
        }
      return 1;
      }//if ends
          return 1;
}


function update_task_progress($pid,$conn){
  $found=0;$status='pending';
  $progress=0;
  $sql="SELECT * FROM projects WHERE projectid='$pid'";
  $query=mysqli_query($conn,$sql);
  if($result=mysqli_fetch_array($query)){
    $noft=$result['noft'];
    $found++;
  }
  if($found>0){
    $pertask=100/$noft;
    $sql3="SELECT * FROm task where pid='$pid'";
    $q=mysqli_query($conn,$sql3);
    while($res=mysqli_fetch_array($q)){
      if($res['status']=='completed'){
        $progress=$progress+$pertask;
      }
    }
    if(ceil($progress)==100){
      $status='completed';
    }
    $sql2="UPDATE projects SET Progress='$progress' where projectid='$pid'";
      if (!$conn->query($sql2)){
        '<script>alert(" on line 119 class") </script>';}
  }

}
function delete_task($del,$conn){
  $f=0;
  //first remove its files from folder.
 $sql3="DELETE FROM task where tid=$del";
  $query=mysqli_query($conn,$sql3);

//update project progress.
$f=0;

$proid=$_SESSION['ptid'];
$progress=0;

$sql4="SELECT * FROM projects where projectid='$proid'";
$query=mysqli_query($conn,$sql4);
if($result=mysqli_fetch_assoc($query)){
  $noft=$result['noft'];
  $f++;}

if($f>0){
$noft=$noft-1;
if($noft>0){
$pertask=100/$noft;
$sql5="SELECT * FROM task where pid='$proid'";
$query=mysqli_query($conn,$sql5);
while($row=mysqli_fetch_array($query)){
  if($row['status']=='completed'){
    $progress=$progress+$pertask;
  }
}
$sql2="UPDATE projects SET noft='$noft',Progress='$progress' where projectid='$proid'";
  if (!$conn->query($sql2)){'<script>alert(" on line 119 class") </script>';}
}
}

//remove all members from that task
$sql2="DELETE FROM member_task where tid=$del";
$query=mysqli_query($conn,$sql2);

return 1;
//if($query){$_SESSION['task_delete']="task_delete";}
//else{  '<script>alert(" in deleting line 64 task class") </script>';}
}


function remove_member_from_task($uid,$conn){
$tid=$_SESSION['tid'];

  $sql="DELETE FROM member_task where mid=$uid and tid=$tid";
  $query=mysqli_query($conn,$sql);

  if($query){

    $sql2="UPDATE task SET nofmem=nofmem-1 WHERE tid=$tid";
    $query2=mysqli_query($conn,$sql2);
    if(!$query2){'<script>alert(" decrementing no ine 125") </script>';}
 else{
      $sql3="SELECT * FROM task where tid=$tid";
      $query3=mysqli_query($conn,$sql3);
      if($result=mysqli_fetch_assoc($query3)){
      $no=$result['nofmem'];
      if($no<=0){
        //here
        $this->delete_task($tid,$conn);
      }
      else{
        $per=100/$no;
        $sql="SELECT * FROM member_task where tid=$tid";
        $query=mysqli_query($conn,$sql);
        $progress=0;
        while($res=mysqli_fetch_array($query)){
          $stat=$res['status'];
          if($stat=='completed'){
            $progress=$progress+$per;
          }
        }
        $sql2="UPDATE task SET Progress='$progress' WHERE tid=$tid";
        $query2=mysqli_query($conn,$sql2);
        $_SESSION['dtask_member']="deleted";
     }
    }
    else{
        '<script>alert(" while removing task ine 120") </script>';
    }
  }
}
  else{
        '<script>alert(" while removing member ine 127") </script>';
  }
}



}
?>
