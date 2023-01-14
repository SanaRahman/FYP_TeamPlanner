<?php

include("./task_class.php");
include(".././database_connection.php");
$task1=new task();
$Error='';
//--------for chat------------

$userid=$_SESSION['userid'];
$proid=$_SESSION['ptid'];
date_default_timezone_set('Asia/Karachi');


if(isset($_POST['submit_task'])){
$e='';
$sql=mysqli_query($conn,"SELECT filetype,due_date FROM task where tid={$_SESSION['sub_task']}");
$res=mysqli_fetch_assoc($sql);
$type=$res['filetype'];
$due_date=$res['due_date'];

  $filename=$_FILES['dfile']['name'];
  $tm= $_FILES['dfile']['tmp_name'];

  if(empty($filename)){
    $e="Please chose a file";
  }else{
  $fileExt=explode('.',$filename);
  $given=explode('-',$type);
  $fileActualExt=strtolower(end($fileExt));

      if(in_array($fileActualExt,$given)){
      $filename=time().'-'.$filename;
      move_uploaded_file($tm,".././member_uploads/".$filename);
    }else{$e="Chose a file among the allowed file"  ;}
  }
  if(empty($e)){
      $tid=$_SESSION['sub_task'];
      $manid=$_SESSION['userid'];
   $ans= $task1->upload_members_task($filename,$manid,$tid,$due_date,$conn);
    $e="success";
   }
  echo $e;
}


//------------------sending a message---------------//
if(isset($_POST["send"])){

  $outgoing_id = $userid;
  $message = $_POST['message'];
  $role='member';
  if($_SESSION['login_user']=="manager"){
    $role='manager';
  }
  if(!empty($message)){
    $date = date('d-m-y');
    $time=date('h:ia');
   $sql = mysqli_query($conn, "INSERT INTO chat_msg (projectid, outgoing_msg_id,msg_time,msg_date,msg,role)
  VALUES ('{$proid}', {$outgoing_id},'$time','$date','{$message}','{$role}')");

  generate_msg_notification($proid,$userid,$date,$time,$conn);
}

}

//--------------showing a message---------------------

if(isset($_POST["show_chat"])){

$outgoing_id = $userid;
$members=get_chat_members($proid,$conn);
$output="";

$sql2 = "SELECT * FROM chat_msg Where projectid='{$proid}' ORDER BY msg_id";
$query=mysqli_query($conn,$sql2);
$f=0;
if(mysqli_num_rows($query) > 0){
while($row=mysqli_fetch_assoc($query)){

      //sender code
 if($row['outgoing_msg_id']==$userid && $_SESSION['login_user']==$row['role']){
   $date=$row['msg_date'];
if($row['msg_date']==date('d-m-y')){
  $date="Today";
}
     $output.='
      <div class="chat outgoing">
      <div class="details">
      <p>'. $row['msg'] .'<br><small><span style=" float:left;  font-size:14px;
      color: #aaa; padding-top:2px;">'.$row['msg_time'].'</span><span style=" float: right;  font-size:14px;   color: #aaa; padding-top:2px; padding-left:15px;">
      '.$date.'</span></small>
       <br></p>
       </div>
       </div>';
 }else {
//------receiver code
   $q=mysqli_query($conn,"DELETE FROM notification_msg where projectid='$proid' and user_id=$userid");
$incoming_name="";
$incoming_id="";
$role="";

//foreach($members as $id )
for( $j=0;$j<=sizeof($members);$j++){
if($members[0][0]==$row['outgoing_msg_id'] && $row['role']=='manager'){
    $incoming_id=$members[0][0];
    $incoming_name=$members[1][0];
    $role="&nbsp&nbsp~manager";
      break;
  }else if($members[0][$j]==$row['outgoing_msg_id'] && $row['role']=='member'){
    $incoming_id=$members[0][$j];
    $incoming_name=$members[1][$j];
      break;
  }
}
$date=$row['msg_date'];
if($row['msg_date']==date('d-m-y')){
$date="Today";
}
  $output .= '
  <div class="chat incoming">
 <div class="details">
 <p><small><span font-size:8px; style="float:left; padding-top:4px; padding-left:2px;
 color: #aaa;">'.$incoming_name.'</t>'.$role.'</span></small><br>'
. $row['msg'] .'<br><span style="float:left; font-size:14px;
color: #aaa; padding-top:2px;">'.$date.'</span><span style="float:right; font-size:14px; color: #aaa; padding-top:2px; padding-left:15px;">'.$row['msg_time'].'</span>
<br></p>
</div></div>';
      }
    }
  }else{$output .= '<div style="color:black;" class="text">No messages are available. Once you send message they will appear here.</div>';  }
echo $output;
}

//-----------------------------------------------------------//

function get_chat_members($proid,$conn){
  //get project manager
  $sql=mysqli_query($conn,"SELECT * FROM projects WHERE projectid='{$proid}'");
  while($r=$sql->fetch_row()){
    $member_id[0]=$r[5];
    $member_name[0]=$r[6];
  }
  //get project members
  $sql=mysqli_query($conn,"SELECT * FROM member_list WHERE projectid='{$proid}'");
  if(mysqli_num_rows($sql)>0){
    $i=1;
    while($res=mysqli_fetch_array($sql)){
      $member_id[$i]=$res['memberid'];
      $member_name[$i]=$res['membername'];
      $i++;
    }}

    return array($member_id,$member_name);
}

function generate_msg_notification($proid,$sender,$date,$time,$conn){
 $members=get_chat_members($proid,$conn);
 for( $j=0;$j<=sizeof($members);$j++){
   //if its not the sender generate notification for all other
  if($members[0][$j]!=$sender){
     $id=$members[0][$j];
     $sql6 = mysqli_query($conn, "INSERT INTO notification_msg (projectid,user_id,datee,timee)
     VALUES ('$proid',$id,'$date','$time')");
   }
 }
}

?>
