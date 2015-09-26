<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php find_selected_page(); ?>
<?php
	if (!$current_subject) {
		// subject ID was missing or invalid or 
		// subject couldn't be found in database
		redirect_to("manage_content.php");
	}
?>
<?php
if (isset($_POST['submit'])) {
	// Process the form
	
	// validations
	$required_fields = array("menu_name", "position", "visible");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("menu_name" => 30);
	validate_max_lengths($fields_with_max_lengths);
	
	if (empty($errors)) {	
		// Perform Update

		$id = $current_subject["id"];
		$menu_name = mysql_prep($_POST["menu_name"]);
		$position = (int) $_POST["position"];
		$visible = (int) $_POST["visible"];
	
		$query  = "UPDATE subjects SET ";
		$query .= "menu_name = '{$menu_name}', ";
		$query .= "position = {$position}, ";
		$query .= "visible = {$visible} ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);

		if ($result && mysqli_affected_rows($connection) >= 0) {
			// Success
			$_SESSION["success"] = "Subject updated.";
			redirect_to("manage_content.php");
		} else {
			// Failure
			$_SESSION["failure"] = "Subject update failed.";
		}
	}
}// end: if (isset($_POST['submit']))
?>
<?php include("../includes/layouts/header.php"); ?> 
      <!-- Left side column. contains the logo and sidebar -->
      <?php echo admin_navigation(1); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <ol class="breadcrumb">
            <li><a href="admin.php"><i class="fa fa-dashboard"></i> Admin</a></li>
            <?php if ($current_subject) { ?>
              <li><a href="manage_content.php">Manage Content</a></li>
              <li class="active">Edit Subject</li>
            <?php } else{?>
            <li class="active">Manage Content</li>
            <?php } ?>
        </ol>
        <!-- Main content -->
        <section class="content">
		<!-- alert messages	 -->
		<?php echo form_errors($errors); ?>
		<?php echo messages(); ?>
		<div class="row">
		    <div class="col-xs-12 col-md-8 col-md-offset-2">
			    <div class="box box-info">
	                <div class="box-header with-border">
	                	<h2 class="box-title"><strong>Edit Subject</strong></h2>
	                </div><!-- /.box-header -->
	                <div class="box-body">
	                	<form action="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post" role="form">
	                    	<!-- text input -->
	                    	<div class="form-group">
	                      		<label>Menu name</label>
	                      		<input name="menu_name" class="form-control" placeholder="Enter ..." type="text" value="<?php echo htmlentities($current_subject["menu_name"]); ?>">
	                    	</div>
	                    	<!-- radio -->
	                    	<div class="form-group">
	                    		<label>Visible:</label>
	                      		<div class="radio">
	                        		<label>
	                          		<input id="optionsRadios1" type="radio" name="visible" value="1" <?php if ($current_subject["visible"] == 1) { echo "checked"; } ?>>
	                          		Yes
	                        		</label>
		                      	</div>	
			                    <div class="radio">
			                        <label>
			                        <input id="optionsRadios2" type="radio" name="visible" value="0" <?php if ($current_subject["visible"] == 0) { echo "checked"; } ?>>
			                        No
			                        </label>
			                    </div>
	                    	</div>
	                    	<!-- select -->
	                    	<div class="form-group">
	                      		<label>Menu Position</label>
	                      		<select class="form-control" name="position">
		                        <?php
								$subject_set = find_all_subjects(false);
								$subject_count = mysqli_num_rows($subject_set);
								for($count=1; $count <= $subject_count; $count++) {
									echo "<option value=\"{$count}\"";
									if ($current_subject["position"] == $count) {
										echo " selected";
									}
									echo ">{$count}</option>";
								}
								?>
	                      		</select>
	                    	</div>
	                    	<div class="box-footer">
                    		<a class="btn btn-warning" href="manage_content.php">Cancel</a>
                    		<a class="btn btn-danger" href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" onclick="return confirm('Are you sure?');">Delete subject</a>
                    		<button type="submit" name="submit" class="btn btn-info pull-right" >Edit Subject</button>
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
        <strong>Copyright <?php echo date("Y"); ?> <a href="#">TLCode</a>.</strong> 
      </footer>
    </div><!-- ./wrapper -->
      <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <script src="dist/js/test.js"></script>
    <?php include("../includes/layouts/footer.php"); ?>