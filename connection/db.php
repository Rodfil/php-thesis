<?php
  $dbhost = "localhost";
  $dbname = "fetch_it";
  $dbuser = "root";
  $dbpass = "";
	
  $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($mysqli->connect_errno) {
	  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
  $mysqli->set_charset('utf8');
  $charset = $mysqli->character_set_name();
?>
