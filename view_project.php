<head>
  <link href="styles/chat.css" rel="stylesheet">
  <style>
  .r{display: none;}
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
  	.users-list>li img {
  	    border-radius: 50%;
  	    height: 67px;
  	    width: 67px;
  	    object-fit: cover;
  	}
  	.users-list>li {
  		width: 33.33% !important
  	}
  	.truncate {
  		-webkit-line-clamp:1 !important;
  	}
</style>
</head>

<?php


//add delete notifications here.
/*if(isset($_GET['del_noti'])){
 $query=mysqli_query($conn,"DELETE FROM notification_msg where projectid='{$_SESSION['ptid']}'");
}*/

if(isset($_GET['project'])){
  $_SESSION['ptid']=$_GET['project'];
 }
 if(isset($_GET['id'])  ){
   $_SESSION['ptid']=$_GET['id'];
  }
if($_SESSION['login_user']=='member')
{$delete=mysqli_query($conn,"DELETE from task_assign_noti where pid='{$_SESSION['ptid']}'");}

$pid=$_SESSION['ptid'];

 $sql="SELECT * FROM projects p INNER JOIN accounts a on p.managerid=a.userid WHERE projectid='$pid'";
 $query=mysqli_query($conn,$sql);
  if($row=mysqli_fetch_assoc($query)){
  $projectname=$row['projectname'];
  $department=$row['department'];
  $description=$row['description'];
  $managername=$row['managername'];
  $start_date=$row['datee'];
  $status=$row['status'];
  $end_date=$row['end_date'];
  $manid=$row['managerid'];
  $profile=$row['dp'];
  }

  if(isset($_GET['sid'])){
    $_SESSION['sub_task']=$_GET['sid'];
    $sql="SELECT * FROM task WHERE tid={$_SESSION['sub_task']}";
    $query=mysqli_query($conn,$sql);
    if( $result=mysqli_fetch_assoc($query)){
     $tit=$result['tittle'];
     $des=$result['description'];
     $type=$result['filetype'];}

    echo "<script type='text/javascript'>
    $(document).ready(function(){
    $('#file').modal('show');
    });</script>";
  }
  include "./view_project_models.php";

  $result = $conn->query("SELECT * FROM member_list WHERE projectid='$pid'");
  $num_members= $result->num_rows;

 ?>


