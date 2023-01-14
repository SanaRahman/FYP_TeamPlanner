<?php
include(".././database_connection.php");
include("./task_class.php");
$task1=new task();

$tittle=$due_date=$details=$strallowed="";
$members=array();
$types=array('pdf','jpeg','docx','jpg','mp4','pptx','zip','png');
$Error='';

if(isset($_GET['add_task']) || isset($_GET['edit_task'])){

$details=$_POST['details'];
$tittle=$_POST['tittle'];
$due_date=$_POST['due_date'];
$date=date("Y-m-d",strtotime($due_date));

//------------file------------------//
$filename=$_FILES['dfile']['name'];
$tm= $_FILES['dfile']['tmp_name'];
$size=$_FILES['dfile']['size'];

if(empty($tittle) || empty($due_date) || empty($details) ){
  $Error="Fill all fields";
}
else if(isset($_GET['edit_task']) && empty($filename)){
  $filename="";
}
else{

$fileExt=explode('.',$filename);
$fileActualExt=strtolower(end($fileExt));
if(in_array($fileActualExt,$types)){
$filename=time().'-'.$filename;
move_uploaded_file($tm,".././manager_uploads/".$filename);
}else{ $Error='Attachment File type not allowed.  Choose among pdf, jpeg, jpg, docx, mp4, pptx, zip, png';}

}
if(!empty($_POST['allowed'])){
  foreach($_POST['allowed'] as $selected ){
    $strallowed=$strallowed."-".$selected;
  }
}else{
  $Error="Select Allowed file type for Submission";
}


if(isset($_GET['add_task'])){
if(!empty($_POST['employees'])){
  $i=0;
  foreach($_POST['employees'] as $select ){
  $members[$i]=$select;
  $i++;}
  }
  else{
    $Error="Select Members To Assign the task";
  }
}

  $today=date('Y-m-d');
  if($date<$today){
    $Error="Select a due date greater than today";
  }

if(empty($Error)){
  if(isset($_GET['add_task'])){
  $ans= $task1->add_new_task($tittle,$details,$date,$strallowed,$filename,$members,$conn);
  if($ans==1){$Error=1;}
}else if(isset($_GET['edit_task'])){
  $ans=$task1->update_task($tittle,$details,$date,$strallowed,$filename,$conn);
  if($ans==1){$Error=1;}
   }
}
echo $Error;
}

?>
