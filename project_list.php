<?php

//when share link is followed.
//-------------------shared code is opened by this-------------------------//
if(isset($_GET['open'])){
  $code=$_GET['id'];
  echo "<script type=\"text/javascript\">
  $(window).on('load',function(){
   $('#join').modal('show');
 $('#code').val('$code');
});
     </script>";
} ?>

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

<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
          <?php if($_SESSION['login_user']=="manager"):?>
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=manager_actions/create_project"><i class="fa fa-plus"></i> Add New project</a>
			</div>
		<?php elseif($_SESSION['login_user']=="member"):?>
				<div class="card-tools">
					<button  style="" id='j' type="button" class="btn btn-primary" data-toggle="modal" data-target="#join">
          Join Project
          </button>
				</div>
        <?php endif; ?>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-condensed" id="list">
				<colgroup>
					<col width="5%">
					<col width="35%">
					<col width="15%">
					<col width="15%">
					<col width="20%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Project</th>
						<th>Date Started</th>
						<th>Due Date</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php

					 if($_SESSION['login_user']=="manager"){
						$retrive = "SELECT * FROM projects where managerid = '{$_SESSION['userid']}' ";
					}elseif($_SESSION['login_user']=="member"){
					$retrive = "SELECT * FROM member_list m INNER JOIN projects p on m.projectid=p.projectid where memberid = '{$_SESSION['userid']}' ";
					}
					 $qry = $conn->query($retrive);
           $i=1;
					 while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						$desc = strtr(html_entity_decode($row['description']),$trans);
						$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);

					?>
					<tr>
						<th class="text-center"><?php  echo $i++ ?></th>
						<td>
							<p><b><?php  echo ucwords($row['projectname']) ?></b></p>
							<p class="truncate"><?php  echo strip_tags($desc) ?></p>
						</td>
						<td><b><?php  echo date("M d, Y",strtotime($row['datee'])) ?></b></td>
						<td><b><?php  echo date("M d, Y",strtotime($row['end_date'])) ?></b></td>
						<td class="">
							<?php
							  if($row['status'] =='pending'){
							  	echo "<span class='badge badge-secondary'>{$row['status']}</span>";
							  }elseif($row['status'] =='On-Progress'){
							  	echo "<span class='badge badge-info'>{$row['status']}</span>";
							  }elseif($row['status'] =='Over Due'){
							  	echo "<span class='badge badge-danger'>{$row['status']}</span>";
							  }elseif($row['status'] =='completed'){
							  	echo "<span class='badge badge-success'>{$row['status']}</span>";
							  }elseif($row['status'] =='Ended'){
                     echo "<span class='badge  badge-secondary'>{$row['status']}</span>";
                  }elseif($row['status'] =='Started'){
                       echo "<span class='badge bg-teal'>Started</span>";
                    }
							?>
						</td>
						<td class="text-center">

													<?php  if($_SESSION['login_user']=="manager"): ?>
                            <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                              Action</button>
                            <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_project" href="./index.php?page=view_project&id=<?php  echo $row['projectid'] ?>" >View</a>
													<div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=manager_actions/edit_project&edit=<?php  echo $row['projectid'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_project" href="javascript:void(0)" data-id="<?php  echo $row['id']; ?>">Delete</a>
                          </div>
												  <?php  elseif($_SESSION['login_user'] == "member"): ?>
                            <a class="btn btn-primary btn-sm" href="index.php?page=view_project&id=<?php echo $row['projectid']; ?>" >
                                  <i class="fas fa-folder"> View</i>
                            </a>


													 <?php  endif; ?>

						</td>
					</tr>
				<?php  endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- The Modal -->
	<div class="modal fade" id="join">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Join Project</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<form style="color:black;" form action='' method="POST" id="form">
				<div class="form-group">
				<p>Enter the Code of the Project you want to Join</p>
       <div  id="err" class="error-text"></div>
			 <label for="code">Project Code:</label>
			 <input type="text" class="form-control"  placeholder="Enter Code" name="code" id="code"  required >
	    	<br>
			 	<button style="margin-left:10px;"type="submit"  id="sub" name='join' class="btn btn-primary">Join</button>
			 </div>
			 </div>
				<!-- Modal footer -
				<div class="modal-footer">
        </div>-->
			</form>
			</div>
		</div>
	</div>

</div>
<style>
table tr{
  color:black;
}
	table p{
		margin: unset !important;
	}
	table td{
		vertical-align: middle !important
	}
</style>
<script>
const form=document.querySelector("#form"),
btn=form.querySelector("#sub"),
error=form.querySelector(".error-text");

form.onsubmit=(e)=>{
	e.preventDefault();
}
	$(document).ready(function(){
		$('#list').dataTable()

		$('.delete_project').click(function(){
	_conf("Are you sure to delete this project?","delete_project",[$(this).attr('data-id')])
	})
  });

	btn.onclick=()=>{
		console.log("buttonclicked");
	const xhr=new XMLHttpRequest();
	xhr.open("POST","././php_backend/project_list.php",true);
	xhr.onload= ()=>{
		if(xhr.readyState===4){
			if(xhr.status===200){
		let data=xhr.response;
		if(data=="success"){
			 alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.href = 'index.php?page=project_list'
					},1000)
		}
		else{
		 error.style.display = "block";
		 error.textContent=data;}
			}
		}
	}
	let formdata=new FormData(form);
  formdata.append("join_project","join_project");
  xhr.send(formdata);
}

function delete_project($id){
		start_load()
		$.ajax({
			url:'php_backend/project_list.php?action=delete_project',
			method:'POST',
			data:{id:$id},

			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
				else{
					console.log(resp);
				}
			}
		})
	}
</script>
