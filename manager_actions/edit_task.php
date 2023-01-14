<link href="././styles/view_submissions.css" rel="stylesheet">
<?php

 $proid=$_SESSION['ptid'];
 if(isset($_GET['tid'])){
   $_SESSION['ed_task']=$_GET['tid'];
 }

 $members=array();
 $types=array('pdf','jpeg','docx','jpg','mp4','pptx','zip');
 $info=mysqli_query($conn,"SELECT * FROM task where tid={$_SESSION['ed_task']}");
 $result=mysqli_fetch_assoc($info);

   $tittle=$result['tittle'];
    $due_date=$result['due_date'];
    $details=$result['description'];
    $file_types=$result['filetype'];
    $file=$result['myfile'];

$real_type=explode('-',$file_types);
$selected_id=array();
$i=0;
$sql="SELECT mid FROM member_task WHERE tid={$_SESSION['ed_task']}";
$query=mysqli_query($conn,$sql);
while($result=mysqli_fetch_assoc($query)){
  $mid=$result['mid'];
  $selected_id[$i]=$result['mid'];
  $i++;

}

  $fileExt=explode('.',$file);
  $fileActualExt=strtolower(end($fileExt));
  $name=explode('-',$file);
  $n=$name[1];
  if($fileActualExt=="pdf"){
    $src="././assets/images/pdf.png";
  }else if($fileActualExt=="png"){
     $src="././assets/images/png.png";
  }else if($fileActualExt=="pptx"){
     $src="././assets/images/pptx.png";
  }else if($fileActualExt=="jpg"){
     $src="././assets/images/jpg.png";
  }else if($fileActualExt=="jpeg"){
     $src="././assets/images/jpeg.png";
  }else if($fileActualExt=="mp4"){
     $src="././assets/images/mp4.jpg";
  }else if($fileActualExt=="zip"){
     $src="././assets/images/zip.png";
  }else if($fileActualExt=="docx"){
     $src="././assets/images/docx.png";
  }

 ?>
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
#frame {
  width: 300px;
height: 200px;
resize: both;
  }
</style>

<div style="color:black;" class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="edit">
       <div  id="err" class="error-text">hlo</div>
        <input type="hidden" name="id" value="<?php // echo isset($id) ? $id : '' ?>">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Tittle</label>
					<input type="text" class="form-control form-control-sm" name="tittle"  value="<?php echo $tittle;?>">
				</div>
			</div>

        <div class="col-md-6">
				<div class="form-group">
          <label for="" class="control-label">Due Date</label>
          <input type="date" class="form-control form-control-sm" autocomplete="off" name="due_date" value="<?php echo $due_date; ?>">
				</div>
			</div>
		</div>

        <div class="row">
           <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">File Types Allowed for Submissions</label>
              <select class="form-control form-control-sm select2" multiple="multiple" name="allowed[]">
                <?php   foreach ($types as $key):?>
            <option value="<?php echo $key;?>" <?php echo in_array($key,$real_type)? 'selected':''?>  >
              <?php echo $key ?></option>
             <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Assign to</label>
              <select class="form-control form-control-sm select2" multiple="multiple" name="employees[]" disabled>
                <?php

                        $query="SELECT * FROM member_list WHERE projectid='{$_SESSION['ptid']}'";
                        $query_run=mysqli_query($conn,$query);
                       if(mysqli_num_rows($query_run)>0){
                        foreach ($query_run as $row) {?>
                        <option value="<?=$row['memberid'];?>" <?php echo in_array($row['memberid'],$selected_id)? 'selected':''?> >
                        <?php echo $row['membername'];?></option>
                              <?php  }  }?>
              </select>
            </div>
          </div>
        </div>

        <div  class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">New File</label><br>
              <input type="file"  value="" name="dfile" >
            </div>
          </div>
        </div>


		<div class="row">
			<div class="col-md-9">
				<div  class="form-group">
					<label for="" class="control-label">Task Details</label>
					<textarea  name="details" id="" cols="30" rows="5" class="summernote form-control" required>
						<?php echo html_entity_decode($details); ?>
					</textarea>
				</div>
			</div>

      <div class="col-md-3">
				<div  class="form-group">
					<label for="" class="control-label">Old file</label>
          <div  class="file-man-box">
              <div class="file-img-box"><img src=<?php echo $src; ?> alt="icon"><a style="margin-top:65px;"  href='././manager_uploads/<?php echo $file; ?>' target='_blank' class="file-download"><i class="fa fa-eye" aria-hidden="true"></i></a>
                <div style="margin-top:12px; " class="file-man-title">
                  <h5 class="mb-0 text-overflow"> <?php echo $file;?><h5>
              </div>
          </div>
				</div>

			</div>
		</div>

        </form>
    	</div>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="document.location='index.php?page=view_project&id=<?php echo $proid;?>'">Cancel</button>
          	<button class="btn btn-flat  bg-gradient-primary mx-2" form="edit">Edit</button>
    		</div>
    	</div>
	</div>
</div>

<script>


	$('#edit').submit(function(e){
		e.preventDefault()

		$.ajax({
			url:'php_backend/task.php?edit_task=1',
			 data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
        success:function(resp){
  				if(resp == 1){
           start_load()
  					alert_toast('Data successfully saved',"success");
            setTimeout(function(){
             location.href = 'index.php?page=view_project&id=<?php echo $proid;?>';
  					},1000)
  				}

          else{ document.getElementById("err").style.display="block";
        $("#err").text(resp);}
        }

		})
	})
</script>
