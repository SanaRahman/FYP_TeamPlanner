
<?php
if(session_status() == PHP_SESSION_ACTIVE){
    header("location:index.php?page=dashboard");
}

//when page is directed on click of project share link for a member
$link=0;$code='';
if(isset($_GET['open'])){
$link=1;
$code=$_GET['id'];
}
 include 'header.php';
?>


 <head>
 <link href="styles/forms.css" rel="stylesheet">
 <style>#err{  display: none;}</style>
 </head>

<form style="" id="form" action="test.php" method="POST">
  <div class="container">
  <div  class="logo"> <h1 >Team Planner</h1></div>
   <h3>Login In</h3>
  <div  id="err" class="error-text"></div>
  <hr>
    <label for="Username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" id="username" required>
    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

    <button  id="manager"  name="login_manager" type="submit"  class="registerbtn">Login for Manager</button>
    <button  id="member" name="login_member" type="submit"  class="registerbtn">Login for Member</button>
    <hr>
    <p class="already">Don't have an account? <a href="signup.php">SignUp</a></p>
    <p class="already">Forgot Password? <a href="./password_recovery.php">Click here</a></p>
   </div>

</form>

<?php
//------------------show reset message------
if(isset($_GET['email_sent'])){
  echo "<script type=\"text/javascript\">
       window.onload = function() {
         document.getElementById('err').style.display = 'block';
         document.getElementById('err').textContent = 'Check gmail for reset message';
       };
     </script>";
}
else if(isset($_GET['reset'])){
  echo "<script type=\"text/javascript\">
       window.onload = function() {
         document.getElementById('err').style.display = 'block';
          document.getElementById('err').textContent = 'Password Reset Successful';
       };
     </script>";
}
 ?>

<script>
  const form=document.querySelector("#form"),
  btn=form.querySelector("#manager"),
  btn2=form.querySelector("#member"),
  error=form.querySelector(".error-text");

  form.onsubmit=(e)=>{
    e.preventDefault();
  }


  btn.onclick=()=>{

  const xhr=new XMLHttpRequest();
  xhr.open("POST","php_backend/forms.php?login_manager",true);
  xhr.onload= ()=>{
    if(xhr.readyState===4){
      if(xhr.status===200){
    let data=xhr.response;
    if(data=="success"){
      alert_toast("Login Successful",'success')
      setTimeout(function(){
        location.href="./index.php?page=dashboard";
      },1500)
     }
    else{

      error.style.display = "block";
     error.textContent=data;}
      }
    }
  }
  let formdata=new FormData(form);

  xhr.send(formdata);
  }
//---------------------------------on member Signup----------------------------------//
  btn2.onclick=()=>{

  const xhr=new XMLHttpRequest();
  xhr.open("POST","php_backend/forms.php",true);
  xhr.onload= ()=>{
    if(xhr.readyState===4){
      if(xhr.status===200){
    let data=xhr.response;
    if(data=="success"){

      alert_toast("Login Successful",'success')
      setTimeout(function(){
          location.href="index.php?page=dashboard";
      },1500)

      }
    else if(data=="link"){
      location.href="index.php?page=member_project&id=<?php echo $code; ?>&open=1";
    }
    else{
      error.style.display = "block";
      error.textContent=data;
    }
      }
    }
  }
  let formdata=new FormData(form);
  formdata.append("login_member","login_member");
  formdata.append("link","<?php echo $link;?>");
  formdata.append("code","<?php echo $code;?>");
  xhr.send(formdata);
  }
</script>-->
<?php include 'footer.php' ?>
