

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

<link href="././styles/view_submissions.css" rel="stylesheet">
<?php
if(isset($_GET['del_noti'])){
  $_SESSION['tid']=$_GET['task_id'];
}
if(isset($_GET['tid'])){
    $_SESSION['tid']=$_GET['tid'];
}
$delete_noti=mysqli_query($conn,"DELETE from submit_noti where task_name={$_SESSION['tid']}");

$tittle=mysqli_query($conn,"SELECT tittle FROM task where tid={$_SESSION['tid']}");
$row=mysqli_fetch_assoc($tittle);
$t=$row['tittle'];
 ?>

  <style>
  #back{
    display: block;
  }
  </style>

    <div style="color:black; opacity:40%;" class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <div class=" bg-info bg-gradient text-dark"> hover on the member task and press red button to remove a member from task.</div>
    </div>


<div style=" color:black; background: white; box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02);" class="content">
    <div class="container">

        <div class="row">
            <div class="col-12">
              <h2 class="text-center" > <?php echo $t; ?></h2>
                <div class="card-box">
                    <div class="row">

                        <div class="col-lg-6 col-xl-6">
                            <h5 class="header-title m-b-30"> Submission Files</h5>
                        </div>
                    </div>

                    <div style="color:black;" class="row">

                      <?php
                      $src='';$stat='';
                      $qry="SELECT * FROM member_task m INNER JOIN accounts_member a ON m.mid=a.userid WHERE m.tid={$_SESSION['tid']} ";
                      $query=mysqli_query($conn,$qry);
                       while( $result=mysqli_fetch_array($query)){
                         $due="SELECT due_date From task where tid={$_SESSION['tid']}";
                         $q=mysqli_query($conn,$due);$r=mysqli_fetch_assoc($q);
                         $due_date=$r['due_date'];

                         if($result['member_file']==0){

                             $today=date("Y-m-d");
                               if($today>$due_date){
                                 $stat="Over Due";
                               }else{$stat="Pending";}

                           ?>

                           <div class="col-lg-3 col-md-3">
                               <div class="file-man-box"><a href="javascript:void(0)" data-id="<?php echo $result['mid'];?>" class="file-close remove_member" ><i class="fa fa-times-circle"></i></a>
                                   <div class="file-img-box"><img src="././assets/images/nofile.png"; alt="icon"></div>
                                   <div class="file-man-title">
                                     <h5 class="mb-0 text-overflow"> <?php echo $result['username'];?><h5>
                                     <p class="mb-0 text-overflow"><small><?php echo $result['gmail'];?></small></p>
                                       <p class="mb-0 text-overflow"><small>No file Submitted yet</small></p>
                                       <p class="mb-0"><small><?php if($stat=="Over Due"){
                                         echo '<span style="color:red">due was:'.date("M d, Y",strtotime($due_date)).'</span>';
                                       }else{   echo '<span style="color:#FFA900;" >Pending :'.date("M d, Y",strtotime($due_date)).'</span>';}?></small></p>
                                   </div>
                               </div>
                           </div>
                            <?php
                          }else{
                           $file=$result['member_file'];
                           $fileExt=explode('.',$file);
                           $fileActualExt=strtolower(end($fileExt));
                           $name=explode('-',$file);
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

                           $s_date=$result['submission_date'];
                               if($s_date>$due_date){
                                 $stat="Over Due :";
                               }else{$stat="Submission on:";}

                         ?>

                       <div class="col-lg-3 col-md-3">
                           <div class="file-man-box"><a class="remove_member" href="javascript:void(0)" data-id="<?php echo $result['mid'];?>" > <i class="file-close fa fa-times-circle"> </i></a>
                               <div class="file-img-box"><img src=<?php echo $src; ?> alt="icon"><a style="margin-top:65px;"  href='././member_uploads/<?php echo $result['member_file'];?>' target='_blank' class="file-download"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                 <a style="margin-top:100px;" href='./manager_actions/ajax_download.php?file=<?php echo $result['member_file'];?>' class="file-download"><i class="fa fa-download"></i></a></div>
                                 <div style="margin-top:12px; " class="file-man-title">
                                   <h5 class="mb-0 text-overflow"> <?php echo $result['username'];?><h5>
                                   <p class="mb-0 text-overflow"><small><?php echo $result['gmail'];?></small></p>
                                   <p class="mb-0 "><small><?php if($stat=="Submission on:"){
                                     echo '<span style="color:#00B74A;">'.$stat.date("M d, Y",strtotime($s_date)).'</span>';
                                   }else{   echo '<span style="color:red;" >Over Due: '.date("M d, Y",strtotime($s_date)).'</span>';}?></small><p>
                               </div>
                           </div>
                       </div>

                       <?php
                     } }?>
                    </div>


                </div><!--main card ends-->
            </div><!-- main end col -->
        </div><!-- mainend row -->
    </div><!-- container -->
</div><!-- content-->

<script>
	$(document).ready(function(){

	$('.remove_member').click(function(){
	_conf("Are you sure to Remove member from task?","remove_member",[$(this).attr('data-id')])
	})
	})
	function remove_member($id){

		start_load()
		$.ajax({
			url:'././php_backend/delete.php?remove_member=1',
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
