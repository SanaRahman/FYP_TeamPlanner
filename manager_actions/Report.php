<head>
<style>#h{display: none;}</style>
<link rel="stylesheet" type="text/css" href="./styles/print.css" media="print"></head>
<div style="color:black;" class="col-md-12">
  <h3 id="h" style="font:bold; text-align:center;">Project Progress Report </h3>
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Project Progress</b>
            <div class="card-tools">

            	<button  onclick="window.print();" class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print"><i class="fa fa-print"></i> Print/Download</button>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive" id="printable">

              <table class="table m-0 table-bordered">
               <!--  <colgroup>
                  <col width="5%">
                  <col width="30%">
                  <col width="35%">
                  <col width="15%">
                  <col width="15%">
                </colgroup> -->
                <thead>
                  <th>#</th>
                  <th>Project</th>
                  <th>Task</th>
                  <th>Completed Task</th>
                  <th>Progress</th>
                  <th>Status</th>
                  <th>Reports</th>
                </thead>
                <tbody>
                <?php
                $i = 1;

                $qry = $conn->query("SELECT * FROM projects where managerid={$_SESSION['userid']} order by id ASC");
                while($row= $qry->fetch_assoc()):
                  $pid=$row['projectid'];
                  $comtask=0;
                  $sql2=mysqli_query($conn,"SELECT * FROM task where pid='$pid'");
                  while($result=mysqli_fetch_assoc($sql2)){
                  if($result['status']=='completed'){
                      $comtask=$comtask+1;
                    }
                 }
                  ?>
                  <tr>
                      <td>
                         <?php echo $i++ ?>
                      </td>
                      <td>
                          <a>
                              <?php echo ucwords($row['projectname']) ?>
                          </a>
                          <br>
                          <small>
                              Due: <?php echo date("Y-m-d",strtotime($row['end_date'])) ?>
                          </small>
                      </td>
                      <td class="text-center">
                      	<?php echo number_format($row['noft']);  ?>
                      </td>
                      <td class="text-center">
                      	<?php echo number_format($comtask) ?>
                      </td>

                      <td class="project_progress">
                          <div class="progress progress-sm">
                              <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row['Progress'] ?>%">
                              </div>
                          </div>
                          <small>
                              <?php echo ceil($row['Progress']); ?>% Complete
                          </small>
                      </td>
                      <td class="project-state">
                          <?php
                               if($row['noft'] ==0){
                               echo "<span class='badge bg-teal'>Started</span>";
                             } elseif($row['status'] =='Ended'){
                              echo "<span class='badge badge-secondary'>{$row['status']}</span>";
                            }elseif($row['status'] =='On-Progress'){
                              echo "<span class='badge badge-info'>{$row['status']}</span>";
                            }elseif($row['status'] =='completed'){
                              echo "<span class='badge badge-success'>{$row['status']}</span>";
                            }
                          ?>
                      </td>
                      <td id='stat' >
                      <a class="btn btn-outline-secondary" href="./index.php?page=manager_actions/detail_report&pid=<?php echo $row['projectid']; ?>" >
                        Detail Report</a>
                        	<a class="btn btn-outline-info" style="float:right;"   href="./index.php?page=manager_actions/pie_chart&pid=<?php echo $row['projectid']; ?>" ><i class="fa fa-chart"></i> Pie Chart </a>
                       </td>
                  </tr>
                <?php  endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        </div>
