<div class="row">
       <div class="col-md-8">
        <div class="card card-outline card-success">
         <div class="card-header">
           <?php if($_SESSION['login_user']=="manager"):?>
            <b>Project Progress</b>
            <?php elseif($_SESSION['login_user']=="member"):?>
            <b>Recent Tasks</b>
            <?php endif; ?>

         </div>
         <div class="card-body p-0">
           <div class="table-responsive">
             <table class="table m-0 table-hover">
               <colgroup>
                 <col width="5%">
                 <col width="30%">
                 <col width="35%">
                 <col width="15%">
                 <col width="20%">
               </colgroup>
               <thead>
                 <th>#</th>
                 <?php if($_SESSION['login_user']=="manager"):?>
                  <th>Project</th>
                  <?php elseif($_SESSION['login_user']=="member"):?>
                 <th>Task</th>
                 <?php endif; ?>
                 <th>Progress</th>
                 <th>Status</th>
                 <th></th>
               </thead>
               <tbody>
               <?php
               $i = 1;
               $r="mem";//member and manager role;
               $qry = "";
               if($_SESSION['login_user']=="manager"){
                 $r="man";
                 $qry = " SELECT * FROM projects where managerid = '{$_SESSION['userid']}' ORDER BY Progress ASC  LIMIT 5 ";
               }
               elseif($_SESSION['login_user']=="member"){

                 $qry = "SELECT task.tid,task.pid,member_task.submission_date,task.tittle,task.due_date,member_task.status FROM member_task INNER JOIN task  on member_task.tid=task.tid where member_task.mid='{$_SESSION['userid']}' ORDER BY member_task.status ASC LIMIT 5";
               }
               $exe = mysqli_query($conn,$qry);
               while($row=mysqli_fetch_assoc($exe)){


                  $progress=0;
                 if($r=="mem"){
                if($row['status']=='completed'){
                    $progress= 100;}
                    else if($row['status']=='Over Due' && $row['submission_date']!=''){
                      $progress= 100;
                    }
                    else {$progress= 0;}
                   }else{$progress=$row['Progress'];}?>


                    <tr>
                     <td>
                        <?php  echo $i++ ?>
                     </td>
                     <td>
                         <a>
                             <?php if($r=="man"){echo ucwords($row['projectname']);}
                             else{echo ucwords($row['tittle']); }?>
                         </a>
                         <br>
                         <small>
                             <?php   if($r=="man"){echo " End : ".date("d-m-Y",strtotime($row['end_date']));}
                             else{ echo " Due: ".date("Y-m-d",strtotime($row['due_date']));}?>
                         </small>
                     </td>
                     <td class="project_progress">
                         <div class="progress progress-sm">
                             <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"
                             style="width: <?php  echo $progress; ?>%">
                             </div>
                         </div>
                         <small>
                             <?php echo $progress; ?>% Complete
                         </small>
                     </td>
                     <td class="text-center project-state">
                         <?php
                          $stat="completed";
                         if($_SESSION['login_user']=="manager"){
                         $d1=date("Y-m-d");  $d=$row['end_date'];
                         $d2=date("Y-m-d",strtotime($d));
                         $pid=$row['projectid'];
                         $stat;

                         if($row['noft']==0){
                           $stat="Started";
                         }else if($d2<$d1){  $stat="Ended";  }
                        else{  $stat="On-Progress";}
                        $sql2="UPDATE projects SET status='$stat' Where managerid='{$_SESSION['userid']}' And projectid='$pid'";
                        $query2=mysqli_query($conn,$sql2);
                      }


                        else if($_SESSION['login_user']=="member"){
                          $d_date=$row['due_date'];
                           $s_date=$row['submission_date'];
                           $today=date("Y-m-d");
                           $s;
                          if(empty($s_date)){
                            if($today>$d_date){
                              $s="Over Due";
                              $sql2="UPDATE member_task SET status='$s' Where mid='{$_SESSION['userid']}' And tid={$row['tid']}";
                               $query2=mysqli_query($conn,$sql2);}
                          }
                        }


                        if($row['status'] =='pending'){
                         echo "<span class='badge  badge-warning'>Pending</span>";
                       }else if($row['status'] =='Over Due' || $stat=='Over Due'){
                          echo "<span class='badge badge-danger'>Over Due</span>";
                        }else if($row['status'] =='completed'){
                          echo "<span  class='badge bg-green' >Completed</span>";
                        }else if($row['status'] =='On-Progress'){
                        echo "<span class='badge badge-info'>{$row['status']}</span>";
                        }else if($row['status'] =='Ended'){
                        echo "<span class='badge  badge-secondary'>{$row['status']}</span>";
                         }else if($stat=='Started'){
                          echo "<span class='badge bg-teal'>Started</span>";
                        }
                         ?>
                     </td>
                     <td>
                       <?php if(  $_SESSION['login_user']=="manager"): ?>
                       <a class="btn btn-primary btn-sm" href="./index.php?page=view_project&id=<?php echo $row['projectid']; ?>" >
                             <i class="fas fa-folder"> View</i>

                       </a>
                      <?php elseif($_SESSION['login_user']=="member"):?>
                       <a class="btn btn-primary btn-sm" href="./index.php?page=view_project&id=<?php echo $row['pid']; ?>" >
                             <i class="fas fa-folder"> View</i>
                       </a>
                     <?php endif; ?>
                     </td>
                 </tr>
               <?php  } ?>
               </tbody>
             </table>
           </div>
         </div>
       </div>
      </div>

      <div class="col-md-4">
          <div class="row">
          <div class="col-12 col-sm-6 col-md-12">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
              <?php if(  $_SESSION['login_user']=="manager"): ?>
                <h3><?php echo $conn->query($qry)->num_rows; ?></h3>
                <p>Total Projects</p>
                  <?php elseif($_SESSION['login_user']=="member"):?>
                    <h3><?php echo $conn->query("SELECT * FROM member_list WHERE memberid='{$_SESSION['userid']}'")->num_rows; ?></h3>
                    <p>Total Projects</p>
                   <?php endif; ?>
              </div>
              <div class="icon">
                <i class="fa fa-layer-group"></i>
              </div>
            </div>
          </div>
           <div class="col-12 col-sm-6 col-md-12">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <?php if(  $_SESSION['login_user']=="manager"): ?>
                  <h3><?php echo $conn->query("SELECT * FROM projects Where managerid='{$_SESSION['userid']}' AND status='completed'")->num_rows; ?></h3>
                  <p>Completed Projects</p>
                    <?php elseif($_SESSION['login_user']=="member"):?>
                      <h3><?php echo $conn->query("SELECT * FROM member_task Where mid='{$_SESSION['userid']}'")->num_rows; ?></h3>
                      <p>Tasks</p>
                     <?php endif; ?>
              </div>
              <div class="icon">
                <i class="fa fa-tasks"></i>
              </div>
            </div>
          </div>
       </div>
        </div>

      </div>
