

<?php  include 'header.php'; ?>
<head>
<link href="styles/forms.css" rel="stylesheet">
</head>

<form id="form" action="#" method="POST">
  <div class="container">
  <div class="logo"> <h1>Team Planner</h1> <div>
<h3 >Password Reset</h3>
  <div class="error-text">Please fill in the Email Address you registered your account with..</div>
  <hr>
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" id="email" required>
    <button  id="b" type="submit"  class="registerbtn">Reset for Manager</button>
    <button  id="mem" type="submit"  class="registerbtn">Reset for Member</button>
    <hr>
    <p class="already">Already have an account? <a href="login.php">Login</a>.</p>
   </div>

</form>

<!--_________________________________Reset form___________________________-->



<script>
  const form=document.querySelector("#form"),
  btn=form.querySelector("#b"),
  btn2=form.querySelector("#mem"),
  error=form.querySelector(".error-text");

  form.onsubmit=(e)=>{
    e.preventDefault();
  }

//on manager reset
  btn.onclick=()=>{
    start_load();
  const xhr=new XMLHttpRequest();
  xhr.open("POST","php_backend/password_recovery.php",true);
  xhr.onload= ()=>{
    if(xhr.readyState===4){
      if(xhr.status===200){
    let data=xhr.response;
    if(data=="success"){

      alert_toast("Email Sent",'success')
      setTimeout(function(){
          location.href = "login.php?email_sent=1";
      },1500)
    }
    else{
      end_load();
      error.textContent=data;
    }
      }
    }
  }
  let formdata=new FormData(form);
  formdata.append("password_recovery","password_recovery");
  xhr.send(formdata);
  }
//---------------------------------on member rest----------------------------------//
  btn2.onclick=()=>{
    start_load();
  const xhr=new XMLHttpRequest();
  xhr.open("POST","././php_backend/password_recovery.php",true);
  xhr.onload= ()=>{
    if(xhr.readyState===4){
      if(xhr.status===200){
    let data=xhr.response;
    if(data=="success"){

      alert_toast("Email Sent",'success')
      setTimeout(function(){
          location.href = "login.php?email_sent=1";
      },1500)

    }
    else{
      end_load();
      error.textContent=data;
    }
      }
    }
  }
  let formdata=new FormData(form);
  formdata.append("password_recovery_mem","password_recovery_mem");
  xhr.send(formdata);
  }
</script>
<?php include 'footer.php' ?>
