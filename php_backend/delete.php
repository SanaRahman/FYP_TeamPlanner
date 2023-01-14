
<?php include(".././php_backend/task_class.php");
include(".././database_connection.php");

$task1=new task();

if(isset($_GET['remove_member'])){
  $id=$_POST['id'];
  $ans= $task1->remove_member_from_task($id,$conn);
  echo 1;

}
if(isset($_GET['delete_task'])){
  $del=$_POST['id'];
  $ans=$task1->delete_task($del,$conn);
  echo $ans;
}

?>
