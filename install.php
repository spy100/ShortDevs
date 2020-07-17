<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet'>
    <title>ShortDevs</title>
    <style>

html,body{
  background:white;
  margin:0;
  padding:0;
}

* {
  box-sizing: border-box;
}

@font-face {
  font-family: "Roboto Condensed";
  src: url("fonts/roboto-condensedregular.eot"); 
  src: url("fonts/roboto-condensedregular.eot?#iefix") format("embedded-opentype"), 
    url("fonts/roboto-condensedregular.otf") format("opentype"), 
    url("fonts/roboto-condensedregular.svg") format("svg"), 
    url("fonts/roboto-condensedregular.ttf") format("truetype"), 
    url("fonts/roboto-condensedregular.woff") format("woff"), 
    url("fonts/roboto-condensedregular.woff2") format("woff2"); 
  font-weight: normal;
  font-style: normal;
}


label{
  font-family: 'Roboto Condensed', sans-serif;
  font-size:14px;
}

pre.error{
  color:red;
}


input:focus, input.form-control:focus {
outline:none !important;
outline-width: 0 !important;
box-shadow: none;
-moz-box-shadow: none;
-webkit-box-shadow: none;
}

.actinstall{
  background:#f4f4f4;
  border:1px solid #ccc;
  padding:10px;
  margin-top:10px;
  margin-left:auto;
  margin-right:auto;
  width:36%;
}

.actinstall2{
  background:#f4f4f4;
  border:1px solid #ccc;
  padding:10px;
  margin-top:30px;
  margin-left:auto;
  margin-right:auto;
  width:36%;
}

.actinstall input[type="text"]{
  width:100%;
  text-indent: 10px;
  padding:10px 0px;
  margin-top:-1px;

}

.actinstall input[type="email"]{
  width:100%;
  text-indent: 10px;
  padding:10px 0px;
}

.actinstall input[type="password"]{
  width:100%;
  text-indent: 10px;
  padding:10px 0px;

}
@media screen and (max-width: 800px) {
  .actinstall{
    width:96%;
  }

  .actinstall2{
    width:96%;
  }
}

.actnote{
  text-align:center;
  padding-top:10px;
}

h2{
  font-family: 'Roboto Condensed', sans-serif;
  font-weight: normal;
  padding:0;
  margin:0;
}


.logonav{
 color:#FFF;
 overflow:hidden;
 font-size:30px;
 background:black;
 padding:10px 10px 10px 10px;
}
.logo{
  font-family: 'Roboto Condensed', sans-serif;
  font-size:30px;
  float:left;
  width:100%;
  text-align:center;
}

.gold{
  color: gold;
}

.smallv{
  font-size:13px;
}

   </style>
  </head>
  <body>


<div class="logonav" ><div class="logo" >[ Short<span class="gold">Devs</span> <span class="smallv" >v.1.0.0</span> ]</div></div>

