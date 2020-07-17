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
CheckUser($username,$token,$link);

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel='stylesheet'  href='style.css' type='text/css' media='all' />
    <title>Company Name</title>
</head>
<body>
 
<div id="overlay" ></div> 

<div class="stickytop" >
    <div class="logonav" ><div class="logo" >[ Short<span class="gold">Devs</span> <span class="smallv" >v.1.0.0</span> ]</div></div>
    <div class="mobilenavtop" >
        <a href="cpanel.php" id="fullw" class="active">Control Panel</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()"><i class="fa fa-bars"></i></a>
        <a href="javascript:void(0);" class="closeicon" onclick="CloseFunction()" ><i class="fa fa-times"></i></a>
    </div>

<div class="mobilenav" id="znav">
   <?php echo PageMenuMobile("",$link); ?>
   <a href="logout.php" >LogOut</a>
  <br><br><br><br>
</div>

</div>

<div class="container" id="conav">

<!--start sidebar-->
  <div class="sidebar">
    <div class="paneltitle" >Menu</div>
    <ul>
       <?php echo PageMenuMobile("yes",$link); ?>
       <li><a href="cpanel.php" >Control Panel</a></li>
       <li><a href="logout.php" >LogOut</a></li>
    </ul>
  </div><!--End sidebar-->
  
  <div class="rowcontainer" >
  

  <div class="paneltitle" ><div class="titlustanga" >Control Panel</div><div class="ceas"></div></div>
 
  <div class="panelbin" >


<div class="panelgroup" >

     <!--START Panel Box-->
    <div class="panelbox" >

    
    <div class="pbtn" >
      <div class="pintit">Page</div>
      <div class="pinbtns"><button class="panelboxhideshow1"><img src="hideicon.png" alt="x" ></button></div>
    </div>

    <!--START P Box-->
    <div class="pbox1" ><br>
    
    <h2>Add Page</h2>

    <form action="cpanel.php" method="post">
       <label>Page Name:</label><br>
       <input type="text" id="addpage" name="categoria" value="" />
       <br><br>
       <input id="submitadd" type="submit" name="submit" value="Add" />
    </form>
    <br>

    <?php
       if (isset($_POST['submit'])) {
          $catsql1 = $link->real_escape_string($_POST['categoria']);
          $catsql  = htmlentities($catsql1, ENT_QUOTES);
          CheckIfAlphaNumeric($catsql);
          CheckIfEmpty($catsql);

          $sql3 = "SELECT * FROM Categories WHERE category ='$catsql'";
          if ($result3 = mysqli_query($link, $sql3)) {
             if (mysqli_num_rows($result3) == 0) {
            
                  $sql = "INSERT INTO Categories (category,shareasjson) VALUES ('$catsql','No')";
                  if (mysqli_query($link, $sql)) {
                    echo "<label style=\"color:green;margin-top:-10px;display:block;\" >Page Added</label><br>";
                    echo "<script>setTimeout(function () {window.location.href= '$baseurl/admin/cpanel.php';},2000)</script>";
                  } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                  }
             } else {
                  echo "<div class=\"errormsgadd errors\" >Page Name Already Exists<br><br></div>";
             }
         } else {
             echo "ERROR: Could not able to execute $sql3. " . mysqli_error($link);
         }
       }
     ?> 
     <div class="errormsgadd errors" ></div>

     <h2>Delete Page</h2>
     <form action="cpanel.php" method="post">
        <label>Page:</label><br>
        <select id="delselect" name="numecategorie" >
           <option value="" >Select page...</option>
           <?php echo SelectDeletePage($link); ?>
        </select>
       <br><br>
       <input id="delpagsubmit" type="submit" name="submit2" value="Delete" />
     </form>
     <br>

    <?php
       if (isset($_POST['submit2'])) {
          $delcatsql1 = $link->real_escape_string($_POST['numecategorie']);
          $delcatsql = htmlentities($delcatsql1,ENT_QUOTES);
          CheckIfAlphaNumeric($delcatsql);
          CheckIfEmpty($delcatsql);
          $sql = "SELECT * FROM CategoryInputs WHERE category ='$delcatsql'";
          if($result = mysqli_query($link, $sql)){
             if(mysqli_num_rows($result) > 0){
                echo "<div class=\"errormsgadd errors\" >Delete entries and form before deleting category<br><br></div>";exit;
             }else{
                 $sql2 = "DELETE FROM Categories WHERE category = '$delcatsql' ";
                 if(mysqli_query($link, $sql2)){
                    echo "<label style=\"color:green;margin-top:-10px;display:block;\" >Page Deleted</label><br>";
                    echo "<script>setTimeout(function () {window.location.href= '$baseurl/admin/cpanel.php';},2000)</script>";
                 }else{
                    echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
                 }
             }//check if inputs deleted
          }else{
              echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
          }
       }
     ?>
     <div class="errormsgdelpage errors" ></div>

     <h2>Create Input For Page</h2>
     <form action="cpanel.php" method="post">
         <label>Page:</label><br>
         <select id="inputselect" name="numecategorie" >
             <option value="" >Select page...</option>
             <?php echo SelectInputCreateForm($link); ?>
         </select>
        <br><br>
        <label>Page Input Name:</label><br>
        <input id="ciadd" type="text" name="numeinput" value="" />
        <br><br>
        <input id="cipsubmit" type="submit" name="submit5" value="Create" />
      </form>
     <br>

