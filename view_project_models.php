<?php include("././manager_actions/social_buttons.php") ?>

<style>
.gradient-custom {
/* fallback for old browsers */
background: #f6d365;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1));

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1))
}</style>
<!--Model for submission-->
<div class="modal" id="file">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div style="color:black;" class="modal-body">
      <!--  <form form action="index.php?page=member_actions/project_details&clear=c" method='POST' enctype="multipart/form-data">-->

      <form action="" id="sub" >
      <div style="padding-left: 20px;">
        <h6>Tittle:</h6>
        <p><?php echo "  ".$tit;?></p>
        <h6>File Types Allowed</h6>
        <?php $display= str_replace("-"," ",$type);?>
        <p><b><?php echo $display;?></b></p>
        <hr>
        <div  id="err" class="error-text"></div>
        <h5><input type="file"  value="Select file" name="dfile" required></h5>
        <hr>
       <button style="margin-left:5px;" type="button" class="btn btn-info"  id="s" >Submit</button>
       <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
       </div>
      </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">

      </div>

    </div>
  </div>
</div>

<!--__________________________Model when no members are added____________________________________-->
<div style="color:black;" class="modal" id="add_member">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">WARNING!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div style="color:red; text-align:center;" class="modal-body">
        <h5>Project has no Memebers</h5>
        <h4>No Task can be created</h4>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!---_________________MOdel for code share________________________________-->
<!-- Modal -->
<div class="modal fade" id="share" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Share Your Project Code</h4>
      </div>

      <div class="modal-body">

		<?php
    $pid=$_SESSION['ptid'];

		showSharer("https://localhost/team_planner_refactor/index.php?page=project_list&id=$pid&open=1"," Sharing code for joining My Project \n Click the link join in Team Planner\n");
		?>

    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>
    </div>
    </div>

<!--___________________________show member info______________________________-->
<!-- The Modal -->
 <div class="modal fade" id="member_info">
   <div class="modal-dialog modal-md">
     <div class="modal-content">

       <!-- Modal Header -->
       <div class="modal-header">
         <h4 class="modal-title">Modal Heading</h4>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
       </div>

       <!-- Modal body -->
       <div class="modal-body" id="employee_detail">

       </div>

       <!-- Modal footer -->
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       </div>

     </div>
   </div>
 </div>
