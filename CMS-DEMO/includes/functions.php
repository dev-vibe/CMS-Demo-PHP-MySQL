<?php

	function redirect_to($new_location) {
	  flush();
	  header("Location: " . $new_location);
	  exit;
	}

	function mysql_prep($string) {
		global $connection;
		
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}
	
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"error\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}
	
	function find_all_subjects($public=true) {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		if ($public) {
			$query .= "WHERE visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		return $subject_set;
	}
	
	function find_pages_for_subject($subject_id, $public=true) {
		global $connection;
		
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
		
		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE subject_id = {$safe_subject_id} ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);
		return $page_set;
	}
	
	function find_all_admins() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM admin ";
		$query .= "ORDER BY username ASC";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		return $admin_set;
	}
	
	function find_subject_by_id($subject_id, $public=true) {
		global $connection;
		
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
		
		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id = {$safe_subject_id} ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "LIMIT 1";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		if($subject = mysqli_fetch_assoc($subject_set)) {
			return $subject;
		} else {
			return null;
		}
	}

	function find_page_by_id($page_id, $public=true) {
		global $connection;
		
		$safe_page_id = mysqli_real_escape_string($connection, $page_id);
		
		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id = {$safe_page_id} ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "LIMIT 1";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);
		if($page = mysqli_fetch_assoc($page_set)) {
			return $page;
		} else {
			return null;
		}
	}
	
	function find_admin_by_id($admin_id) {
		global $connection;
		
		$safe_admin_id = mysqli_real_escape_string($connection, $admin_id);
		
		$query  = "SELECT * ";
		$query .= "FROM admin ";
		$query .= "WHERE id = {$safe_admin_id} ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}

	function find_admin_by_username($username) {
		global $connection;
		
		$safe_username = mysqli_real_escape_string($connection, $username);
		
		$query  = "SELECT * ";
		$query .= "FROM admin ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}

	function find_default_page_for_subject($subject_id) {
		$page_set = find_pages_for_subject($subject_id);
		if($first_page = mysqli_fetch_assoc($page_set)) {
			return $first_page;
		} else {
			return null;
		}
	}
	
	function find_selected_page($public=false) {
		global $current_subject;
		global $current_page;
		
		if (isset($_GET["subject"])) {
			$current_subject = find_subject_by_id($_GET["subject"], $public);
			if ($current_subject && $public) {
				$current_page = find_default_page_for_subject($current_subject["id"]);
			} else {
				$current_page = null;
			}
		} elseif (isset($_GET["page"])) {
			$current_subject = null;
			$current_page = find_page_by_id($_GET["page"], $public);
		} else {
			$current_subject = null;
			$current_page = null;
		}
	}

	function make_subject_chart() {
		$subject_set = find_all_subjects(false);
		$output = "";
		while($subject = mysqli_fetch_assoc($subject_set)) {
		$page_set = find_pages_for_subject($subject["id"], false);	
		$output .=	"<div class=\"row\">
	      <div class=\"col-xs-12 col-md-8 col-md-offset-2\">
	              <div class=\"box\">
	                <div class=\"box-header\">
	                  <h3 class=\"box-title\">Subject:  " . htmlentities($subject["menu_name"]) . "</h3>
	                  <a class=\"pull-right\" href=\"edit_subject.php?subject=" . urlencode($subject["id"]) . "\"><button class=\"btn btn-block btn-info btn-sm\">Edit Subject</button></a>
	                </div><!-- /.box-header -->
	                <div class=\"box-body table-responsive no-padding\">
	                  <table class=\"table table-hover\">
	                    <tbody><tr>
	                      <th class=\"th1\">Position</th>
	                      <th class=\"th2\">Page Name</th>
	                      <th class=\"th3\">Visible</th>
	                      <th class=\"th4\"></th>
	                    </tr>";
	    while($page = mysqli_fetch_assoc($page_set)) {
	    	$position = htmlentities($page["visible"]) == 1 ? "Yes" : "No";
	        $output .=  "<tr>
	                      <td>" . htmlentities($page["position"]) . "</td>
	                      <td>" . htmlentities($page["menu_name"]) . "</td>
	                      <td>" . $position . "</td>
	                      <td><a class=\"pull-right\" href=\"edit_page.php?page=". urlencode($page['id']) ."\"><button class=\"btn btn-block btn-info btn-sm\">Edit Page</button></a></td>
	                    </tr>";
	    }
	    mysqli_free_result($page_set);                
	    $output .= "</tbody></table>
	                </div><!-- /.box-body -->
	                <div class=\"box-footer\">
                      <a href=\"new_page.php?subject=" . urlencode($subject["id"]) . "\"><button type=\"submit\" name=\"submit\" class=\"btn btn-success btn-sm pull-right\"><i class=\"fa fa-plus\"></i>&nbsp; Add Page</button></a>
                    </div>
	              </div><!-- /.box -->
	            </div>
	          </div>";
	    }
	    mysqli_free_result($subject_set);
	    return $output;
	}

	function admin_navigation($menu_item){
		$output = "<aside class=\"main-sidebar\">
			        <!-- sidebar: style can be found in sidebar.less -->
			        <section class=\"sidebar\">
			          <!-- Sidebar Menu -->
			            <ul class=\"sidebar-menu\">
			              <li class=\"header\">ADMIN MENU</li>
			              <!-- Optionally, you can add icons to the links -->
			              <li "; if($menu_item == 1){ $output .= "class=\"active\""; }; $output .= "><a href=\"manage_content.php\"><i class=\"fa fa-edit\"></i><span>Manage Website Content</span></a></li>
			              <li "; if($menu_item == 2){ $output .= "class=\"active\""; }; $output .= "><a href=\"manage_admins.php\"><i class=\"fa fa-users\"></i> <span>Manage Admin Users</span></a></li>
			              <li><a href=\"index.php\"><i class=\"fa fa-reply\"></i><span>Leave Admin Area</span></a></li>
			              <br />
			          </ul><!-- /.sidebar-menu -->
			            <br />
			          </ul><!-- /.sidebar-menu -->
			          <!-- /.sidebar-menu -->
			        </section>
			        <!-- /.sidebar -->
			      </aside>";
		return $output;	      
	}

	// navigation takes 2 arguments
	// - the current subject array or null
	// - the current page array or null
	function navigation($subject_array, $page_array) {
		$output = "<ul class=\"sidebar-menu\">";
		$subject_set = find_all_subjects(false);
		while($subject = mysqli_fetch_assoc($subject_set)) {
			$output .= "<li";
			if ($subject_array && $subject["id"] == $subject_array["id"]) {
				$output .= " class=\"treeview active\"";
			}else{
				$output .= " class=\"treeview\"";
			}
			$output .= ">";
			$output .= "<a href=\"manage_content.php?subject=";
			$output .= urlencode($subject["id"]);
			$output .= "\">";
			$output .= "<i class=\"fa fa-book\"></i>";
			$output .= "<span>" . htmlentities($subject["menu_name"]) . "</span>";
			$output .= "<i class=\"fa fa-angle-left pull-right\"></i>";
			$output .= "</a>";
			
			$page_set = find_pages_for_subject($subject["id"], false);
			$output .= "<ul class=\"treeview-menu\">";
			while($page = mysqli_fetch_assoc($page_set)) {
				$output .= "<li";
				if ($page_array && $page["id"] == $page_array["id"]) {
					$output .= " class=\"active\"";
				}
				$output .= ">";
				$output .= "<a href=\"manage_content.php?page=";
				$output .= urlencode($page["id"]);
				$output .= "\">";
				$output .= "<i class=\"fa fa-circle-o\"></i>";
				$output .= htmlentities($page["menu_name"]);
				$output .= "</a></li>";
			}
			mysqli_free_result($page_set);
			$output .= "</ul></li>";
		}
		mysqli_free_result($subject_set);
		$output .= "<li><a href=\"new_subject.php\"><i class=\"fa fa-plus\"></i> Add New Subject</a></li>";
		$output .= "</ul>";
		return $output;
	}

	function public_navigation($subject_array, $page_array) {
		$output = "<ul class=\"sidebar-menu\">";
		$subject_set = find_all_subjects();
		while($subject = mysqli_fetch_assoc($subject_set)) {
			$output .= "<li";
			if ($subject_array && ($subject["id"] == $subject_array["id"])) {
				$output .= " class=\"treeview active\"";
			}else{
				$output .= " class=\"treeview\"";
			}
			$output .= ">";
			$output .= "<a href=\"index.php?subject=";
			$output .= urlencode($subject["id"]);
			$output .= "\">";
			$output .= "<i class=\"fa fa-book\"></i>";
			$output .= "<span>" . htmlentities($subject["menu_name"]) . "</span>";
			$output .= "<i class=\"fa fa-angle-left pull-right\"></i>";
			$output .= "</a>";
			
			if ($subject_array["id"] == $subject["id"] || 
					$page_array["subject_id"] == $subject["id"]) {
				$page_set = find_pages_for_subject($subject["id"]);
				$output .= "<ul class=\"treeview-menu\">";
				while($page = mysqli_fetch_assoc($page_set)) {
					$output .= "<li";
					if ($page_array && $page["id"] == $page_array["id"]) {
						$output .= " class=\"active\"";
					}
					$output .= ">";
					$output .= "<a href=\"index.php?page=";
					$output .= urlencode($page["id"]);
					$output .= "\">";
					$output .= "<i class=\"fa fa-circle-o\"></i>";
					$output .= htmlentities($page["menu_name"]);
					$output .= "</a></li>";
				}
				$output .= "</ul>";
				mysqli_free_result($page_set);
			}

			$output .= "</li>"; // end of the subject li
		}
		mysqli_free_result($subject_set);
		if (logged_in()) { $output .= "<li><a href=\"admin.php\"><i class=\"fa fa-dashboard\"></i><span>Go Admin Area</span></a></li></ul>";}else{ $output .= "</ul>"; };
		return $output;
	}

	function password_encrypt($password) {
  	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	  $salt_length = 22; 					// Blowfish salts should be 22-characters or more
	  $salt = generate_salt($salt_length);
	  $format_and_salt = $hash_format . $salt;
	  $hash = crypt($password, $format_and_salt);
		return $hash;
	}
	
	function generate_salt($length) {
	  // Not 100% unique, not 100% random, but good enough for a salt
	  // MD5 returns 32 characters
	  $unique_random_string = md5(uniqid(mt_rand(), true));
	  
		// Valid characters for a salt are [a-zA-Z0-9./]
	  $base64_string = base64_encode($unique_random_string);
	  
		// But not '+' which is valid in base64 encoding
	  $modified_base64_string = str_replace('+', '.', $base64_string);
	  
		// Truncate string to the correct length
	  $salt = substr($modified_base64_string, 0, $length);
	  
		return $salt;
	}
	
	function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
	  $hash = crypt($password, $existing_hash);
	  if ($hash === $existing_hash) {
	    return true;
	  } else {
	    return false;
	  }
	}

	function attempt_login($username, $password) {
		$admin = find_admin_by_username($username);
		if ($admin) {
			// found admin, now check password
			if (password_check($password, $admin["hashed_password"])) {
				// password matches
				return $admin;
			} else {
				// password does not match
				return false;
			}
		} else {
			// admin not found
			return false;
		}
	}

	function logged_in() {
		return isset($_SESSION['admin_id']);
	}
	
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("login.php");
		}
	}

?>