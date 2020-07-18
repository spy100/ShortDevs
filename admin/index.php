<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
$sessl = 3600 * 24 * 360; 
ini_set('session.gc_maxlifetime', $sessl);
session_set_cookie_params($sessl);
session_start();
$username = $_SESSION['username'];
$token =  $_SESSION['token'];
include '../functions.php';

$sql = "SELECT token FROM Settings WHERE username = '$username'";
if($result = mysqli_query($link, $sql)){
  if(mysqli_num_rows($result) > 0){ 
    while ($row = mysqli_fetch_array($result))
    {
        $dtoken = $row['token'];
        if($dtoken == $token){
          header("Location: cpanel.php");
          exit;
        }
    }
  }
}else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}



function CheckIfEmpty($s){if(empty($s)){ echo "<label>Must not be empty</label>";exit;}}
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel='stylesheet'  href='style.css' type='text/css' media='all' />
    <style>
     #honey{display:none;}

    input[type="submit"]{
    width:10%;
    display:block;
    height:40px;
    margin-top:5px;
    margin-right:5px;
    border:1px solid goldenrod;
    background:gold;
    color:black;
    font-size:14px;
    padding:5px;
    text-transform:uppercase;
    border-radius:4px;
    }
    
   input[type="submit"]:hover{
   background:#FFDF00;
   transition: 0.3s;
   -webkit-transition:0.3s;
   -moz-transition:0.3s;
   -o-transition:0.3s;
   -webkit-box-shadow: 0 0 5px 2px #fff;
   -moz-box-shadow: 0 0 5px 2px #fff;
    box-shadow: 0 0 5px 2px #fff;
    cursor: pointer;
   }




    
    </style>
    <title>ShortDevs</title>
  </head>
<body>

<div class="logonav" ><div class="logo" >[ Short<span class="gold">Devs</span> <span class="smallv" >v.1.0.0</span> ]</div></div>



<br><br><br>
<div class="actinstall" >
<h2>Login</h2><br>
<form action="index.php" method="POST">
<input id="honey" type="text" name="honey" value="" />
<label>Username:</label><br>
<input type="text" name="username" value="" />
<br><br>
<label>Password:</label><br>
<input type="password" name="password" autocomplete="new-password" value="" />
<br><br>
<input type="submit" name="submit" value="Login" />
</form>

<?php
if (isset($_POST['submit'])) {
echo "<br><br>";

    $username = $_POST['username'];
    $passw = $_POST['password'];
    $honey = $_POST['honey'];

    if(!empty($honey)){exit;}

    CheckIfEmpty($username);
    CheckIfEmpty($passw);

    $sql = "SELECT username,passw FROM Settings";
    if($result = mysqli_query($link, $sql)){
      if(mysqli_num_rows($result) > 0){ 
        while ($row = mysqli_fetch_array($result))
        {
            $dusername = $row['username'];
            $hash = $row['passw'];
            

            if($username == $dusername){
                if (password_verify($passw, $hash)) {
                   //Password is valid

                    $token = bin2hex(random_bytes(64));
                    $_SESSION['username'] = $dusername;
                    $_SESSION['token'] = $token;

                    //we are using api for ip 
                    //$lip = file_get_contents('https://api.ipify.org');
                    //or php version 
                    $lip = $_SERVER['REMOTE_ADDR'];


                    $sql6 = "UPDATE Settings SET token = '$token',lip = '$lip' WHERE username = '$dusername'";
                    if(mysqli_query($link, $sql6)){
                      echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/cpanel.php\");</script>";
                      exit;
                    }else{ 
                      echo "ERROR: Could not able to execute $sql6. " . mysqli_error($link);
                    }




                   //Password is valid
                } else {
                    echo "<label>Invalid passwod.</label>";
                }
            }else{
                echo "<label>Invalid username.</label>";
            }

        }
      }else{
       echo "";
      }
    }else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }

}
?>



</div>









<div class="footer" >
      Copyright &copy; <script>document.write(new Date().getFullYear())</script> ShortDevs All rights reserved
</div>








</body>
</html>
