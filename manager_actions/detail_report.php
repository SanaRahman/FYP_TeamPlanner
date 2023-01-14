<head>
<style>#h{display: none;}</style>
<link rel="stylesheet" type="text/css" href="./styles/print.css" media="print">
</head>
<?php
  $manid=$_SESSION['userid'];
  if(isset($_GET['pid'])){
    $_SESSION['rpid']=$_GET['pid'];
  }
    $rpid=$_SESSION['rpid'];


 $sql="SELECT * from projects where projectid='$rpid'";
    $q=mysqli_query($conn,$sql);
    if($res=mysqli_fetch_assoc($q)){
      $manger=$res['managername'];
      $projectname=$res['projectname'];
      $status=$res['status'];
      $end_date=$res['end_date'];
    }

   ?>

<div style="color:black;" class="col-md-12">
  <h3 id="h" style="font:bold; text-align:center;">Detail Project Progress Report </h3>
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Project Progress</b>
            <div class="card-tools">
              
            	<button onclick="window.print();" class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print"><i class="fa fa-print"></i> Print/Download</button>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive" id="printable">

              <table id="example2" class="table m-0" style="  border-spacing:0;" cellspacing="0" cellpadding='0'>


  <thead style="font-size:13pt; background-color:#00B8D4;">
    <tr style='border-spacing:0;' >
  <th style="vertical-align:middle;">
  <p style="margin: 0em;"><b><?php echo $projectname; ?></b></p>
  <small>Manager:<b><?php echo $manger; ?></b></small>
  </th>
  <th colspan='2'>
<p style="text-align:right; margin: 0em;">
<?php
if($status =='Ongoing'){
echo "<span class='align-items-right badge badge-success'>{$status}</span>";}
elseif($status =='Ended'){
echo "<span class='badge badge-danger'>{$status}</span>";}?>
</p>
<small><p style="text-align:right;">End Date:<b><?php echo $end_date; ?></p></b></small>
</th>
</tr>
<colgroup>
<col width="38%">
<col width="38%">
<col width="24%">
</colgroup>
</thead >

  <?php
  $sql2="SELECT * FRom task where pid='$rpid'";
  $q=mysqli_query($conn,$sql2);
  while($res=mysqli_fetch_assoc($q)){
    $tid= $res['tid'];?>
  <thead style="font-size:11pt;background-color:#BBDEFB;">
  <th style="vertical-align: middle"><P style="margin: 0em;">
    <b>Task Name: </b><?php echo $res['tittle'];?></p></th>
  <th colspan='2' style="vertical-align: middle">
      <p style=" margin: 0em;"><b>Members Details and Progress</b></p>
     </th>
</thead>

<tbody>

  <?php
  $sql="SELECT * FROM member_task INNER JOIN accounts_member
  ON accounts_member.userid=member_task.mid where member_task.tid=$tid";
  $query=mysqli_query($conn,$sql);
  $num=mysqli_num_rows($query);
  $i=0;
  while($row=mysqli_fetch_array($query)){ ?>
<tr>
<td>
  <p style="margin: 0em;"><b>Member Name</b><br><?php echo $row['username'];?></p><small><?php echo $row['gmail'];?></small>
</td>
<td>
  <b>Submission</b><br>
  <?php
  if($row['status'] =='completed'){
  echo "<span class='align-items-right badge badge-success'>{$row['status']}</span>";}
  elseif($row['status'] =='pending'){
    echo "<span class='badge badge-danger'>{$row['status']}</span>";
  }
  if($row['submission_date']!=null)?>
  <small><p><?php if($row['submission_date']!=null){
  echo"Submission on: ". PHP_EOL .$row['submission_date'];}?></p></small>
</td>
<?php if($i==0): ?>
<td rowspan="<?php echo $res['nofmem'];?>" style="vertical-align: middle; align-text:center;" >
    <b>Progress</b>
  <?php  if($res['status']=='pending'):?>
  <h5 style="vertical-align:middle;"><span class="badge badge-warning" ><?php echo $res['status']; ?></span></h5>
  <?php  else:?>
  <h5  style="vertical-align:middle;"><span class="badge  badge-success" ><?php echo $res['status']; ?></span></h5>
  <?php endif; ?>
  <small><p style="vertical-align: middle"><b>Due Date:</b><?php echo $res['due_date'];?></b></p></small>

</td>
<?php $i++; endif; ?>
<?php
}
?>

</tr>
   <?php //}
   ?>
</tbody>

<?php } ?>

</table>
            </div>
          </div>
          </div>
          </div>
