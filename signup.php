<?php  include 'header.php'; ?>
<head>
<link href="styles/forms.css" rel="stylesheet">
<style>#err{  display: none;}</style>
</head>

<form  id="form" action="test.php" method="POST">
  <div class="container">
  <div  class="logo"> <h1 >Team Planner</h1></div>
   <h3>Sign Up</h3>
  <div  id="err" class="error-text"></div>
  <hr>
    <label for="Username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" id="username" required>
    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
    <label for="Repeat"><b> Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="repeat" id="repeat" required>
    <label for="gmail"><b>Gmail</b></label>
    <input type="text" placeholder="Enter Gmail" name="gmail" id="gmail" required>

    <button  id="manager"  name="sign_manager" type="submit"  class="registerbtn">Signup for Manager</button>
    <button  id="member" name="sign_member" type="submit"  class="registerbtn">Signup for Member</button>
    <hr>
    <p class="already">Already have an account? <a href="login.php">Login</a>.</p>
   </div>

</form>


<script>
  const form=document.querySelector("#form"),
  btn=form.querySelector("#manager"),
  btn2=form.querySelector("#member"),
  error=form.querySelector(".error-text");

  form.onsubmit=(e)=>{
    e.preventDefault();
  }

//on manager Signup
  btn.onclick=()=>{
    console.log(btn);
  const xhr=new XMLHttpRequest();
  xhr.open("POST","php_backend/forms.php",true);
  xhr.onload= ()=>{
    if(xhr.readyState===4){
      if(xhr.status===200){
    let data=xhr.response;
    if(data=="success"){
      start_load();
      alert_toast("Login Successful",'success')
      setTimeout(function(){
          location.href="index.php?page=dashboard";
      },1500)

    }
    else{
      error.style.display = "block";
      error.textContent=data;}
      }
    }
  }
  let formdata=new FormData(form);
  formdata.append("sign_manager","sign_manager");
  xhr.send(formdata);
  }
//---------------------------------on member Signup----------------------------------//
  btn2.onclick=()=>{
    console.log(btn);
  const xhr=new XMLHttpRequest();
  xhr.open("POST","php_backend/forms.php",true);
  xhr.onload= ()=>{
    if(xhr.readyState===4){
      if(xhr.status===200){
    let data=xhr.response;
    if(data=="success"){
      start_load();
      alert_toast("Signup Successful",'success')
      setTimeout(function(){
          location.href="index.php?page=dashboard";
      },1500)
    }
    else{
      error.style.display = "block";
      error.textContent=data;
    }
      }
    }
  }
  let formdata=new FormData(form);
  formdata.append("sign_member","sign_member");
  xhr.send(formdata);
  }
</script>-->
<?php include 'footer.php' ?>
