<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php find_selected_page(); ?>
<?php
  // Unlike new_page.php, we don't need a subject_id to be sent
  // We already have it stored in pages.subject_id.
  if (!$current_page) {
    // page ID was missing or invalid or 
    // page couldn't be found in database
    redirect_to("manage_content.php");
  }
?>
<?php
if (isset($_POST['submit'])) {
  // Process the form  
  $id = $current_page["id"];
  $menu_name = mysql_prep($_POST["menu_name"]);
  $position = (int) $_POST["position"];
  $visible = (int) $_POST["visible"];
  $content = mysql_prep($_POST["content"]);
  // validations
  $required_fields = array("menu_name", "position", "visible", "content");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("menu_name" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {  
    // Perform Update
    $query  = "UPDATE pages SET ";
    $query .= "menu_name = '{$menu_name}', ";
    $query .= "position = {$position}, ";
    $query .= "visible = {$visible}, ";
    $query .= "content = '{$content}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["success"] = "Page updated.";
      redirect_to("manage_content.php");
    } else {
      // Failure
      $_SESSION["failure"] = "Page update failed.";
    }  
  }
}
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?> 
      <?php echo admin_navigation(1); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <ol class="breadcrumb">
            <li><a href="admin.php"><i class="fa fa-dashboard"></i> Admin</a></li>
            <?php if ($current_page) { ?>
              <li><a href="manage_content.php">Manage Content</a></li>
              <li class="active">Edit Page</li>
            <?php } else{?>
            <li class="active">Manage Content</li>
            <?php } ?>
        </ol>
        <!-- Main content -->
        <section class="content">
          <?php echo form_errors($errors); ?>
		  <?php echo messages(); ?>
          <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title"><strong>Edit Page: <?php echo htmlentities($current_page["menu_name"]); ?></strong></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <form action="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>" method="post" role="form">
                    <div class="form-group">
                      <label>Menu Name</label>
                      <input type="text" name="menu_name" class="form-control" placeholder="Enter Username" value="<?php echo htmlentities($current_page["menu_name"]); ?>">
                    </div>
                    <!-- select box -->
                    <div class="form-group">
                      <label>Menu Position</label>
                      <select class="form-control" name="position">
                        <?php
                        $page_set = find_pages_for_subject($current_page["subject_id"], false);
                        $page_count = mysqli_num_rows($page_set);
                        for($count=1; $count <= $page_count; $count++) {
                          echo "<option value=\"{$count}\"";
                          if ($current_page["position"] == $count) {
                            echo " selected";
                          }
                          echo ">{$count}</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Visible:</label>
                      <div class="radio">
                        <label>
                        <input id="optionsRadios1" type="radio" name="visible" value="1" <?php if ($current_page["visible"] == 1) { echo "checked"; } ?>>
                        Yes
                        </label>
                      </div>  
                      <div class="radio">
                        <label>
                        <input id="optionsRadios2" type="radio" name="visible" value="0" <?php if ($current_page["visible"] == 0) { echo "checked"; } ?>>
                        No
                        </label>
                      </div>
                    </div>
                    <label>Content</label>
                    <textarea name="content" rows="40" cols="80"><?php echo htmlentities($current_page["content"]); ?></textarea>
                    <div class="box-footer">
                      <a class="btn btn-warning" href="manage_content.php">Cancel</a>
                      <a class="btn btn-danger" href="delete_page.php?page=<?php echo urlencode($current_page["id"]); ?>" onclick="return confirm('Are you sure?');">Delete page</a>
                      <input type="submit" name="submit" class="btn btn-success pull-right" value="Edit Page">
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
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    <script>
      $(function () {
        CKEDITOR.replace('content',{
        height: 500
        } );
      });
    </script>
    <script src="dist/js/test.js"></script>
    <?php include("../includes/layouts/footer.php"); ?>