<?php 

//echo '<h1>Hello World ' . phpversion() . '</h1>';

define('DATABASE_HOST', 'localhost');
define('DATABASE_USERNAME', 'root');
define('DATABASE_PASSWORD', '');
define('DATABASE_DBNAME', 'chatzichristodoulou');

// Προσπάθεια σύνδεσης με την βάση
 try {
  $conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_DBNAME);
}
catch (Exception $ex) {  //error control
 die("FAIL! Δεν έγινε σύνδεση με την βάση : " . $ex->getMessage());
}
 // echo 'Connected DB!! </p>';

return $conn;
