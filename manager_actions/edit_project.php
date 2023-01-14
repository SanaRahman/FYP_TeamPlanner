
<head>
<style>
.error-text{
  color: #721c24;
  padding: 8px 10px;
  text-align: center;
  border-radius: 5px;
  background: #f8d7da;
  border: 1px solid #f5c6cb;
  margin-bottom: 10px;
  display: none;
}
</style>
<?php
if(isset($_GET['edit'])){
  $pid=$_GET['edit'];
  $_SESSION['edid']=$pid;
}

$info=mysqli_query($conn,"SELECT * FROM projects where projectid='$pid'");
$res=mysqli_fetch_assoc($info);
$projectname=$res['projectname'];
$department=$res['department'];
$description=$res['description'];
$datee=$res['datee'];
$end_date=$res['end_date'];
 ?>
</head>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="form">
            <div  id="err" class="error-text"></div>
        <input type="hidden" name="id" value="<?php // echo isset($id) ? $id : '' ?>">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Project Name</label>
					<input type="text" class="form-control form-control-sm" name="pname" value="<?php echo ($projectname)?>" required>
				</div>
			</div>
          	<div class="col-md-6">
              <div class="form-group">
      					<label for="" class="control-label">Department Name</label>
      					<input type="text" class="form-control form-control-sm" name="depname" value="<?php  echo ($department)  ?>" required>
      				</div>
		     	</div>
		</div>

		<div class="row">
			<div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Start Date</label>
              <input type="date" class="form-control form-control-sm" autocomplete="off" name="start_date" value="<?php  echo($datee) ?>" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">End Date</label>
              <input type="date" class="form-control form-control-sm" autocomplete="off" name="end_date" value="<?php  echo ($end_date)  ?>" required>
            </div>
          </div>
		</div>

		<div class="row">
			<div class="col-md-10">
				<div class="form-group">
					<label for="" class="control-label">Description</label>

					<textarea style="height:10px;" name="description" id="" cols="10" rows="3"  class="summernote form-control" required><?php echo html_entity_decode($description);?></textarea>
				</div>
			</div>
		</div>

    <div class="card-footer border-top border-info">
      <div class="d-flex w-100 justify-content-center align-items-center">
        <button class="btn btn-flat  bg-gradient-primary mx-2" id="edit">Edit</button>
        <button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=project_list'">Cancel</button>
      </div>
    </div>
        </form>
    	</div>

	</div>
</div>
</div>

<script>
  const form=document.querySelector("#form"),
  btn=form.querySelector("#edit"),
  error=form.querySelector(".error-text");

  form.onsubmit=(e)=>{
    e.preventDefault();
  }

//on manager Signup
  btn.onclick=()=>{
    start_load()
  const xhr=new XMLHttpRequest();
  xhr.open("POST","././php_backend/create_project.php",true);
  xhr.onload= ()=>{
    if(xhr.readyState===4){
      if(xhr.status===200){
    let data=xhr.response;
    if(data=="success"){
       alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.href = 'index.php?page=project_list'
					},2000)
    }
    else{
      end_load()
      error.style.display = "block";
     error.textContent=data;}
      }
    }
  }
  let formdata=new FormData(form);
  formdata.append("edit_project","edit_project");
  xhr.send(formdata);
  }
</script>
