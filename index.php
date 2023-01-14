<?php
 session_start();
 include("database_connection.php");
 include ("logout&session_check.php");
 check_log($conn);
 include 'header.php'
?>

<!DOCTYPE html>
<html lang="en">

<style>
#back{
  display: none;
}
</style>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <?php include 'navbar.php' ?>
  <?php include 'sidebar.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div  style="z-index:4;"class="content-wrapper">
  	 <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
	    <div class="toast-body text-white">
	    </div>
	  </div>
    <div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div style="display:flex"> <a id="back" style="vertical-align:middle;"  href="./index.php?page=view_project&id=<?php echo $_SESSION['ptid']; ?>" style="font-size:20px;"><i  style="font-size:30px;" class="fa fa-arrow-left"></i></a>
            <h1 class="m-0"><?php echo "&nbsp".$title ?></h1></div>
          </div><!-- /.col -->

        </div><!-- /.row -->
            <hr class="border-primary">
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section style="z-index:4;" class="content">
      <div style="z-index:4;" class="container-fluid">
         <?php
            $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
            if(!file_exists($page.".php")){
              //  include '404.html';
            }else{
            include $page.'.php';
            }
          ?>
      </div><!--/. container-fluid -->
    </section>

    <div class="modal fade" id="confirm_modal" role='dialog'>
          <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Confirmation</h5>
          </div>
          <div class="modal-body">
            <div id="delete_content"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
          </div>
        </div>
  </div>

<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<footer style="z-index:2;" class="main-footer">
  <div class="float-right d-none d-sm-inline-block">
    <b><?php echo "Team Planner"//$_SESSION['system']['name'] ?></b>
  </div>
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<!-- Bootstrap -->
<?php include 'footer.php' ;
include("././alerts/scripts.php");?>
</body>
</html>