<br>
<div class="actinstall hideinstall" >
<h2>Install ShortDevs</h2><br>
<form action="install.php" method="POST">
<label>Admin Username:</label><br>
<input type="text" name="username" value="" />
<br><br>
<label>Admin Password (Don't be a noob ,make sure your password is strong):</label><br>
<input type="password" name="password" value="" />
<br><br>
<label>Admin E-Mail:</label><br>
<input type="email" name="email" value="" />
<br><br>
<label>Url:</label><br>
<input type="text" name="url" value="" />
<br><br>
<label>Database Server Name (ex: localhost):</label><br>
<input type="text" name="sn" value="" />
<br><br>
<label>Database Username:</label><br>
<input type="text" name="dbuser" value="" />
<br><br>
<label>Database Password:</label><br>
<input type="password" name="dbpass" value="" />
<br><br>
<label>Database Name:</label><br>
<input type="text" name="db" value="" />
<br><br>
<input type="submit" name="submit" value="Install" />
</form>
</div>



<?php


if (isset($_POST['submit'])) {

$adminusername = $_POST['username'];
$adminpassword = $_POST['password'];
$adminemail = $_POST['email'];
$url = $_POST['url'];
$dbservername = $_POST['sn'];
$dbusername = $_POST['dbuser'];
$dbpassword = $_POST['dbpass'];
$dbname = $_POST['db'];


//$conn = new mysqli($dbservername, $dbusername, $dbpassword);
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword);


// Check connection
if ($conn === false) {
    echo "<div class=\"actinstall\" ><label>Connection Failed.Check if username or password or server name correct</label></div>";
    echo "<style>.hideinstall{display:none;}</style>";
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE manager";
if (mysqli_query($conn, $sql)) {

    $errors = [];

    $link = mysqli_connect($dbservername, $dbusername, $dbpassword,$dbname);


    // Check connection
    if ($link === false) {
        echo "<div class=\"actinstall\" ><label>Connection Failed.Check if username or password or server name correct</label></div>";
        echo "<style>.hideinstall{display:none;}</style>";
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    


    $table1 = "CREATE TABLE Settings (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    passw VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    lip VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    websiteurl VARCHAR(255) NOT NULL
    )"; 
    
    
    $table2 = "CREATE TABLE Categories (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255) NOT NULL,
    shareasjson VARCHAR(3) NOT NULL
    )"; 
    
    $table3 = "CREATE TABLE CategoryInputs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255) NOT NULL,
    inputname VARCHAR(255) NOT NULL
    )"; 
    
    $table4 = "CREATE TABLE ExternalData (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    datatype VARCHAR(255) NOT NULL,
    datalabel VARCHAR(255) NOT NULL,
    dataurl TEXT NOT NULL,
    dataallowupdate VARCHAR(3) NOT NULL,
    datatimer VARCHAR(255) NOT NULL
    )"; 
    
    
    $table5 = "CREATE TABLE CategoryInsideInputs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255) NOT NULL,
    inputid VARCHAR(255) NOT NULL,
    inputname VARCHAR(255) NOT NULL,
    subinputname VARCHAR(255) NOT NULL,
    subinputval TEXT NOT NULL
    )"; 
    
        
    $table6 = "CREATE TABLE SuperPage (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    superpagename VARCHAR(255) NOT NULL,
    publicorprivate VARCHAR(255) NOT NULL
    )";
    
    
    $table7 = "CREATE TABLE SuperPageData (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    superpagename VARCHAR(255) NOT NULL,
    superpagevalue TEXT NOT NULL
    )";


    $table8 = "CREATE TABLE IndexSuperPage (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    superpagename VARCHAR(255) NOT NULL
    )";
 
    
    $tables = [$table1,$table2,$table3,$table4,$table5,$table6,$table7,$table8];
    
    
    foreach($tables as $k => $ctb){
        $query = mysqli_query($link, $ctb);
    
        if(!$query){
           $errors[] = "Table $k : Creation failed ($conn->error)";
        }else{
           $errors[] = "Table $k : Created";
        }
    }
    
    echo "<div class=\"actinstall\" >";


    foreach($errors as $msg) {
       echo "<label>".$msg."</label><br>";
    }

    //we are using api for ip 
    //$lip = file_get_contents('https://api.ipify.org');
    //or php version 
    $lip = $_SERVER['REMOTE_ADDR'];
    $options = ['cost' => 12,];
    $passencrypt = password_hash($adminpassword, PASSWORD_BCRYPT, $options);



    $token = bin2hex(random_bytes(64));


    $sql = "INSERT INTO Settings (username,passw,email,lip,token,websiteurl) VALUES ('$adminusername','$passencrypt','$adminemail','$lip','$token','$url')";
    if(mysqli_query($link, $sql)){


       echo "<br><label>Database Created.Admin added to database.</label><br><br>";
       echo "<label>Now Open functions.php </label><br><br>";
       echo "<label>Inside functions.php Find:<label><br>";
       echo "<label><b>\$link = mysqli_connect(\"servername\", \"username\", \"password\", \"database name\");</b></label><br>";
       echo "<label>Replace servername,username,password and database name with your database details</label><br><br>";
       echo "<label>Inside functions.php Find: <b>http://\"\$_SERVER['SERVER_NAME']\"/company</b></label><br>";
       echo "<label>Replace <b>http://\"\$_SERVER['SERVER_NAME']\"/company</b> with your website url</label><br><br>";
       echo "<label>Delete install.php file and login to your admin panel:www.yourwebsite.com/admin</label>";


    }
    else{
       echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }





echo "<div>";
echo "<style>.hideinstall{display:none;}</style>";



} else {
  echo "<div class=\"actinstall\" ><label>Error creating database</label></div>";
  echo "<style>.hideinstall{display:none;}</style>";
}


}


?>



</body>
</html>