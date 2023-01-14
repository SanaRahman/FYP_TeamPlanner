
<head>
  <style>
  #side{
    font-size:14pt;
    padding:5px;
  }
  #drop{
    font-size:12pt;
      padding:3px;
  }

  </style>
</head>

 <aside class="main-sidebar sidebar-dark-primary elevation-4">
   <a href="./" class="brand-link">
  <h2 class="text-center p-0 m-0"><b>MENU</b></h2>
  </a>

    <div class="sidebar pb-4 mb-4">
      <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dropdown">
            <a href="index.php?page=dashboard" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p id="side" style=" padding-top:18px;">
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_project nav-view_project">
              <i class="nav-icon fas fa-layer-group"></i>
              <p id="side">
                Projects
                <i id="side" class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <?php if($_SESSION['login_user'] == "manager"): ?>
              <li class="nav-item">
                <a href="index.php?page=manager_actions/create_project" class="nav-link nav-new_project tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p id="drop">Add New</p>
                </a>
              </li>
            <?php endif; ?>
              <li class="nav-item">
                <a href="./index.php?page=project_list" class="nav-link nav-project_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p id="drop">List</p>
                </a>
              </li>
            </ul>
          </li>
          <?php if($_SESSION['login_user'] == "manager"): ?>
           <li class="nav-item">
                <a href="index.php?page=manager_actions/Report" class="nav-link nav-reports">
                  <i class="fas fa-th-list nav-icon"></i>
                  <p id="side">Report</p>
                </a>
          </li>
          <?php endif; ?>
          <li class="nav-item">
                <a href="./index.php?page=accounts" class="nav-link nav-task_list">
                  <i class="fas fa-user nav-icon" ></i>
                  <p id="side">Account</p>
                </a>
          </li>

      </ul>
      </nav>
    </div>
  </aside>
  <script>
   	$(document).ready(function(){
       var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
   		var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
       if(s!='')
         page = page+'_'+s;
   		if($('.nav-link.nav-'+page).length > 0){
              $('.nav-link.nav-'+page).addClass('active')
   			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
             $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
   				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
   			}
         if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
           $('.nav-link.nav-'+page).parent().addClass('menu-open')
         }

   		}

   	})
   </script>