<?php
if (isset($_POST['submit5']))
{
    $inpcatsql1 = $link->real_escape_string($_POST['numecategorie']);
    $inpnamsql1 = $link->real_escape_string($_POST['numeinput']);
    $inpcatsql = htmlentities($inpcatsql1,ENT_QUOTES);
    $inpnamsql = htmlentities($inpnamsql1,ENT_QUOTES);
    CheckIfEmpty($inpcatsql1);
    CheckIfAlphaNumeric($inpnamsql1);
    CheckIfAlphaNumeric($inpcatsql);
    CheckIfEmpty($inpnamsql1);
    $sql3 = "SELECT * FROM CategoryInputs WHERE category ='$inpcatsql' AND inputname ='$inpnamsql'";
    if ($result3 = mysqli_query($link, $sql3)) {
        if (mysqli_num_rows($result3) == 0) {
          $sql = "INSERT INTO CategoryInputs (category,inputname) VALUES ('$inpcatsql','$inpnamsql')";
          if(mysqli_query($link, $sql)){
            echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/cpanel.php\");</script>";
            exit;
          }else{
              echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
          }
        } else {
            echo "<div class=\"errormsgadd errors\" >Input Name Already Exists<br><br></div>";
        }
    } else {
        echo "ERROR: Could not able to execute $sql3. " . mysqli_error($link);
    }

}
?>
<div class="errormsgci errors" ></div>

     <h2>Preview Form Inputs</h2><br>
     <ul>

