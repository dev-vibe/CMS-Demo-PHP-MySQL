<?php

	session_start();

	function messages() {
		if (isset($_SESSION["failure"]) && !empty($_SESSION["failure"])) {
			$output = "";
			$output .= "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">
		    	<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
		    	<span aria-hidden=\"true\">&times;</span></button>";
			$output .= htmlentities($_SESSION["failure"]);
			$output .= "</div>";
			
			// clear message after use
			$_SESSION["errors"] = null;
			
			return $output;
		}

		if (isset($_SESSION["success"])) {
			$output = "";
			$output .= "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">
		    	<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
		    	<span aria-hidden=\"true\">&times;</span></button>";
			$output .= htmlentities($_SESSION["success"]);
			$output .= "</div>";
			
			// clear message after use
			$_SESSION["success"] = null;
			
			return $output;
		}
	}
	
?>