<?php

include(".././database_connection.php");
session_start();

if(isset($_POST['employee_id'])){
  $output='';
  $id=$_POST['employee_id'];
 $info=mysqli_query($conn,"SELECT * from accounts where userid=$id");
 $row=mysqli_fetch_assoc($info);
 if($_SESSION['login_user']=="manager" && $id>=5000 ){
   $output.='
          <div  class="col col-lg-12 ">
            <div class="card mb-3" style="border-radius: .5rem;">
              <div class="row g-0">
                <div class="col-md-4 gradient-custom text-center text-white"
                  style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                  <img style="border-radius:50%; width:100px; height:100px;" src="assets/profile/'.$row['dp'].'"
                    alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                  <h5>'.$row['first_name'].'&nbsp'.$row['last_name'].'</h5>
                  <button class="btn btn-link delete_member" data-id='.$id.'>  <i class="fa fa-trash"  style="font-size:20px;color:red"></i><br>
                     Remove from Project</button>
                </div>
                <div class="col-md-8">
                  <div class="card-body p-4">
                    <h6>Information</h6>
                    <hr class="mt-0 mb-4">
                    <div class="row pt-1">
                      <div class="col-6 mb-3">
                        <h6>Email</h6>
                        <p class="text-muted">'.$row['email'].'</p>
                      </div>
                      <div class="col-6 mb-3">
                        <h6>Phone</h6>
                        <p class="text-muted">'.$row['no'].'</p>
                      </div>
                    </div>
                    <h6>Personal Info</h6>
                    <hr class="mt-0 mb-4">
                    <div class="row pt-1">
                      <div class="col-6 mb-3">
                        <h6>birthday</h6>
                        <p class="text-muted">'.$row['birthday'].'</p>
                      </div>
                      <div class="col-6 mb-3">
                        <h6>Location</h6>
                        <p class="text-muted">'.$row['location'].'</p>
                      </div>
                    </div>

                    <h6>Organization</h6>
                    <hr class="mt-0 mb-4">
                    <div class="row pt-1">
                      <div class="col-12 mb-3">
                        <h6>Org name</h6>
                        <p class="text-muted">'.$row['org_name'].'</p>
                      </div>
                      </div>


                  </div>
                </div>
              </div>
            </div>
          </div>';
}else{
  $output.='
         <div  class="col col-lg-12 ">
           <div class="card mb-3" style="border-radius: .5rem;">
             <div class="row g-0">
               <div class="col-md-4 gradient-custom text-center text-white"
                 style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                 <img style="border-radius:50%; width:100px; height:100px;" src="assets/profile/'.$row['dp'].'"
                   alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                 <h5>'.$row['first_name'].'&nbsp'.$row['last_name'].'</h5>

               </div>
               <div class="col-md-8">
                 <div class="card-body p-4">
                   <h6>Information</h6>
                   <hr class="mt-0 mb-4">
                   <div class="row pt-1">
                     <div class="col-6 mb-3">
                       <h6>Email</h6>
                       <p class="text-muted">'.$row['email'].'</p>
                     </div>
                     <div class="col-6 mb-3">
                       <h6>Phone</h6>
                       <p class="text-muted">'.$row['no'].'</p>
                     </div>
                   </div>
                   <h6>Personal Info</h6>
                   <hr class="mt-0 mb-4">
                   <div class="row pt-1">
                     <div class="col-6 mb-3">
                       <h6>birthday</h6>
                       <p class="text-muted">'.$row['birthday'].'</p>
                     </div>
                     <div class="col-6 mb-3">
                       <h6>Location</h6>
                       <p class="text-muted">'.$row['location'].'</p>
                     </div>
                   </div>

                   <h6>Organization</h6>
                   <hr class="mt-0 mb-4">
                   <div class="row pt-1">
                     <div class="col-12 mb-3">
                       <h6>Org name</h6>
                       <p class="text-muted">'.$row['org_name'].'</p>
                     </div>
                     </div>


                 </div>
               </div>
             </div>
           </div>
         </div>';}
         echo $output;
}

?>

<script>
$(document).ready(function(){

	$('.delete_member').click(function(){
	_conf("Are you sure to Remove this member from project?","delete_member",[$(this).attr('data-id')])
	})
	})
	function delete_member($id){
		console.log($(this).attr('data-id'));
		start_load()
		$.ajax({
			url:'././php_backend/create_project.php?delete_member=1',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}else{console.log(resp);}
			}
		})
	}


</script>
