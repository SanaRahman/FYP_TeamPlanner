<?php

 $proid=$_SESSION['ptid'];  ?>
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

<div style="color:black;" class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-project">
       <div  id="err" class="error-text">hlo</div>
        <input type="hidden" name="id" value="<?php // echo isset($id) ? $id : '' ?>">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Tittle</label>
					<input type="text" class="form-control form-control-sm" name="tittle" value="<?php // echo isset($name) ? $name : '' ?>">
				</div>
			</div>

        <div class="col-md-6">
				<div class="form-group">
          <label for="" class="control-label">Due Date</label>
          <input type="date" class="form-control form-control-sm" autocomplete="off" name="due_date" value="<?php // echo isset($start_date) ? date("Y-m-d",strtotime($start_date)) : '' ?>">
				</div>
			</div>
		</div>

        <div class="row">
           <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">File Types Allowed for Submissions</label>
              <select class="form-control form-control-sm select2" multiple="multiple" name="allowed[]">
                <option value="pdf">PDF</option>
                <option value="docx">DOCX</option>
                <option value="jpg">JPG</option>
                <option value="jpeg">JPEG</option>
                <option value="mp4">MP4</option>
                <option value="pptx">PPTX</option>
                <option value="png">PNG</option>
                <option value="zip">ZIP</option>
              </select>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Assign to</label>
              <select class="form-control form-control-sm select2" multiple="multiple" name="employees[]">
              	<option></option>
              	<?php
              	$employees = $conn->query("SELECT * FROM member_list WHERE projectid='$proid' ");
              	while($row= $employees->fetch_assoc()):
              	?>
              	<option value="<?php  echo $row['memberid'] ?>" ><?php  echo ucwords($row['membername']) ?></option>
              	<?php  endwhile; ?>
              </select>
            </div>
          </div>
        </div>

        <div  class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Attachments</label><br>
              <input type="file"  value="" name="dfile" required>
            </div>
          </div>
        </div>

		<div class="row">
			<div class="col-md-10">
				<div  class="form-group">
					<label for="" class="control-label">Task Details</label>
					<textarea  name="details" id="" cols="30" rows="5" class="summernote form-control" required>
						<?php // echo isset($description) ? $description : '' ?>
					</textarea>
				</div>
			</div>
		</div>

        </form>
    	</div>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="document.location='index.php?page=view_project&id=<?php echo $proid;?>'">Cancel</button>
          	<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-project">Add</button>
    		</div>
    	</div>
	</div>
</div>

<script>


	$('#manage-project').submit(function(e){
		e.preventDefault()

		$.ajax({
			url:'php_backend/task.php?add_task=1',
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
