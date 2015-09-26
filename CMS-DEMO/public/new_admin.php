<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("username", "password");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("username" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    // Perform Create

    $username = mysql_prep($_POST["username"]);
    $hashed_password = password_encrypt($_POST["password"]);
    
    $query  = "INSERT INTO admin (";
    $query .= "  username, hashed_password";
    $query .= ") VALUES (";
    $query .= "  '{$username}', '{$hashed_password}'";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
      $_SESSION["success"] = "Admin created.";
      redirect_to("manage_admins.php");
    } else {
      // Failure
      $_SESSION["failure"] = "Admin creation failed.";
    }
  }
}
?>
<?php include("../includes/layouts/header.php"); ?> 
      <!-- Left side column. contains the logo and sidebar -->
      <?php echo admin_navigation(2); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <ol class="breadcrumb">
            <li><a href="admin.php"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="manage_admins.php">Manage Admins</a></li>
            <li class="active">Create Admin</li>
        </ol>
        <!-- Main content -->
        <section class="content">
        <!-- alert messages  -->
		<?php echo messages(); ?>
        <?php echo form_errors($errors); ?>
          <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title"><strong>Create Admin</strong></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <form action="new_admin.php" method="post" role="form">
                      <!-- text input -->
                      <div class="form-group">
                          <label>Username</label>
                          <input name="username" class="form-control" placeholder="Enter Username" type="text">
                      </div>
                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" placeholder="Enter Password" type="text" value="">
                      </div>
                    <div class="box-footer">
                    <a class="btn btn-warning" href="manage_admins.php">Cancel</a>
                    <input type="submit" name="submit" class="btn btn-success pull-right" value="Create Admin">
                    </div>
                  </form>
                </div><!-- /.box-body -->
              </div>
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
      <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <script src="dist/js/test.js"></script>
    <?php include("../includes/layouts/footer.php"); ?>

