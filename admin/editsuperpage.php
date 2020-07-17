<?php
if(!isset($_SESSION)){
  session_start();
}
$username = $_SESSION['username'];
$token = $_SESSION['token'];

if(strlen($token) < 2 || strlen($username) == 0) {
$myrand = rand(0, 5);
$token = $myrand + 1;
$_SESSION['token'] = $myrand + 2;
$username = $myrand;
}


if ( ! defined( 'SHORTDEVS' ) ) {
	define( 'SHORTDEVS', true );
}

include '../functions.php';
include 'sharedfunctions.php';

$superpagename = htmlentities($_GET["superpage"],ENT_QUOTES);


CheckIfAlphaNumeric($superpagename);
CheckIfEmpty($superpagename);

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel='stylesheet'  href='style.css' type='text/css' media='all' />
    <title>ShortDevs</title>
  </head>
  <body>
 

<div id="overlay" ></div>

<div class="stickytop" >

<div class="logonav" ><div class="logo" >[ Short<span class="gold">Devs</span> <span class="smallv" >v.1.0.0</span> ]</div></div>



<div class="mobilenavtop" >
<a href="index.php" id="fullw" class="active">Control Panel</a>
<a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
</a>
<a href="javascript:void(0);" class="closeicon" onclick="CloseFunction()" >
    <i class="fa fa-times"></i>
</a>


</div>


<div class="mobilenav" id="znav">

<?php echo PageMenuMobile("",$link);?>
<a href="logout.php" >LogOut</a>
  <br><br><br><br>
</div>



</div>







<div class="container" id="conav">


<!--start sidebar-->
  <div class="sidebar">
    <div class="paneltitle" >
      Menu
    </div>



    <ul>

<?php echo PageMenuMobile("yes",$link); ?>
<li><a href="cpanel.php" >Control Panel</a></li>
<li><a href="logout.php" >LogOut</a></li>
    
    </ul>
    

    
    </div><!--End sidebar-->
  
  
  
  <div class="rowcontainer" >
  

  <div class="paneltitle2" >
    <div class="titlustanga" >
    Super Page:

    <?php echo $superpagename;?>

</div>

    <div class="ceas"></div>
  </div>
 
<div class="panelbin" >

<div class="catdata2" >

<div class="tablebin2">

<?php


$sql3 = "SELECT * FROM SuperPageData WHERE superpagename ='$superpagename'";
if($result3 = mysqli_query($link, $sql3)){
  if(mysqli_num_rows($result3) > 0){
    $tabid = 0;
    while ($row3 = mysqli_fetch_array($result3))
    {
      $pages = $row3['superpagevalue'];
      $rowid = $row3['id'];


      $columns = preg_split('/\h*[][]/', $pages, -1, PREG_SPLIT_NO_EMPTY);
      $ztabid = $tabid++;


      $totalrows = (count(array_keys($columns, "(")) + count(array_keys($columns, ")"))) / 2;
      $totaltab = (count(array_keys($columns, "{")) + count(array_keys($columns, "}"))) / 2;
      $shortswithouttab = (count($columns) - (($totaltab + $totalrows)*2));



       if($totalrows == 0){
        $tdc = count($columns);
       }else{
         $tdc = count($columns) - $shortswithouttab -$totalrows;
       }

          //example layout shortcodes
          //[Bonds]
          //[{][(][Forex][Indexes][)][(][News][Commodities][)][}][{][(][Bonds][{][(][Forex][Indexes][)][(][News][Commodities][)][}][)][(][Indexes][[News][Bonds][)][}]
          //[Bonds][{][(][Forex][Indexes][)][(][News][Commodities][)][}] example for rows inside rows

       echo "<table><tr><td style=\"background:#f4f4f4;color:black;width:50px !important;text-align:center;font-size:10px;\" >$rowid</td><td>";
       echo "<table id=\"bat".$ztabid."\" ><tr>";

       $ztd = 0;

       foreach($columns as $kc => $cval1){
        $cval = htmlentities($cval1,ENT_QUOTES);
        if($cval == "("){
          echo "<table><tr>";
        }else if($cval == ")") {
          echo "</tr></table>";
        }else if($cval == "{") {
          echo "<td>";
        }else if($cval == "}") {
          echo "</td>";
        }else{
          echo "<td style=\"width:calc(100% / $tdc);\" id=\"superpag.$ztd++\" >".$cval."</td>";
        }
      }
      echo "</tr></table></td></td></table>";
  


    }
  }else{
    echo "";
  }
}else{
  echo "ERROR: Could not able to execute $sql3. " . mysqli_error($link);
}

?>


</div><!--END div tablebin-->


</div><!--END CDATA-->


<div class="formright" >


<h2>Add Row</h2>
<form action="editsuperpage.php?superpage=<?php echo $superpagename;?>" method="post" >
<label style="font-size:12px;color:red;" >Note: Page Name is Case Sensitive</label><br>
<label style="font-size:12px;color:red;" >Ex: If page name is <b>About us</b> use <b>[About us]</b> as shortcode</label><br>
<input id="adr" type="text" name="addrow" value="" placeholder="ex:[page name][page name]" /><br><br>
<input id="adrsbm" type="submit" name="addrowsubmit" value="Add Row" />
</form>