<div style="color:black;" class="col-lg-12 ">


	<div class="row " >
		<div class="col-md-12">
			<div class="callout callout-info">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-6">
							<dl>
								<dt><b class="border-bottom border-primary">Project Name</b></dt>
								<dd><?php  echo ucwords($projectname) ?></dd>
              </dl>
              <dl>
                <?php  if($_SESSION['login_user']=="manager"):?>
                <dt><b class="border-bottom border-primary">Project Code</b></dt>
								<dd><?php  echo ucwords($pid) ?></dd>
                </dl>
                  <?php  endif; ?>
                  <dl>
								<dt><b class="border-bottom border-primary">Description</b></dt>
								<dd><?php  echo html_entity_decode($description) ?></dd>
							</dl>
						</div>
						<div class="col-md-6">
							<dl>
								<dt><b class="border-bottom border-primary">Start Date</b></dt>
								<dd><?php  echo date("F d, Y",strtotime($start_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">End Date</b></dt>
								<dd><?php  echo date("F d, Y",strtotime($end_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Status</b></dt>
								<dd>
									<?php
									  if($status =='pending'){
									  	echo "<span class='badge badge-warning'>{$status}</span>";
									  }elseif($status =='On-Progress' || $status=='On-Going'){
									  	echo "<span class='badge badge-info'>$status</span>";
									  }elseif($status =='Over Due'){
									  	echo "<span class='badge badge-danger'>{$status}</span>";
									  }elseif($status =='completed'){
									  	echo "<span class='badge badge-success'>{$status}</span>";
									  }
									?>
								</dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Project Manager</b></dt>

								<dd>
									<div class="d-flex align-items-center mt-1">
										<img class="img-circle img-thumbnail p-0 shadow-sm border-info img-sm mr-3" src="assets/profile/<?php  echo $profile; ?>" alt="Avatar">
										<b><button  class="btn btn-link btn-sm show_data"  id="<?php echo $manid; ?>" ><?php  echo $managername; ?></button></b>
									</div>
								</dd>
							</dl>
              <dl> <dt><button  id="c" type="button" class="btn btn-info" onclick="openchat()">Chat
                <i class='fas fa-comment' style='font-size:24px'><span  class="badge badge-danger" id="count" ></span></i></button><dt></dl>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div  class="row"  >
		<div class="col-md-4">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<span><b>Team Member/s:</b></span>
					<div class="card-tools">
            <?php if(isset($_SESSION['login_user'])=="manager") :?>
              <button  style="color:#4FC3F7" class="btn btn-link btn-md" data-toggle="modal" data-target="#share">
              <i style="color:#4FC3F7 " class="fa fa-share-alt"></i> Invite</button>
					  <?php endif; ?>
					</div>
				</div>
				<div class="card-body">
					<ul style="text-align: center;" class="users-list clearfix">
						<?php
						if(!empty($num_members)):
							$members = $conn->query("SELECT * FROM member_list m  INNER JOIN accounts a on m.memberid=a.userid Where projectid='{$_SESSION['ptid']}'");
							while($row=$members->fetch_assoc()):

						?>
								<li style="text-align:center;">
			                        <img style="border-solid:black; margin-right:8px;" src="assets/profile/<?php echo $row['dp'] ?>" alt="User Image">
			                        <button style="margin-left:3px;"  class="btn btn-link show_data"  id="<?php echo $row['memberid']; ?>" ><?php  echo $row['membername']; ?></button>
			                        <!-- <span class="users-list-date">Today</span> -->
		                    	</li>
						<?php
							endwhile;
					endif;
						?>
					</ul>
				</div>
			</div>
		</div>
<!--__________________________________Task List_________________________________________________-->
		<div style="color:black; margin-bottom:12px;" class="col-md-8">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<span><b>Task List:</b></span>
					<?php  if($_SESSION['login_user'] == "manager" && $num_members>0): ?>
					<div class="card-tools">
						<button class="btn btn-primary bg-gradient-primary btn-sm"   onClick="document.location='index.php?page=manager_actions/add_task&pid=<?php echo $pid; ?>'" type="button" >
              <i class="fa fa-plus"></i> New Task</button>
					</div>
        <?php  elseif($_SESSION['login_user'] == "manager" && $num_members==0): ?>
          	<div class="card-tools">
         <button class="btn btn-primary bg-gradient-primary btn-sm" type="button"
          data-toggle="modal" data-target="#add_member">
          <i class="fa fa-plus"></i> New Task</button>
        </div>

				<?php  endif; ?>
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
					<table class="table table-condensed m-0 table-hover">
						<colgroup>
							<col width="5%">
              <?php if($_SESSION['login_user']=="manager"): ?>
							<col width="25%">
							<col width="30%">
              <?php elseif($_SESSION['login_user']=="member"): ?>
                <col width="32%">
  							<col width="20%">
              <?php endif; ?>
							<col width="20%">
							<col width="22%">
						</colgroup>
						<thead>
							<th>#</th>
							<th>Task</th>
              <?php if($_SESSION['login_user']=="manager"): ?>
							<th>Progress</th>
              <?php elseif($_SESSION['login_user']=="member"): ?>
              <th>Attachments</th>
              <?php endif; ?>
							<th>Status</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php
							$i = 1;
              $qry='';
                if($_SESSION['login_user']=="member"){
                  $qry="SELECT * FROM task t INNER JOIN member_task m ON t.tid=m.tid WHERE t.pid='$pid' AND m.mid='{$_SESSION['userid']}' order by t.tid desc";
                }else if($_SESSION['login_user']=="manager"){
                  $qry="SELECT * FROM task WHERE pid='$pid' order by tid desc";
                }

               $res = $conn->query($qry);
               while($row = $res->fetch_assoc()){
								$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
								unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
								$desc = strtr(html_entity_decode($row['description']),$trans);
								$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
							?>
								<tr>
			                        <td style="vertical-align: middle " class="text-center"><?php  echo $i++ ?></td>

			                        <td style="vertical-align: middle " ><b><?php  echo ucwords($row['tittle']) ?></b>
                                <p class="truncate"><?php  echo strip_tags($desc) ?></p>

                              </td>
                                <td style="vertical-align: middle ">
                                <?php if($_SESSION['login_user']=="manager"):?>
                                  <div class="progress progress-sm">
                                    <?php  $p=$row['Progress'];?>
                                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ceil($p); ?>%"></div>
                                    </div>
                                      <small><?php echo ceil($p) ?>% Complete</small>

                                <?php elseif($_SESSION['login_user']=="member"):?>
                                <a style="vertical-align: middle;" class="btn btn-link btn-sm"  href='././manager_uploads/<?php echo $row['myfile']?>' target='_blank'>
                                <i style="margin-left:26px;  font-size:16pt;"class="fa fa-paperclip"></i>
                                </a>
                              <?php endif;?>
                              </td>

			                        <td style="vertical-align: middle ">
			                        	<?php
			                        	if($row['status'] == "pending"){
									  		        echo "<span class='badge badge-warning'>Pending</span>";
                                  }elseif($row['status'] == "Over Due"){
									  	           	echo "<span class='badge badge-danger'>Over Due</span>";
                                  }elseif($row['status'] == "completed"){
									  	            	echo "<span class='badge badge-success'>Done</span>";
                                   }
			                        	?>
                                <br><small>Due:<?php echo $row['due_date'] ?></small>
			                        </td>
			                        <td style="vertical-align: middle " class="text-center">
                                <?php  if($_SESSION['login_user'] == "manager"): ?>
										           <button  type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
					                      Action
					                     </button>
					                      <div  class="dropdown-menu" style="">
					                      <a class="dropdown-item view_task" href="index.php?page=manager_actions/view_submissions&tid=<?php echo $row['tid']?>"  >View Submissions</a>
					                      <div class="dropdown-divider"></div>
					                      <a class="dropdown-item edit_task" href="index.php?page=manager_actions/edit_task&tid=<?php echo $row['tid'] ?>">Edit Task</a>
					                      <div class="dropdown-divider"></div>
					                      <a  style=" z-index:777;" class="dropdown-item delete_task" href="javascript:void(0)" data-id="<?php  echo $row['tid'] ?>">Delete Task</a>

                                <?php  elseif($_SESSION['login_user'] == "member"): ?>
                                <?php if($row['member_file']==0): ?>
                                  <a class="btn btn-primary btn-sm" href="index.php?page=view_project&sid=<?php echo $row['tid']; ?>" >
                                  <i class="fa fa-file" aria-hidden="true"></i>
                                  Submit</a>
                                   <?php else:?>
                                   <a class="btn btn-info btn-sm" href='././member_uploads/<?php echo $row['member_file']?>' target='_blank'>
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    View </a>
                                      <br><small>Due:<?php echo $row['submission_date'] ?></small>
                                    <?php endif;?>
					                        <?php  endif; ?>
                                  </td>
					                    </div>

		                    	</tr>
							<?php }		?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
  </div><!--row of task and members ends-->

<!--____________________________Chat Box_______________________________________-->
  <div id="chat" style="bottom:-4px; right: 10px; width:400px;" class="r  position-fixed" >
      <section  style="z-index:999;" class="chat-area ">
        <header style="z-index:999;">
          <?php
          $sql = mysqli_query($conn, "SELECT * FROM chat WHERE projectid='{$_SESSION['ptid']}'");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);}

          ?>
          <button style="font-size:24px" class="btn btn-link back-icon" onclick="closechat()"><i class="fa fa-times"></i></button>
          <div class="details">
            <span><?php echo $row['name']; ?></span>
          </div>
        </header>
        <div style="z-index:999;" class="chat-box">
           <!--messages shall appear here-->
        </div>
        <form style="z-index:999;" action="#" class="typing-area">
          <input type="text" class="incoming_id" name="incoming_id" value="<?php  echo $_SESSION['userid']; ?>" hidden>
          <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
          <button><i class="fab fa-telegram-plane"></i></button>
        </form>
      </section>
    </div>
</div>


  <script src="././php_backend/view_project_ajax.js"></script>
</body>
