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
        <ol class="breadcrumb">
            <li><a href="admin.php"><i class="fa fa-dashboard"></i> Admin</a></li>
            <?php if ($current_page) { ?>
              <li><a href="manage_content.php">Manage Content</a></li>
              <li class="active"><?php echo htmlentities($current_page["menu_name"]); ?></li>
            <?php } else{?>
            <li class="active">Manage Content</li>
            <?php } ?>
        </ol>
        <?php if (!empty($message) || !empty($_SESSION["message"])) {
          echo "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" .  message() . "</div>";
        }?>   
      <!-- Main content -->
      <section class="content">
        <!-- Content Header (Page header) -->       
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <h2>Manage Content <a class="pull-right" href="create_subject.php"><button class="btn btn-block btn-success btn-sm"><i class="fa fa-plus"></i> New Subject</button></a></h2>
            
          </div>
        </div>
      <?php echo make_subject_chart(); ?>
			<br />
				<!-- + <a href="new_page.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Add a new page to this subject</a> -->
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
    </div><!-- ./wrapper -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <script src="dist/js/test.js"></script>
    <?php include("../includes/layouts/footer.php"); ?>