<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(true); ?>    
      <!-- Left side column. contains the logo and sidebar -->
      <?php echo admin_navigation(1); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <!-- <h2>Admin Menu</h2> -->
        </section>
        <!-- Main content -->
        <section class="content">
        
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          Development - The way you want it
        </div>
        <!-- Default to the left -->
        <strong>Copyright <?php echo date("Y"); ?> <a href="#">TLCode</a>.</strong> All rights reserved.
      </footer>
      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane active" id="control-sidebar-home-tab">
            <ul class="control-sidebar-menu">
              <li>
                <a href="logout.php">
                  <i class="menu-icon fa fa-lock bg-yellow"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Logout of admin section</h4>
                  </div>
                </a>
              </li>
         
            </ul>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <script src="dist/js/test.js"></script>
    <?php include("../includes/layouts/footer.php"); ?>