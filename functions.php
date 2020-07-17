
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//start edit

//START Connect to database
$link = mysqli_connect("server name", "database username", "database password", "database name");
$baseurl = "http://".$_SERVER['SERVER_NAME']."/company";
//stop edit

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

//set charset
if (!mysqli_set_charset($link, "utf8")) {
      printf("Error loading character set utf8: %s\n", mysqli_error($link));
      exit();
}




//we are using api for ip 
//$ip = file_get_contents('https://api.ipify.org');

//or php version 

$ip = $_SERVER['REMOTE_ADDR'];


$date = date("Y/m/d H:i");

?>
