<?php
$dbservername="localhost";
$dbusername="root";
$dbpassword="";
$dbname="team_planner";

//<----------------Database creation--------------------->
$conn=new mysqli($dbservername, $dbusername,$dbpassword);

if($conn->connect_error){
    die("Connection failed:");
}
$sql="CREATE DATABASE IF NOT EXISTS team_planner";
if($conn->query($sql)===false){
   die("Database creation failed");
}

//$conn->close();
//<--------------------database connection---------------------->
$conn=new mysqli($dbservername, $dbusername,$dbpassword,$dbname);


//<------------------------Accounts table Creation--------------->
$sql2="CREATE TABLE IF NOT EXISTS accounts_manager(
   userid INT(6) PRIMARY KEY AUTO_INCREMENT not null,
   username TINYTEXT not null,
   passwod LONGTEXT not null,
   gmail TINYTEXT not null,
   code TINYTEXT,
   timee TINYTEXT
   )";

if($conn->query($sql2)===false){
   echo("Error cant create table");
}
//<------------------------Accounts table Creation--------------->
$sql2="CREATE TABLE IF NOT EXISTS accounts_member(
  userid INT(6) PRIMARY KEY AUTO_INCREMENT not null,
  username TINYTEXT not null,
  passwod LONGTEXT not null,
  gmail TINYTEXT not null,
  code TINYTEXT,
  timee TINYTEXT
  )";

if($conn->query($sql2)===false){
  echo("Error cant create table");
}


$sql3="CREATE TABLE IF NOT EXISTS projects(
  id INT(6) PRIMARY KEY AUTO_INCREMENT not null,
  projectid TINYTEXT   not null,
  projectname TINYTEXT not null,
  department TINYTEXT not null,
  description TINYTEXT not null,
  managerid INT(6) not null,
  managername TINYTEXT not null,
  datee date not null,
  end_date date,
  status TINYTEXT not null,
  noft INT(3),
  Progress Float
  )";

if($conn->query($sql3)===false){
  echo("Error cant create table");
}

$sql4="CREATE TABLE IF NOT EXISTS member_list(
  id INT(6) PRIMARY KEY AUTO_INCREMENT not null,
  projectid TINYTEXT   not null,
  projectname TINYTEXT not null,
  memberid INT(6) not null,
  membername TINYTEXT not null,
  gmail TINYTEXT not null
  )";

if($conn->query($sql4)===false){
  echo("Error cant create table");
}

$sql5="CREATE TABLE IF NOT EXISTS task(
  tid INT(100) PRIMARY KEY  not null AUTO_INCREMENT,
  pid TINYTEXT,
  tittle TINYTEXT,
  description TINYTEXT,
  due_date date,
  myfile TINYTEXT,
  nofmem INT(100),
  status TINYTEXT,
  Progress FLOAT,
  filetype LONGTEXT
  )";

if($conn->query($sql5)===false){
  echo("hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhError cant create task table");
}

$sql6="CREATE TABLE IF NOT EXISTS member_task(
  id INT(6) PRIMARY KEY AUTO_INCREMENT not null,
  tid INT(100),
  mid INT(6),
  member_file TINYTEXT,
  submission_date date,
  status TINYTEXT
  )";
if($conn->query($sql6)===false){
  echo(" cant create member_task table");
}

$sql7="CREATE TABLE IF NOT EXISTS chat(
  chat_id INT(6) PRIMARY KEY AUTO_INCREMENT not null,
  projectid TINYTEXT  not null,
  name TINYTEXT,
  img TINYTEXT
  )";
if($conn->query($sql7)===false){
  echo(" cant create chat table");
}

$sql8="CREATE TABLE IF NOT EXISTS chat_msg(
  msg_id INT(6) PRIMARY KEY AUTO_INCREMENT not null,
  projectid TINYTEXT   not null,
  incoming_msg_id INT(6),
  outgoing_msg_id INT(6),
  msg_time TINYTEXT,
  msg_date TINYTEXT,
  msg LONGTEXT,
  role TINYTEXT
  )";

if($conn->query($sql8)===false){
  echo(" cant create chat_msg table");
}

$sql9="CREATE TABLE IF NOT EXISTS notification_msg(
  noti_id INT(6) PRIMARY KEY AUTO_INCREMENT not null,
  projectid TINYTEXT not null,
  user_id INT(6),
  datee TINYTEXT,
  timee TINYTEXT
  )";

if($conn->query($sql9)===false){
  echo(" cant create notification_msg table");
}


$sql10="CREATE TABLE IF NOT EXISTS submit_noti(
  noti_id INT(6) PRIMARY KEY AUTO_INCREMENT not null,
  projectid TINYTEXT not null,
  user_name TINYTEXT,
  task_name TINYTEXT,
   datee TINYTEXT,
   status TINYTEXT,
   manid INT
  )";

if($conn->query($sql10)===false){
  echo(" cant create notification_msg table");
}

$sql11=mysqli_query($conn,"alter table accounts_member auto_increment=50000");
if(!$sql11){
  echo '<script>alert("Error removing file from folder") </script>';
}

$sql12="CREATE TABLE IF NOT EXISTS task_assign_noti(
  noti_id INT(6) PRIMARY KEY AUTO_INCREMENT not null,
  pid TINYTEXT,
  projectname TINYTEXT not null,
  managername TINYTEXT,
  tittle TINYTEXT,
  due_date TINYTEXT,
   memid INT,
  status TINYTEXT
  )";

if($conn->query($sql12)===false){
  echo(" cant create notification_msg table");
}

$sql13="CREATE TABLE IF NOT EXISTS accounts(
  id INT(6) PRIMARY KEY AUTO_INCREMENT not null,
  userid INT,
  dp TINYTEXT,
  no TINYTEXT,
  first_name TINYTEXT,
  last_name TINYTEXT,
  email TINYTEXT,
  org_name TINYTEXT,
  birthday TINYTEXT,
  location TINYTEXT
  )";

if($conn->query($sql13)===false){
  echo(" cant create notification_msg table");
}
/*$sql2="CREATE TABLE IF NOT EXISTS manager_projects(
  project_id INT(6) PRIMARY KEY AUTO_INCREMENT not null,
  manager_id int(6),
  projectname TINYTEXT not null,
  project_code TINYTEXT not null,
  gmail TINYTEXT not null
  )";

if($conn->query($sql2)===false){
  echo("Error cant create table");
}*/





//<----------------------------FUNCTIONS------------------------>


?>
