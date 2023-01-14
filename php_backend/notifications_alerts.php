<?php

 Class notification{

  function new_sub($conn,$date,$pid,$tname,$memid){
    $s1="SELECT managerid from projects where projectid='$pid'";
    $q=mysqli_query($conn,$s1);
    $result=mysqli_fetch_row($q);
    $manid=$result[0];

     $s2=mysqli_query($conn,"SELECT username from accounts_member where userid='$memid'");
     $result=mysqli_fetch_row($s2);
     $username=$result[0];

    $sql = mysqli_query($conn, "INSERT INTO submit_noti(projectid,user_name,task_name,datee,status,manid)
    VALUES ('$pid', '$username', '$tname','$date','unseen','$manid')");
    if(!$sql){'<script>alert("error generating submission notification") </script>';}
  }

  function new_task_assign_noti($conn,$selected,$tid,$pid){
    $s1=mysqli_query($conn,"SELECT managername,projectname from projects where projectid='$pid'");
    $result=mysqli_fetch_row($s1);
    $manname=$result[0];
    $pname=$result[1];

    $s2=mysqli_query($conn,"SELECT tittle,due_date from task where tid='$tid'");
    $result=mysqli_fetch_row($s2);
    $tittle=$result[0];
    $due_date=$result[1];

    $sql = mysqli_query($conn, "INSERT INTO task_assign_noti(pid,projectname,managername,tittle,due_date,memid,status)
    VALUES ('$pid','$pname', '$manname', '$tittle','$due_date','$selected','unseen')");

  }

}//end of class
?>
