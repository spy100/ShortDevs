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
include '../functions.php';

$sql = "SELECT token FROM Settings WHERE username = '$username'";
if($result = mysqli_query($link, $sql)){
  if(mysqli_num_rows($result) > 0){ 
    while ($row = mysqli_fetch_array($result))
    {
        $dtoken = $row['token'];
        if($dtoken == $token){
           $welcomemsg = "";
        }else{
          header("Location: ../index.php");
          exit;
        }
    }
  }else{
    header("Location: ../index.php");
    exit;
  }
}else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel='stylesheet'  href='superpagestyle.css' type='text/css' media='all' />
    <script type="text/javascript" src="../js/jquery.min.js"></script>




    <title>Preview</title>
  </head>
  <body>
 

<div class="container-fluid" >
<div class="row dark" >
<table class="table table-nonfluid table-dark" id="mastertable" cellpadding="0" cellspacing="0" ><tr><td>

<?php
function CheckIfAlphaNumeric($s){if(!ctype_alnum($s)){echo "Must have letters and numbers only"; exit;}}
function CheckIfEmpty($s){if(empty($s)){ echo "Must not be empty";exit;}}
$superpagename = htmlentities($_GET["superpage"],ENT_QUOTES);
CheckIfAlphaNumeric($superpagename);
CheckIfEmpty($superpagename);
include '../functions.php';
$shortcodessarr = array();
if ($handle2 = opendir('../inputshortcodes')) {  
  while (false !== ($entry = readdir($handle2))) {

   if ($entry != "." && $entry != "..") {
    $shortcodessarr[] = $entry;
   }

  }  
 closedir($handle2);
}
$totalshortcodes = count($shortcodessarr);
$notashortcode = "no";


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




      echo "<table class=\"\" id=\"bat".$ztabid."\" ><tr class=\"\" >";
      $ztd = 0;
      //start foreach
      foreach($columns as $kc => $cval1){
          //echo $cval1;
          $cval = htmlentities($cval1,ENT_QUOTES);
          if($cval == "("){
            echo "<table class=\"\" ><tr class=\"\" >";
          }else if($cval == ")"){
            echo "</tr></table>";
          }else if($cval == "{"){
            echo "<td class=\"h-100 11\"; >";
          }else if($cval == "}"){
            echo "</td>";
          }else{


            
             //start get page
             $zzcat = $cval;
             echo "<td style=\"width:calc(100% / $tdc);\" ><table class=\"\" >";
             $sql66 = "SELECT * FROM CategoryInputs WHERE category ='$zzcat'";
             $arrinputs = array();
             if($result66 = mysqli_query($link, $sql66)){
               if(mysqli_num_rows($result66) > 0){
                 while ($row66 = mysqli_fetch_array($result66))
                 {
                   $inputname = $row66['inputname'];
                   $arrinputs[] = $row66['inputname'];
                 }
               }else{
                 echo "";
               }
             }else{
               echo "ERROR: Could not able to execute $sql66. " . mysqli_error($link);
             }

             $r = 0;
             $sql = "SELECT * FROM $zzcat";
             if($result = mysqli_query($link, $sql)){
               if(mysqli_num_rows($result) > 0){ 
                 while ($row = mysqli_fetch_array($result))
                 {
             
                   echo "<tr class=\"\" >";
                   $hhid = $row['id'];
                   $t = $r++;
                   
                   foreach ( $arrinputs as $inputname ){
             //start loop
                      $codeinc = 0;
                      foreach ( $shortcodessarr as $keyshort => $shortcodepage ){
                         include '../inputshortcodes/'.$shortcodepage;
                      }
             
             //end loop
                   }
                   echo "</tr>";
                 }
               }else{
                 echo "";
               }
             }else{
               echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
             }
             
             
             echo "</table></td>";


             //end get page

             
          }



      }//end foreach
      echo "</tr></table>";
    }
  }else{
    echo "";
  }
}else{
  echo "ERROR: Could not able to execute $sql3. " . mysqli_error($link);
}

?>


</td></tr></table>


</div>
</div><!--END CONTAINER -->

<script>
    var encodedtxt = $(".container-fluid").html();
    function decodeHtml(html) {
      var txt = document.createElement("textarea");
      txt.innerHTML = html;
      return txt.value;
    }
    var encodedtxt = decodeHtml(encodedtxt);
    $(".container-fluid").html(encodedtxt).text();

</script>

  </body>
</html>

