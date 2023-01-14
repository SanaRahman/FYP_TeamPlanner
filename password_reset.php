<?php
 include 'header.php';
include_once "database_connection.php";
if(isset($_GET['code'])){
  $code=$_GET['code'];
  $type=$_GET['type'];
  $id=$_GET['id'];
}
?>

<head>
<link href="styles/forms.css" rel="stylesheet">
 <style>.error-text{  display: none;}</style>
</head>

<div class="container">
<div class="logo"> <h1>Team Planner</h1> </div>
<h3 >Password Reset</h3>
<div  id="err" class="error-text"></div>
  <hr>
 <form id="form" action="#" method="POST">
  <label for="psw"><b>Password</b></label>
  <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

  <label for="psw-repeat"><b>Repeat Password</b></label>
  <input type="password" placeholder="Repeat Password" name="repeat" id="psw-repeat" required>
  <button  id="but" name="reset_password" type="submit"  class="registerbtn">Reset Password</button>
  <hr>

</form>
</div>
<script>
const form=document.querySelector("#form"),
 bt=form.querySelector("#but"),
  er=form.querySelector("#err"),
 error=form.querySelector(".error-text");

 form.onsubmit=(e)=>{
   e.preventDefault();
 }

 bt.onclick=()=>{
    start_load();
 const xhr=new XMLHttpRequest();
  xhr.open("POST","php_backend/password_recovery.php",true);
 xhr.onload= ()=>{
   if(xhr.readyState===4){
     if(xhr.status===200){
   let data=xhr.response;
   if(data=="success"){

     alert_toast("Password Rest Saved",'success')
     setTimeout(function(){
      location.href = "login.php?reset=3";
     },1500)

    }
   else{
     end_load();
      document.getElementById("err").style.display = "block";
     document.getElementById("err").textContent=data;
     }
     }
   }
 }
 let formdata=new FormData(form);
 formdata.append("password_reset","password_reset");
  formdata.append("code","<?php echo $code;?>");
  formdata.append("type","<?php echo $type;?>");
 xhr.send(formdata);
 }
</script>



<?php
$code2='';
if($type=="manager"){
$sql=mysqli_query($conn,"SELECT code from accounts_manager where userid='$id'");
  if(mysqli_num_rows($sql)>0){
  while($res=mysqli_fetch_row($sql)){
    $code2=$res[0];}
  }
}
else{
  $sql=mysqli_query($conn,"SELECT code from accounts_member where userid='$id'");
  if(mysqli_num_rows($sql)>0){
    while($res=mysqli_fetch_row($sql)){
      $code2=$res[0];}
  }
}
if($code!=$code2){?>
<script>
  document.getElementById("err").style.display = "block";
  document.getElementById("err").textContent = "Your Token has expired issue a new one to reset password.";
  document.getElementById("form").style.display="none";
</script>
  <?php
}?>
<?php include 'footer.php' ?>
