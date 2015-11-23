<?php
	define("DB_SERVER", "DatabaseServer(Usually "localhost" will work fine)");
	define("DB_USER", "DatabaseUsername");
	define("DB_PASS", "DatabasePassword");
	define("DB_NAME", "DatabaseName");

  // 1. Create a database connection
  $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
  // Test if connection succeeded
  if(mysqli_connect_errno()) {
    die("Database connection failed: " . 
         mysqli_connect_error() . 
         " (" . mysqli_connect_errno() . ")"
    );
  }
?>
