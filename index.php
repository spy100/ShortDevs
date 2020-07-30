<?php
   include 'functions.php';
   $sql9 = "SELECT superpagename FROM IndexSuperPage";
   $su = array();
   if($result9 = mysqli_query($link, $sql9)){
    if(mysqli_num_rows($result9) > 0){ 
      while ($row9 = mysqli_fetch_array($result9))
      {
         if(!empty($row9['superpagename'])){
          $su = htmlentities($row9['superpagename'],ENT_QUOTES);
         }else{
           exit;
         }
      }
    }else{
     exit;
    }
   }else{
     echo "ERROR: Could not able to execute $sql9. " . mysqli_error($link);
   }


   if (isset($_GET["superpage"])) {
    $super = htmlentities($_GET["superpage"],ENT_QUOTES);
   }else{
    $super = "";
   }

   function CheckIfAlphaNumeric($s){if(!ctype_alnum($s)){echo "Must have letters and numbers only"; exit;}}


   if(!empty($super)){
     CheckIfAlphaNumeric($super);
     $sup = $super;
   }else{
     $sup = $su;
   }





   $sql10 = "SELECT publicorprivate FROM SuperPage WHERE superpagename = '$sup'";
   if($result10 = mysqli_query($link, $sql10)){
    if(mysqli_num_rows($result10) > 0){ 
      while ($row10 = mysqli_fetch_array($result10))
      {
         if(htmlentities($row10['publicorprivate'],ENT_QUOTES) == "private"){
          echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/404.php\");</script>";
          exit;
         }
      }
    }else{
      echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/404.php\");</script>";
      exit;
    }
   }else{
     echo "ERROR: Could not able to execute $sql10. " . mysqli_error($link);
   }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="superpagestyle.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <title>Your Title</title>
  </head>
  <body>
 

<div class="container-fluid" >

<?php
include 'functions.php';
$superpagename = $sup;
$shortcodessarr = array();
if ($handle2 = opendir('inputshortcodes')) {  
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




      echo "<table class=\"a$ztabid\" id=\"a".$ztabid."\" ><tr class=\"aa$ztabid\" >";
      $ztd = 0;
      //start foreach
      foreach($columns as $kc => $cval1){
          //echo $cval1;
          $ztd++;
          $cval = htmlentities($cval1,ENT_QUOTES);
          if($cval == "("){
            echo "<table class=\"c$ztd\" ><tr class=\"cc$ztd\" >";
          }else if($cval == ")"){
            echo "</tr></table>";
          }else if($cval == "{"){
            echo "<td class=\"ccc$ztd\" >";
          }else if($cval == "}"){
            echo "</td>";
          }else{

             //start get page
             $zzcat = $cval;
             echo "<td class=\"aaa$ztd\" ><table class=\"b$ztd\" >";
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
               echo "ERROR:Could not able to execute $sql66. " . mysqli_error($link);
             }

             $r = 0;
             $sql = "SELECT * FROM $zzcat";
             if($result = mysqli_query($link, $sql)){
               if(mysqli_num_rows($result) > 0){ 
                 while ($row = mysqli_fetch_array($result))
                 {
                  $t = $r++;
                   echo "<tr class=\"bb$t\" >";
                   $hhid = $row['id'];
                   
                   
                   foreach ( $arrinputs as $inputname ){
             //start loop
                      $codeinc = 0;
                      foreach ( $shortcodessarr as $keyshort => $shortcodepage ){
                         include 'inputshortcodes/'.$shortcodepage;
                      }
             
             //end loop
                   }
                   echo "</tr>";
                 }
               }else{
                 echo "";
               }
             }else{
               echo "ERROR1111: Could not able to execute $sql. " . mysqli_error($link);
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


