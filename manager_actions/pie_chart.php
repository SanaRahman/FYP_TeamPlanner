
<?php

if(isset($_GET['pid'])){
  $_SESSION['rpid']=$_GET['pid'];
}

  $comtask=0;$tmem=0;
$sql2=mysqli_query($conn,"SELECT * FROM task where pid='{$_SESSION['rpid']}'");
  while($result=mysqli_fetch_assoc($sql2)){
  if($result['status']=='completed'){
      $comtask=$comtask+1;
    }
 }

 $mem=mysqli_query($conn,"SELECT * FROM member_list where projectid='{$_SESSION['rpid']}'");
   while($result=mysqli_fetch_assoc($mem)){
       $tmem=$tmem+1;
  }
 ?>
<head>
<style>#h{display: none;}</style>
<link rel="stylesheet" type="text/css" href="./styles/print.css" media="print">

<!--pie chart-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],

          <?php

          $info=mysqli_query($conn,"SELECT * FROM projects where projectid='{$_SESSION['rpid']}'");
          $res=mysqli_fetch_assoc($info);
          $p=$res['Progress'];

        echo "['Total Task',".$res['noft']."],
              ['Completed Task',".$comtask."],
              ['Total Members', ".$tmem."]";
        ?>
        ]);

        var options = {
          title: 'Project Progress',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

</head>
<div style="color:black;" class="col-md-12">
  <h3 id="h" style="font:bold; text-align:center;">Project Pie-Chart Report </h3>
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Project Progress</b>
            <div class="card-tools">
            	<button  onclick="window.print();" class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print"><i class="fa fa-print"></i> Print/Download</button>
            </div>
          </div>
          <div class="card-body p-0">
              <div style="text-align:center; font-size:20px;">Project Total Progress :<strong><?php echo $p; ?>% </strong></div>
            <div  id="piechart_3d" style="width:900px; height:400px;"></div>

          </div>
       </div>
     </div>