<?php
$sql = "SELECT * FROM Categories";
$zdatatest = array();
if($result = mysqli_query($link, $sql)){
if(mysqli_num_rows($result) > 0){ 
  while ($row = mysqli_fetch_array($result))
  {

      $categorie = $row['category'];
      $sql3 = "SELECT * FROM $categorie";
      if($result3 = mysqli_query($link, $sql3)){
      }else{
      echo "<li>";
      echo "<b>Page: ".$categorie."</b>";
      echo "<ul class=\"previewform\" >";
      $sql2 = "SELECT * FROM CategoryInputs WHERE category ='$categorie'";
       $myarr = array();
      if($result2 = mysqli_query($link, $sql2)){
        if(mysqli_num_rows($result2) > 0){ 
          while ($row2 = mysqli_fetch_array($result2))
          {
            $myarr[] = htmlentities($row2['inputname'],ENT_QUOTES);
            $inputname = htmlentities($row2['inputname'],ENT_QUOTES);
              $inputbox = "<input type=\"text\" name=\"$inputname\" value=\"\" />
              <div class=\"selectboxx\" >
              <form action=\"cpanel.php\" method=\"post\">
              <input type=\"hidden\" name=\"deleteinput\" value=\"$inputname\" />
              <input type=\"submit\" name=\"submit12\" value=\"Delete\" />
              </form>
              </div>";
            echo "<li><label>Label: ".$inputname."</label></li>";
            echo "<li>".$inputbox."</li>";
          }
        }else{
          echo "";
        }
      }else{
       echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
      }
      echo "</ul>";
      $thedata = implode(" TEXT NOT NULL,",$myarr);
      $zdatatest[$categorie] = $thedata;
      if(!empty($myarr)){
       echo "<br><div>
       <form action=\"cpanel.php\" method=\"post\">
       <input type=\"hidden\" name=\"cat\" value=\"$categorie\" />
       <input type=\"hidden\" name=\"activatecatform\" value=\"$thedata\" />
       <input type=\"submit\" name=\"submit19\" value=\"Activate Form\" />
       </form>
       </div><br><br>";
      }
      echo "</li>";
     }//check if sql table exists

   }//endwhile

  }else{
    echo "";
  }
}else{
echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
?>
     </ul>

<?php
include '../functions.php';
if (isset($_POST['submit12'])) {
  $delinp1sql1 = $link->real_escape_string($_POST['deleteinput']);
  $delinp1sql = htmlentities($delinp1sql1,ENT_QUOTES);
  CheckIfAlphaNumeric($delinp1sql);
  CheckIfEmpty($delinp1sql);
  $sql2 = "DELETE FROM CategoryInputs WHERE inputname = '$delinp1sql' ";
  if(mysqli_query($link, $sql2)){
    echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/cpanel.php\");</script>";
    exit;
  }else{
    echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
  }
}

if (isset($_POST['submit19'])) {
 $catname1 = $link->real_escape_string($_POST['cat']);
 $activatedata = $link->real_escape_string($_POST['activatecatform']);
 $catname = htmlentities($catname1,ENT_QUOTES);
 CheckIfAlphaNumeric($catname);
 CheckIfEmpty($catname);

 if($zdatatest[$catname] != $activatedata){
  echo "<div class=\"errormsgadd errors\" >Sry input data does not match<br><br></div>";
  exit;
 }

 $sql = "CREATE TABLE ".$catname." ( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,".$activatedata." TEXT NOT NULL)";
 if(mysqli_query($link, $sql)){
  echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/cpanel.php\");</script>";
  exit;
 } else{
  echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
 }

}
?>

<br>


<h2>View Created Forms</h2>
<form action="cpanel.php" method="post">
   <label>Page:</label><br>
   <select id="vformselect" name="numecategorie2" >
      <option value="" >Select page...</option>
      <?php echo SelectPreviewForm($link); ?>
   </select>
   <br><br>
   <input id="viewformsubmit" type="submit" name="submit20" value="View Form" />
</form>
<br>

<?php
if (isset($_POST['submit20'])) {
$viewform1 = $link->real_escape_string($_POST['numecategorie2']);
$viewform = htmlentities($viewform1,ENT_QUOTES);
CheckIfAlphaNumeric($viewform);
CheckIfEmpty($viewform);
echo "<h2>".$viewform."</h2>";
echo "<ul>";
$sql2 = "SELECT * FROM CategoryInputs WHERE category ='$viewform'";
 $myarr = array();
if($result2 = mysqli_query($link, $sql2)){
  if(mysqli_num_rows($result2) > 0){ 
    while ($row2 = mysqli_fetch_array($result2)){
      $myarr[] = htmlentities($row2['inputname'],ENT_QUOTES);
      $inputname = htmlentities($row2['inputname'],ENT_QUOTES);
      $inputbox = "<input type=\"text\" name=\"$inputname\" value=\"\" />";
      echo "<li><label>Label: ".$inputname."</label></li>";
      echo "<li>".$inputbox."</li>";
    }
  }else{
    echo "";
  }
 }else{
   echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
 }

 if(!empty($myarr)){
 $deleteform = "<br><div class=\"selectboxx\" ><form action=\"cpanel.php\" method=\"post\">
 <input type=\"hidden\" name=\"deleteform\" value=\"$viewform\" />
 <input type=\"submit\" name=\"submit22\" value=\"Delete\" />
 </form>
 </div><br>";
 echo "<li>".$deleteform."</li>";
 }

 echo "</ul>";
}


if (isset($_POST['submit22'])) {
  $deleteform1 = $link->real_escape_string($_POST['deleteform']);
  $deleteform = htmlentities($deleteform1,ENT_QUOTES);
  CheckIfAlphaNumeric($deleteform);
  CheckIfEmpty($deleteform);

  $sqlmulti = array();
  $sqlmulti[] = "DROP TABLE ".$deleteform;
  $sqlmulti[] = "DELETE FROM CategoryInputs WHERE category='$deleteform'";
  $sqldone = array();
  
  foreach($sqlmulti as $k => $v){
    if($multiquery = mysqli_query($link,$v)){
      $sqldone[] = "yes";

    }else{
      echo "ERROR: Could not able to execute $v. " . mysqli_error($link);
    }
  }
  if($sqldone[count($sqldone)-1] == "yes"){
    echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/cpanel.php\");</script>";
    exit;
  }

}
?>
<div class="errormsgvf errors" ></div>

</div><!--END P Box -->

</div><!--END Panel box Container-->

<!--START Panel Box-->
<div class="panelbox" >

<div class="pbtn" >
      <div class="pintit">External Data</div>
      <div class="pinbtns"><button class="panelboxhideshow2"><img src="hideicon.png" alt="x" ></button></div>
    </div>

    <!--START P Box-->
    <div class="pbox2" ><br>


<h2>Add External Data</h2>

<form action="cpanel.php" method="post">
   <label>Data Type:</label><br>
   <select id="extformselect" name="datatype" >
     <option value="" >Select data type...</option>
     <option value="json" >JSON</option>
   </select>
   <br><br>
   <label>External Data Label:</label><br>
   <input id="dlab" type="text" name="datalabel" value="" />
   <br><br>
   <label>URL Data:</label><br>
   <input id="durl" type="text" name="dataurl" value="" />
   <br><br>
   <label>Allow Data Update:</label><br>
   <select id="dupdate" name="updatetimer" >
      <option value="" >Select...</option>
      <option value="yes" >Yes</option>
      <option value="no" >No</option>
   </select>
   <br><br>
   <label>Update Data Timer (miliseconds):</label><br>
   <input type="text" name="dataupdatetimer" value="" />
   <br><br>
   <input id="addextsubmit" type="submit" name="submit24" value="Add" />
</form>
<br>

<?php 
if (isset($_POST['submit24']))
{
  $datatype1 = $link->real_escape_string($_POST['datatype']);
  $datalabel1 = $link->real_escape_string($_POST['datalabel']);
  $dataurl1 = $link->real_escape_string($_POST['dataurl']);
  $dataupdate = $link->real_escape_string($_POST['updatetimer']);
  $datatimer1 = $link->real_escape_string($_POST['dataupdatetimer']);
  $datatype = htmlentities($datatype1,ENT_QUOTES);
  $datalabel = htmlentities($datalabel1,ENT_QUOTES);
  $dataurl = htmlentities($dataurl1,ENT_QUOTES);
  $datatimer = htmlentities($datatimer1,ENT_QUOTES);

  CheckIfAlphaNumeric($datatype);
  CheckIfAlphaNumeric($datalabel);
  CheckIfUrl($dataurl);

if(empty($dataupdate)){
  $dataupdate == "no";
}

 if(!empty($datatype) && !empty($datalabel) && !empty($dataurl)){

  if($dataupdate == "yes"){
    CheckIfInt($datatimer);
  }else{
    $datatimer = "";
    $dataupdate = "no";
  }

  $sql3 = "SELECT * FROM ExternalData WHERE datalabel ='$datalabel'";
  if ($result3 = mysqli_query($link, $sql3)) {
      if (mysqli_num_rows($result3) == 0) {
          
        $sql = "INSERT INTO ExternalData (datatype,datalabel,dataurl,dataallowupdate,datatimer) VALUES ('$datatype','$datalabel','$dataurl','$dataupdate','$datatimer')";
        if(mysqli_query($link, $sql)){
          echo "<label style=\"color:green;margin-top:-10px;display:block;\" >External Data Added</label><br>";
          echo "<script>setTimeout(function () {window.location.href= '$baseurl/admin/cpanel.php';},2000)</script>";
          exit;
        }else{
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
          
      } else {
          echo "<div class=\"errormsgadd errors\" >External Data Label Already Exists<br><br></div>";
      }
  } else {
      echo "ERROR: Could not able to execute $sql3. " . mysqli_error($link);
  }

 }//check if empty
}
?>

<div class="errormsgext errors" ></div>

<h2>View External Data</h2>
<form action="cpanel.php" method="post" >
   <label>Data Label:</label><br>
   <select id="vext" name="datlabel" >
      <option value="" >Select data label...</option>
      <?php echo ExternalDataLabelSelectoption($link); ?>
   </select>
   <br><br>
   <input id="vextsbm" type="submit" name="submit30" value="View Data" />
</form>
<br>

<?php
if (isset($_POST['submit30'])){
$datlabel1 = $link->real_escape_string($_POST['datlabel']);
$datlabel = htmlentities($datlabel1,ENT_QUOTES);
CheckIfAlphaNumeric($datlabel);

$sql2 = "SELECT * FROM ExternalData WHERE datalabel ='$datlabel'";
if($result2 = mysqli_query($link, $sql2)){
  if(mysqli_num_rows($result2) > 0){ 
    while ($row2 = mysqli_fetch_array($result2)){
      $dtype = $row2['datatype'];
      $dlabel = $row2['datalabel'];
      $durl= $row2['dataurl'];
      $dupdate= $row2['dataallowupdate'];
      $dtimer= $row2['datatimer'];
      $json    = file_get_contents($durl);
      $decoded = json_decode($json,true);
      echo "<ul>";
      echo "<li><h4>Data Label: ".$dlabel."</b></h4></li>";
      echo "<li><label>Data Type: <b>".$dtype."</b></label></li>";
      echo "<li><label>URL data: <a href=\"".$durl."\" >Url Link</a></label></li>";
      echo "<li><label>Allow Data Update: <b>".$dupdate."</b></label></li>";
      echo "<li><label>Data Timer: <b>".$dtimer."</b> miliseconds</label></li>";
      echo "<br>";

    function flatten($array, $prefix = '') {
      $result = array();
      foreach($array as $key=>$value) {
          if(is_array($value)) {
              $result = $result + flatten($value, $prefix . $key . '.');
          }else{
              $result[$prefix . $key] = $value;
          }
      }
      return $result;
    }
  
    $getdata = flatten($decoded);
    foreach($getdata as $key=>$value) {
       echo "<li>key:<span style=\"color:red;\" >".$key."</span></li>";
      echo "<li>value:".$value."</li>";
    }
      echo "</ul>";
    }
 }else{
  echo "";
 }
}else{
 echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 echo "<br><ul><li><b>* Add Data Inside Page Form Inputs:</b><br> [data type][data label][key]</li></ul>";
}//end check if submit set
?>

<div class="errormsgvext errors" ></div>


<br>
<h2>Delete External Data</h2>
<form action="cpanel.php" method="post" >
   <label>Data Label:</label><br>
   <select id="dext" name="deldata" >
      <option value="" >Select data label...</option>
      <?php echo ExternalDataLabelSelectoption($link);?>
   </select>
<br><br>
   <input id="dextsbm" type="submit" name="submit31" value="Delete Data" />
</form>
<br>

<?php
 if (isset($_POST['submit31'])) {
    $deletedat1 = $link->real_escape_string($_POST['deldata']);
    $deletedat = htmlentities($deletedat1,ENT_QUOTES);
    CheckIfAlphaNumeric($deletedat);
    CheckIfEmpty($deletedat);
    $sql8 = "DELETE FROM ExternalData WHERE datalabel = '$deletedat' ";
    if(mysqli_query($link, $sql8)){
      echo "<label style=\"color:green;margin-top:-10px;display:block;\" >External Data Deleted</label><br>";
      echo "<script>setTimeout(function () {window.location.href= '$baseurl/admin/cpanel.php';},2000)</script>";
     exit;
    }else{
    echo "ERROR: Could not able to execute $sql8. " . mysqli_error($link);
    }
  }
?>
<div class="errormsgdext errors" ></div>

</div><!-- END P BOX -->

</div><!--END Panel box Container-->


</div><!--END panel group-->

<div class="panelgroup" >


<!--START Panel Box-->
<div class="panelbox" >



<div class="pbtn" >
      <div class="pintit">SuperPage</div>
      <div class="pinbtns"><button class="panelboxhideshow3"><img src="hideicon.png" alt="x" ></button></div>
    </div>

    <!--START P Box-->
    <div class="pbox3" ><br>

<br>
<h2>Add SuperPage</h2>
<form action="cpanel.php" method="post">
<label>SuperPage Name:</label><br>
<input id="adsp" type="text" name="superpage" value="" />
<br><br>
<input id="adspsubmit" type="submit" name="submitaddsuperpage" value="Add" />
</form>
<br>
<?php
if (isset($_POST['submitaddsuperpage']))
{
  $superpage1 = $link->real_escape_string($_POST['superpage']);
  $superpage = htmlentities($superpage1,ENT_QUOTES);
  CheckIfAlphaNumeric($superpage);
  CheckIfEmpty($superpage);
  $publicorprivate = "private";


  $sql3 = "SELECT * FROM SuperPage WHERE superpagename ='$superpage'";
  if ($result3 = mysqli_query($link, $sql3)) {
      if (mysqli_num_rows($result3) == 0) {
          
        $sql = "INSERT INTO SuperPage (superpagename,publicorprivate) VALUES ('$superpage','$publicorprivate')";
        if(mysqli_query($link, $sql)){
          echo "<label style=\"color:green;display:block;\" >SuperPage Added</label><br>";
          echo "<script>setTimeout(function () {window.location.href= '$baseurl/admin/cpanel.php';},2000)</script>";
        }
        else{
           echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
          
      } else {
          echo "<div class=\"errormsgadd errors\" >SuperPage Name Already Exists<br><br></div>";
      }
  } else {
      echo "ERROR: Could not able to execute $sql3. " . mysqli_error($link);
  }

}
?>
<div class="errormsgadsp errors" ></div>



<h2>View SuperPage</h2>


<form action="cpanel.php" method="post">
<label>SuperPage:</label><br>
<select id="vsp" name="superpageview" >
<option value="" >Select superpage...</option>
<?php
function SelectOptionSuperpage($link){
   $sql6 = "SELECT * FROM SuperPage";
   if($result6 = mysqli_query($link, $sql6)){
    if(mysqli_num_rows($result6) > 0){ 
      while ($row6 = mysqli_fetch_array($result6))
      {
        $superpage = htmlentities($row6['superpagename'],ENT_QUOTES);
        echo "<option value=\"$superpage\" >";
        echo $superpage;
        echo "</option>";
      }
    }else{
     echo "";
    }
   }else{
     echo "ERROR: Could not able to execute $sql6. " . mysqli_error($link);
   }
}
echo SelectOptionSuperpage($link);
?>
</select>

<br><br>

<input id="vspsbm" type="submit" name="submitsuperpageview" value="View SuperPage" />
</form>

<?php
if(isset($_POST['submitsuperpageview'])){
   $superpageview = htmlentities($_POST['superpageview'],ENT_QUOTES);
   CheckIfAlphaNumeric($superpageview);
   CheckIfEmpty($superpageview);
   echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/editsuperpage.php?superpage=$superpageview\");</script>";
}
?>
<br>
<div class="errormsgvsp errors" ></div>


<h2>SuperPage As HomePage</h2>
<label>Current HomePage:
<b>
<?php
$sql9 = "SELECT superpagename FROM IndexSuperPage";
   if($result9 = mysqli_query($link, $sql9)){
    if(mysqli_num_rows($result9) > 0){ 
      while ($row9 = mysqli_fetch_array($result9))
      {
         if(!empty($row9['superpagename'])){
          echo htmlentities($row9['superpagename'],ENT_QUOTES);
         }else{
           echo "No Superpage";
         }
      }
    }else{
     echo "No Superpage";
    }
   }else{
     echo "ERROR: Could not able to execute $sql9. " . mysqli_error($link);
   }
?>
</b>
</label><br><br>
<form action="cpanel.php" method="post">
<label>SuperPage:</label><br>
<select id="sph" name="superpagehome" >
<option value="" >Select superpage...</option>
<option value="thisisablanksuperpage" >Set as blank</option>
<?php echo SelectOptionSuperpage($link); ?>
</select>
<br><br>
<input id="sphsbm" type="submit" name="submitsuperpageashome" value="Set As Home" />
</form>

<?php
if (isset($_POST['submitsuperpageashome'])) {
  $superpagehome1 = $link->real_escape_string($_POST['superpagehome']);
  $superpagehome = htmlentities($superpagehome1,ENT_QUOTES);
  CheckIfAlphaNumeric($superpagehome);
  CheckIfEmpty($superpagehome);
  if($superpagehome == "thisisablanksuperpage"){
    $superpagehome = "";
  }
  $sql7 = "SELECT superpagename FROM IndexSuperPage";
  if($result7 = mysqli_query($link, $sql7)){
   if(mysqli_num_rows($result7) == 0){ 
     $sql6 = "INSERT INTO IndexSuperPage (superpagename) VALUES ('$superpagehome')";
     if(mysqli_query($link, $sql6)){
        echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/cpanel.php\");</script>";
        exit;
     }else{ 
        echo "ERROR: Could not able to execute $sql6. " . mysqli_error($link);
     }
   }else{
     $sql8 = "UPDATE IndexSuperPage SET superpagename = '$superpagehome' WHERE id = '1'";
     if(mysqli_query($link, $sql8)){
       echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/cpanel.php\");</script>";
       exit;
     }else{ 
       echo "ERROR: Could not able to execute $sql8. " . mysqli_error($link);
     }
   }
  }else{
    echo "ERROR: Could not able to execute $sql7. " . mysqli_error($link);
  }
}
?>
<br>
<div class="errormsgsph errors" ></div>
<h2>Delete SuperPage</h2>

<form action="cpanel.php" method="post">
<label>SuperPage:</label><br>
<select id="dsp" name="superpagedel" >
<option value="" >Select superpage...</option>
<?php echo SelectOptionSuperpage($link); ?>
</select>
<br><br>
<input id="dspsbm" type="submit" name="submitsuperpagedel" value="Delete" />
</form>


<?php
if (isset($_POST['submitsuperpagedel'])) {
 $deletesuppage1 = $link->real_escape_string($_POST['superpagedel']);
 $deletesuppage = htmlentities($deletesuppage1,ENT_QUOTES);
 CheckIfAlphaNumeric($deletesuppage);
 CheckIfEmpty($deletesuppage);
 $sqlmulti1 = array();
 $sqlmulti1[] = "DELETE FROM SuperPage WHERE superpagename = '$deletesuppage'";
 $sqlmulti1[] = "DELETE FROM SuperPageData WHERE superpagename = '$deletesuppage'";
 $sqldone1 = array();
 
 foreach($sqlmulti1 as $k => $v){
   if($multiquery1 = mysqli_query($link,$v)){
     $sqldone1[] = "yes";
   }else{
     echo "ERROR: Could not able to execute $v. " . mysqli_error($link);
   }
 }
 if($sqldone1[count($sqldone1)-1] == "yes"){
   echo "<br><label style=\"color:green;display:block;\" >SuperPage Deleted</label><br>";
   echo "<script>setTimeout(function () {window.location.href= '$baseurl/admin/cpanel.php';},2000)</script>";
 }

}
?>
<br>
<div class="errormsgdsp errors" ></div>
</div><!-- END PBOX -->

</div><!--END Panel box Container-->

<!--START Panel Box-->
<div class="panelbox" >


<div class="pbtn" >
      <div class="pintit">Admin</div>
      <div class="pinbtns"><button class="panelboxhideshow4"><img src="hideicon.png" alt="x" ></button></div>
    </div>

    <!--START P Box-->
    <div class="pbox4" ><br>


<?php
$sql9 = "SELECT username,lip,email,websiteurl FROM Settings";
$userdata = array();
if($result9 = mysqli_query($link, $sql9)){
 if(mysqli_num_rows($result9) > 0){ 
   while ($row9 = mysqli_fetch_array($result9))
   {
    $userdata[] = $row9['username'];
    $userdata[] = $row9['lip'];
    $userdata[] = $row9['email'];
    $userdata[] = $row9['websiteurl'];
   }
 }else{
  echo "<div class=\"errormsgadd errors\" >No Data<br><br></div>";
 }
}else{
  echo "ERROR: Could not able to execute $sql9. " . mysqli_error($link);
}
?>

<br>

<h2>Edit Admin Settings</h2>
<form action="cpanel.php" method="post">
<label>Admin Username: <b><?php echo $userdata[0]; ?></b></label><br>
<br>
<label>Admin E-Mail:</label><br>
<input id="astemail" type="email" name="email" value="" placeholder="<?php echo $userdata[2]; ?>" />
<br><br>
<label>Url:</label><br>
<input id="asturl" type="text" name="url" value="" placeholder="<?php echo $userdata[3]; ?>" />
<br><br>
<input id="astsbm" type="submit" name="submiteditsettings" value="Save" />
</form>
<?php
if (isset($_POST['submiteditsettings'])){
  
  $email = $link->real_escape_string($_POST['email']);
  $url = $link->real_escape_string($_POST['url']);


  
  if(empty($email)){$email = $userdata[2];}
  if(empty($url)){$url = $userdata[3];}

  
  $sql = "UPDATE Settings SET email = '$email',websiteurl = '$url' WHERE username = '$userdata[0]'";
  if(mysqli_query($link, $sql)){
    echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/cpanel.php\");</script>";
    exit;
  }else{ 
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
  }  


}
?>
<br>
<div class="errormsgast errors" ></div>

<h2>Last Login Ip:</h2>
<label>ip: <b><?php echo $userdata[1]; ?></b></label>

<br><br>
<h2>Change Password</h2>

<form action="cpanel.php" method="post" id="changepass"  >
<label>Old Password:</label><br>
<input id="ochp" type="password" name="oldpass" autocomplete="new-password" id="zold" value="" />
<br><br>
<label>New Password:</label><br>
<input id="nchp" type="password" autocomplete="new-password" name="newpass" value="" />
<br><br>
<label>Confirm Password:</label><br>
<input id="cchp" type="password" autocomplete="new-password" name="confirmpass"  value="" />
<br><br>
<input id="chpsbm" type="submit" name="changepassword" value="Save" />
</form>
<?php
if (isset($_POST['changepassword'])){
  $oldpassw = $_POST['oldpass'];
  $newpassw = $_POST['newpass'];
  $confirmpassw = $_POST['confirmpass'];

  CheckIfEmpty($oldpassw);
  CheckIfEmpty($newpassw);
  CheckIfEmpty($confirmpassw);

  if($newpassw != $confirmpassw){
    echo "<div class=\"errormsgadd errors\" >New Password And Confirm Password do not match<br><br></div>";
    exit;
  }

  $sql = "SELECT username,passw FROM Settings";
  if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){ 
      while ($row = mysqli_fetch_array($result))
      {
          $dusername = $row['username'];
          $hash = $row['passw'];
          
          if($userdata[0] == $dusername){
              if(password_verify($oldpassw, $hash)){

                $token = bin2hex(random_bytes(64));
                $lip = $_SERVER['REMOTE_ADDR'];
                $options = ['cost' => 12,];
                $passencrypt = password_hash($confirmpassw, PASSWORD_BCRYPT, $options);

                $sql = "UPDATE Settings SET passw = '$passencrypt',lip='$lip',token = '$token' WHERE username = '$userdata[0]'";
                if(mysqli_query($link, $sql)){
                  unset($_SESSION['username']);
                  unset($_SESSION['token']);
                  session_destroy();
                   echo "<label>Password Changed...Please login again</label>";
                   echo "<script>setTimeout(function () {window.location.href= '$baseurl/admin/cpanel.php';},2000)</script>";
                   exit;
                }else{ 
                  echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }  
              } else {
                echo "<div class=\"errormsgadd errors\" >Invalid passwod.<br><br></div>";
              }
          }else{
            echo "<div class=\"errormsgadd errors\" >Invalid passwod.<br><br></div>";
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
<br>
<div class="errormsgchp errors" ></div>
<h2>Backup Database</h2>

<form action="cpanel.php" method="post">
<label>Backup your database:</label><br>
<label>If database is very big export it via other ways</label><br>
<br>
<input type="submit" name="backupdatabase" value="Backup" />
</form>

<?php
if (isset($_POST['backupdatabase'])){
//export database start
$link->set_charset("utf8mb4");
$tables = array();
$sql = "SHOW TABLES";
$result = mysqli_query($link, $sql);

while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

$sqlScript = "";
foreach ($tables as $table) {
    
    $query = "SHOW CREATE TABLE $table";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_row($result);
    
    $sqlScript .= "\n\n" . $row[1] . ";\n\n";
    
    
    $query = "SELECT * FROM $table";
    $result = mysqli_query($link, $query);
    
    $columnCount = mysqli_num_fields($result);
    
    for ($i = 0; $i < $columnCount; $i ++) {
        while ($row = mysqli_fetch_row($result)) {
            $sqlScript .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < $columnCount; $j ++) {
                $row[$j] = $row[$j];
                
                if (isset($row[$j])) {
                    $sqlScript .= '"' . $row[$j] . '"';
                } else {
                    $sqlScript .= '""';
                }
                if ($j < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
    }
    
    $sqlScript .= "\n"; 
}

if(!empty($sqlScript))
{
  echo "<br><div><textarea style=\"width:100%;height:200px;font-size:11px;\" >";
  echo $sqlScript;
  echo "</textarea><label>Save inside a .sql file</label></div>";

  
}
//export database end
}
?>



<br>
</div><!-- END PBOX 4-->
</div><!--END Panel box Container-->

</div><!--END panelgroup-->

</div><!--END Panel bin-->

  </div><!--END ROW Container-->
  
  </div>
  
<br><br><br>


    <div class="footer" >
        Copyright &copy; <script>document.write(new Date().getFullYear())</script> ShortDevs All rights reserved
    </div>
    


    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.zoom.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.min.js" ></script>
    <script type="text/javascript" src="../js/functions.js"></script>
 





      </body>
    </html>



