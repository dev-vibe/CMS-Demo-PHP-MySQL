<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
  $admin_set = find_all_admins();
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(true); ?>    
      <!-- Left side column. contains the logo and sidebar -->
      <?php echo admin_navigation(2); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <ol class="breadcrumb">
            <li><a href="admin.php"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li class="active">Manage Admins</li>
        </ol>
        <!-- Main content -->
        <section class="content">
		<?php echo messages(); ?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <h2>Manage Admins</h2>
        </section> 
          <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
              <div class="box">
                  <div class="box-header">
                    <h3 class="box-title">Admins</h3>
                  </div><!-- /.box-header -->
                  <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                      <tbody>
                        <tr>
                          <th class="th1">ID</th>
                          <th>Admin Name</th>
                        </tr>
                        <?php while($admin = mysqli_fetch_assoc($admin_set)) { ?>
                        <tr>
                          <td><?php echo htmlentities($admin["id"]); ?></td>
                          <td><?php echo htmlentities($admin["username"]); ?>
                             <a class="pull-right forced-space" href="delete_admin.php?id=<?php echo urlencode($admin["id"]); ?>" onclick="return confirm('Are you sure?');"><button class="btn btn-block btn-danger btn-sm">Delete Admin</button></a>                          
                             <a class="pull-right" href="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>"><button class="btn btn-block btn-info btn-sm">Edit</button></a>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <a class="pull-right" href="new_admin.php"><button type="submit" name="submit" class="btn btn-success pull-right">Create Admin</button></a>
                  </div>
              </div><!-- /.box -->
            </div>
          </div>
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
    </div><!-- ./wrapper -->
    <?php mysqli_free_result($admin_set); ?>
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <script src="dist/js/test.js"></script>
    <?php include("../includes/layouts/footer.php"); ?>