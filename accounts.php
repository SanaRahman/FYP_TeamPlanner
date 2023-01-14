 
<head>
  <link rel="stylesheet" type="text/css" href="styles/accounts.css" media="print">
  </head>

  <?php
  $account=mysqli_query($conn,"SELECT * FROM accounts where userid={$_SESSION['userid']}");
  $row=mysqli_fetch_assoc($account);

  $first_name=$row['first_name'];
  $email=$row['email'];
  $last_name=$row['last_name'];
  $org_name=$row['org_name'];
  $location=$row['location'];
  $no=$row['no'];
  $birthday=$row['birthday'];
  $dp=$row['dp'];

   ?>
<div class="container-xl px-4 ">
    <!-- Account page navigation-->

    <hr class="mt-0 mb-2">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img style="height:200px; width:200px; "class="img-account-profile rounded-circle " src="assets/profile/<?php echo $dp ?>" alt="">
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">upload profile JPEG, JPG or PNG </div>
                    <!-- Profile picture upload button-->

                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                        <form id="form2" action="" method="POST">
                        <div  id="err" class="error-text"></div>

                        <!-- Form Group (username)-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (first name)-->
                            <div class="col-md-12">
                                <label class="small mb-1" for="">This information shall appear to everyone on site</label>
                            </div>

                          </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (first name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstName">First name</label>
                                <input class="form-control" id="inputFirstName" type="text" name="first_name" placeholder="Enter your first name" value="<?php echo $first_name;?>">
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLastName">Last name</label>
                                <input class="form-control" id="inputLastName" type="text" name="last_name" placeholder="Enter your last name" value="<?php echo $last_name;?>">
                            </div>
                        </div>
                        <!-- Form Row        -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (organization name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputOrgName">Organization name</label>
                                <input class="form-control" id="inputOrgName" name="org_name" type="text" placeholder="Enter your organization name" value="<?php echo $org_name;?>">
                            </div>
                            <!-- Form Group (location)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLocation">Location</label>
                                <input class="form-control" id="inputLocation" name="location" type="text" placeholder="Enter your location" value="<?php echo $location;?>">
                            </div>
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Email address</label>
                            <input class="form-control" id="inputEmailAddress" name="email" type="email" placeholder="Enter your email address" value="<?php echo $email;?>">
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (phone number)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputPhone">Phone number</label>
                                <input class="form-control" id="inputPhone" name="no" type="tel" placeholder="Enter your phone number" value="<?php echo $no;?>">
                            </div>
                            <!-- Form Group (birthday)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputBirthday">Birthday</label>
                                  <input type="date" class="form-control" autocomplete="off" name="birthday" value="<?php echo $birthday;?>" >
                            </div>
                        </div>

                        <div class="row gx-3 mb-3">
                          <div class="col-md-6">
                              <label class="small mb-1" for="upload">Change Profile Picture</label>
                                  <input style="color:blue;" type="file" name="dp">
                          </div>
                        </div>
                        <!-- Save changes button-->
                        <button id="save" class="btn btn-primary" type="button">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  const form=document.querySelector("#form2"),
  btn=form.querySelector("#save"),
  error=form.querySelector(".error-text");

  form.onsubmit=(e)=>{
    e.preventDefault();
  }

  btn.onclick=()=>{
  console.log(btn);
const xhr=new XMLHttpRequest();
xhr.open("POST","././php_backend/account.php",true);
xhr.onload= ()=>{
  if(xhr.readyState===4){
    if(xhr.status===200){
  let data=xhr.response;
  if(data=="success"){
    start_load();
    alert_toast("Changes Successful",'success')
    setTimeout(function(){
        location.reload();
    },600)

  }
  else{
    error.style.display = "block";
   error.textContent=data;}
    }
  }
}
let formdata=new FormData(form);

formdata.append("accounts_edit","accounts_edit");
xhr.send(formdata);
}
  </script>