<?php
if (isset($_POST['addrowsubmit']))
{

  $row1 = $link->real_escape_string($_POST['addrow']);
  $row = htmlentities($row1,ENT_QUOTES);
  CheckIfEmpty($row);
  CheckBraketsAlphaNumeric($row);


// Attempt insert query execution
$sql = "INSERT INTO SuperPageData (superpagename,superpagevalue) VALUES ('$superpagename','$row')";
  if(mysqli_query($link, $sql)){
     echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/editsuperpage.php?superpage=$superpagename\");</script>";
  }
  else{
     echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
  }
}
?>


<br>
<div class="adrerr errors" ></div>

<h2>Delete Row</h2>
<form action="editsuperpage.php?superpage=<?php echo $superpagename;?>" method="post" >
<label>Row Id:</label><br>
<input id="delrowid" type="text" name="drow" value="" placeholder="" /><br><br>
<input id="delrowsmb" type="submit" name="deleterow" value="Delete" />
</form>

<?php

if (isset($_POST['deleterow'])) {
  $deleteentry1 = $link->real_escape_string($_POST['drow']);
  $deleteentry = htmlentities($deleteentry1,ENT_QUOTES);
  CheckIfEmpty($deleteentry);
  CheckIfInt($deleteentry);

 $sql5 = "DELETE FROM SuperPageData WHERE id = '$deleteentry' ";

 if(mysqli_query($link, $sql5)){
   echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/editsuperpage.php?superpage=$superpagename\");</script>";
   exit;
 }else{ 
   echo "ERROR: Could not able to execute $sql5. " . mysqli_error($link);
 }
}


?>


<br>
<div class="errormsgdelrow errors" ></div>

<h2>Edit Row</h2>
<form action="editsuperpage.php?superpage=<?php echo $superpagename;?>" method="post" >
<label>Row Id:</label><br>
<input id="edrid" type="text" name="editrowid" value="" placeholder="" /><br>
<label>New Value:</label><br>
<input id="edrval" type="text" name="newvalue" value="" placeholder="" /><br><br>
<input id="edrsbm" type="submit" name="editrowsubmit" value="Edit" />
</form>



<?php

if (isset($_POST['editrowsubmit'])) {

  $entryid1 = $link->real_escape_string($_POST['editrowid']);
  $newval1 = $link->real_escape_string($_POST['newvalue']);
  $entryid = htmlentities($entryid1,ENT_QUOTES);
  $newval = htmlentities($newval1,ENT_QUOTES);
  CheckIfEmpty($entryid);
  CheckIfEmpty($newval);
  CheckIfInt($entryid);
  CheckBraketsAlphaNumeric($newval);
  
  $sql6 = "UPDATE SuperPageData SET superpagevalue = '$newval' WHERE id = '$entryid'";
  if(mysqli_query($link, $sql6)){
    echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/editsuperpage.php?superpage=$superpagename\");</script>";
    exit;
  }else{ 
    echo "ERROR: Could not able to execute $sql6. " . mysqli_error($link);
  }

}

?>


<br>

<div class="errormsgedr errors" ></div>
<h2>Preview SuperPage</h2><br>

<form action="editsuperpage.php?superpage=<?php echo $superpagename;?>" method="post" >
<input type="submit" name="preview" value="Preview" />
</form>
<br>

<?php
if (isset($_POST['preview'])) {
  echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/preview.php?superpage=$superpagename\");</script>";
}
?>

<h2>SuperPage Status</h2>

<form action="editsuperpage.php?superpage=<?php echo $superpagename;?>" method="post" >
<label>SuperPage Status:<b>
<?php
$sql9 = "SELECT publicorprivate FROM SuperPage WHERE superpagename = '$superpagename'";
   if($result9 = mysqli_query($link, $sql9)){
    if(mysqli_num_rows($result9) > 0){ 
      while ($row9 = mysqli_fetch_array($result9))
      {
          echo htmlentities($row9['publicorprivate'],ENT_QUOTES);
      }
    }else{
     echo "No Superpage Status";
    }
   }else{
     echo "ERROR: Could not able to execute $sql9. " . mysqli_error($link);
   }
?>
</b>
</label><br>
<select name="superpageprivpub" >
 <option name="" >Select Private Or Public</option>
 <option name="private" >Private</option>
 <option name="public" >Public</option>
</select><br><br>
<input type="submit" name="priv" value="Save" />
</form>
<br>
<?php
if (isset($_POST['priv'])) {
  $spp1 = $link->real_escape_string($_POST['superpageprivpub']);
  $spp = htmlentities($spp1,ENT_QUOTES);
  CheckIfEmpty($spp);
if($spp == "Public"){ $sprivpub = "public"; }else{ $sprivpub = "private"; }
  //echo "$sprivpub";
  $sql10 = "UPDATE SuperPage SET publicorprivate = '$sprivpub' WHERE superpagename = '$superpagename'";
  if(mysqli_query($link, $sql10)){
    echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/editsuperpage.php?superpage=$superpagename\");</script>";
    exit;
  }else{ 
    echo "ERROR: Could not able to execute $sql10. " . mysqli_error($link);
  }
}
?>

</div><!--END FORM RIGHT-->

</div><!--END Panel bin-->

  </div><!--END ROW Container-->
  
  </div>
  
<br><br><br>

    <div class="footer" >
         Copyright &copy; <script>document.write(new Date().getFullYear())</script> ShortDevs All rights reserved
    </div>
    
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.zoom.js"></script>
    <script type="text/javascript" src="../js/functions.js"></script>

 
      </body>
    </html>

