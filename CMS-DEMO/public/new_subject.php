<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php find_selected_page(); ?>
<?php
if (isset($_POST['submit'])) {
	// Process the form
	
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position = (int) $_POST["position"];
	$visible = (int) $_POST["visible"];
	
	// validations
	$required_fields = array("menu_name", "position", "visible");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("menu_name" => 30);
	validate_max_lengths($fields_with_max_lengths);
	
	if (empty($errors)) {

		$query  = "INSERT INTO subjects (";
		$query .= "  menu_name, position, visible";
		$query .= ") VALUES (";
		$query .= "  '{$menu_name}', {$position}, {$visible}";
		$query .= ")";
		$result = mysqli_query($connection, $query);

		if ($result) {
			// Success
			$_SESSION["success"] = "Subject created.";
			redirect_to("manage_content.php");
		} else {
			// Failure
			$_SESSION["failure"] = "Subject creation failed.";
		}
	}
}
?>
<?php include("../includes/layouts/header.php"); ?>   
      <!-- Left side column. contains the logo and sidebar -->
      <?php echo admin_navigation(1); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <ol class="breadcrumb">
            <li><a href="admin.php"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="manage_content.php">Manage Content</a></li>
            <li class="active">Create Subject</li>
        </ol>
        <!-- Main content -->
        <section class="content">
    	<?php echo form_errors($errors); ?>
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Create Subject</h3>
                </div><!-- /.box-header -->
                  <div class="box-body">
                		<form action="new_subject.php" method="post" role="form">
                		  <div class="form-group">
                      <label>Menu Name</label>
                		    <input type="text" name="menu_name" value="" class="form-control"/>
                		  </div>
                      <div class="form-group">
                		    <label>Menu Position</label>
                		    <select class="form-control" name="position">
                  				<?php
                  					$subject_set = find_all_subjects(false);
                  					$subject_count = mysqli_num_rows($subject_set);
                  					for($count=1; $count <= ($subject_count + 1); $count++) {
                  						echo "<option value=\"{$count}\">{$count}</option>";
                  					}
                  				?>
                		    </select>
                      </div>
                      <div class="form-group">
                        <label>Visible:</label>
                        <div class="radio">
                          <label>
                          <input id="optionsRadios1" type="radio" name="visible" value="1" checked>
                          Yes
                          </label>
                        </div>  
                        <div class="radio">
                          <label>
                          <input id="optionsRadios2" type="radio" name="visible" value="0">
                          No
                          </label>
                        </div>
                      </div>
                      <div class="box-footer">
                        <a class="btn btn-warning" href="manage_content.php">Cancel</a>
                        <button type="submit" name="submit" class="btn btn-success pull-right">Create Subject</button>
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