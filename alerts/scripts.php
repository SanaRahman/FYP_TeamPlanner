

<!--_____________________________-script for sweet alert_________________________________-->
<script src="assests/sweet_alerts.js"></script>

<?php
if(isset($_SESSION['signup_sucess']) && ($_SESSION['signup_sucess']=='success')){?>
  <script>
swal({
    title: "SIGNUP SUCESSFUL",
    text: "Signup was sucessfull",
    type: "success"
});//.then(function() {
  //  window.location = "index.php?page=project_list";
//});
</script>
<?php
unset($_SESSION['signup_success']);
}

if(isset($_SESSION['success']) && ($_SESSION['success']=='project_created')){?>
  <script>
  var code="<?php echo $_SESSION['code']?>"
swal({
    title: "PROJECT CREATED",
    text: "The project code is: "+ code,
    type: "success"
}).then(function() {
    window.location = "index.php?page=project_list";
});
</script>
<?php
unset($_SESSION['success']);
unset($_SESSION['code']);

}

   if(isset(   $_SESSION['joined']) && (   $_SESSION['joined']=='joined')){?>
     <script>
   swal({
       title: "PROJECT JOINED",
       text: "Project joined sucessfully",
       type: "success"
   });//.then(function() {
     //  window.location = "index.php?page=project_list";
   //});
   </script>
   <?php
   unset($_SESSION['joined']);
   }
if(isset($_SESSION['p_not_found']) && ($_SESSION['p_not_found']=="p_not_found")){?>
  <script>
swal({
    title: "ERROR",
    text: "No Project with code found",
    type: "danger"
});//.then(function() {
  //  window.location = "index.php?page=project_list";
//});
</script>
<?php
unset($_SESSION['p_not_found']);
}

if(isset($_SESSION['Palready']) && ($_SESSION['Palready']=='already')){?>
  <script>

swal({
    title: "WARNING",
    text: "You have alreday joined this project",
    type: "danger"
});//.then(function() {
  //  window.location = "index.php?page=project_list";
//});
</script>
<?php
unset($_SESSION['Palready']);
}
if(isset($_SESSION['taken']) && ($_SESSION['taken']=='taken')){?>
  <script>

swal({
    title: "ERROR",
    text: "The Project name already exists",
    type: "danger"
});//.then(function() {
  //  window.location = "index.php?page=project_list";
//});
</script>
<?php
unset($_SESSION['taken']);
}
if(isset($_SESSION['update']) && $_SESSION['update']=='project_updated'){?>
  <script>
swal({
    title: "PROJECT UPDATED",
    text: "Data is Updated Sucessfully",
    type: "success"
}).then(function() {
    window.location = "index.php?page=project_list";
});
</script>
<?php
unset($_SESSION['update']);
}

if(isset($_SESSION['task_create']) && $_SESSION['task_create']=='task_created'){
  ?>
  <script>
swal({
    title: "TASK CREATED",
    text: "The task is created sucessfully",
    type: "success"
}).then(function() {
    window.location = "index.php?page=view_project";
});
</script>
<?php
unset($_SESSION['task_create']);

}
if(isset($_SESSION['task_delete']) && $_SESSION['task_delete']=='task_delete'){
  ?>
  <script>
swal({
    title: "TASK DELETED",
    text: "The task is deleted sucessfully",
    type: "success"
}).then(function() {
    window.location = "index.php?page=view_project";
});
</script>
<?php
unset($_SESSION['task_delete']);

}

if(isset($_SESSION['type_error']) && $_SESSION['type_error']=='error'){
  ?>
  <script>
swal({
    title: "SUBMISSION ERROR",
    text: "File type not allowed",
    type: "warning"
}).then(function() {
    window.location = "index.php?page=member_actions/project_details";
});
</script>
<?php
unset($_SESSION['type_error']);
unset ($_SESSION['ttask']);

}

if(isset( $_SESSION['upload_success']) &&   $_SESSION['upload_success']=='success'){
  ?>
  <script>
swal({
    title: "UPLOAD SUCESSFUL",
    text: "File has been uploaded",
    type: "success"
}).then(function() {
    window.location = "index.php?page=member_actions/project_details";
});
</script>
<?php
unset( $_SESSION['upload_success']);
unset ($_SESSION['ttask']);
}

if(isset($_SESSION['task_update']) &&  $_SESSION['task_update']=='updated'){
?>
  <script>
swal({
        title: "UPDATE SUCCESS",
        text: "task has been uploaded sucessfully",
        type: "success"
    }).then(function() {
        window.location = "index.php?page=view_project";
    });
    </script>
    <?php
    unset($_SESSION['task_update']);
    }

  if(isset($_SESSION['dtask_member']) &&  $_SESSION['dtask_member']=="deleted"){
  ?>
    <script>
  swal({
          title: "SUCESSFULLY DELETED",
          text: "member is sucessfully removed",
          type: "success"
      }).then(function() {
          window.location = "index.php?page=task_details";
      });
      </script>
      <?php
      unset($_SESSION['dtask_member']);
      }
if(isset($_SESSION["project_deleted"]) && $_SESSION["project_deleted"]=="project_deleted"){?>
  <script>
  swal({
        title: " SUCESSFULLY DELETED",
        text: "project is sucessfully removed",
        type: "success"
    }).then(function() {
        window.location = "index.php?page=project_list";
    });
    </script>
    <?php
    unset($_SESSION['project_deleted']);
    }
