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
$viewform = htmlentities($_GET["cat"],ENT_QUOTES);
$zzcat = $viewform;
CheckIfAlphaNumeric($viewform);
CheckIfEmpty($viewform);
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel='stylesheet'  href='style.css' type='text/css' media='all' />
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.zoom.js"></script>
    <title>Company Name</title>
  </head>
  <body>
  <div id="overlay" ></div>
  <div class="stickytop" >

  <div class="logonav" ><div class="logo" >[ Short<span class="gold">Devs</span> <span class="smallv" >v.1.0.0</span> ]</div></div>

     <div class="mobilenavtop" >
        <a href="index.php" id="fullw" class="active">Control Panel</a>
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
       <div class="paneltitle" >Menu </div>
       <ul>
          <?php echo PageMenuMobile("yes",$link); ?>
          <li><a href="cpanel.php" >Control Panel</a></li>
          <li><a href="logout.php" >LogOut</a></li>    
       </ul>
    </div><!--End sidebar-->
  
    <div class="rowcontainer" >
  
       <div class="paneltitle" >
           <div class="titlustanga" ><?php echo $viewform;?></div><div class="ceas"></div>
       </div>

       

       <div class="cmdform" >
           <form action="" method="POST" >
               <input id="cmder" type="text" name="commandinput" value="" placeholder="example:[help]" />
               <input id="cmdsbm" type="submit" name="submitcmd" value="Submit"  />
           </form>
       </div>

       <div class="resultcmd" >

       <?php 
         $cc = 0;
         if(isset($_POST['submitcmd'])){ 
            $categorycmd = $viewform;
            $cc++;
            $cmd1 = $link->real_escape_string($_POST['commandinput']);
            $cmd = htmlentities($cmd1,ENT_QUOTES);
            CheckIfEmpty($cmd);
            $cmdsarr = array();
            if($handle = opendir('../cmdshortcodes')) {  
               while (false !== ($entry = readdir($handle))){
                  if($entry != "." && $entry != ".."){
                     $cmdsarr[] = $entry;
                  }
               }  
            closedir($handle);
            }
            foreach($cmdsarr as $cmdkey=>$cmdvalue) {
               $cmdname = $cmd;
               include '../cmdshortcodes/'.$cmdvalue;
            }

            $excludehtmlfile = count($cmdsarr) - 1;
            if($excludehtmlfile == $doesnotexist){
               echo "<div class=\"cmderr errors\" >Short Code does not exist</div><br>";
            }
         }
       ?>
              <div class="cmderr errors" ></div>
      </div>




      <div class="panelbin" >

      <?php
        $shortcodessarr = array();
        if($handle2 = opendir('../inputshortcodes')){  
            while(false !== ($entry = readdir($handle2))){
               if($entry != "." && $entry != ".."){
                   $shortcodessarr[] = $entry;
               }
            }  
           closedir($handle2);
        }
        $totalshortcodes = count($shortcodessarr);
        $notashortcode = "no";
       ?>

          <div class="catdata" >
            
           <?php
              echo "<div class=\"tablebin\" id=\"".$viewform."table\" >";
              echo "<table><tr><th class=\"tit2\" ><b>Id</b></th>";

              $sql3445 = "SELECT * FROM CategoryInputs WHERE category = '$viewform' ";
              $arrinputs = array();

              if($result3445 = mysqli_query($link, $sql3445)){
                 if(mysqli_num_rows($result3445) > 0){
                    while ($row3445 = mysqli_fetch_array($result3445)){
                       $inputname = htmlentities($row3445['inputname'],ENT_QUOTES);
                       $arrinputs[] = htmlentities($row3445['inputname'],ENT_QUOTES);
                       echo "<th class=\"tit\" ><b>".$inputname."</b></th>";
                    }
                 }else{
                    echo "";
                 }
              }else{
                 echo "ERROR: Could not able to execute $sql3445. " . mysqli_error($link);
              }
              echo "</tr>";

            

              $r = 0;
              $sql = "SELECT * FROM $viewform";
              if($result = mysqli_query($link, $sql)){
                  if(mysqli_num_rows($result) > 0){ 
                      while ($row = mysqli_fetch_array($result)){
                          echo "<tr><td class=\"zid\" >".$row['id']."</td>";
                          $hhid = $row['id'];
                          $t = $r++;
                          foreach( $arrinputs as $inputname ){
                          //start loop
                              $codeinc = 0;
                              foreach( $shortcodessarr as $keyshort => $shortcodepage ){
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
                  echo "<style>table{border-top:1px solid #ccc;}th{display:none;}</style><tr><td style=\"color:red;\" >Activate The Page Form In <b>Control Panel</b> So you can see this page</td></tr>";
              }
              echo "</table>";
              echo "</div>";
           ?>



          </div><!--END CATDATA-->

          <div class="formright" >
          
          <button class="verticaltbbtn">Toggle Page View</button>
          <br><br>
             <h2>Page Form</h2>

             <?php
               echo "<ul>";
               echo "<form action=\"category.php?cat=$viewform\" method=\"post\">";
               $sql2 = "SELECT * FROM CategoryInputs WHERE category ='$viewform'";
               $myarr = array();
               if($result2 = mysqli_query($link, $sql2)){
                  if(mysqli_num_rows($result2) > 0){ 
                      while ($row2 = mysqli_fetch_array($result2)){
                          $myarr[] = htmlentities($row2['inputname'],ENT_QUOTES);
                          $inputname = htmlentities($row2['inputname'],ENT_QUOTES);
                          $inputbox = "<input type=\"text\" name=\"$inputname\" value=\"\" />";
                          echo "<li><label>".$inputname."</label></li>";
                          echo "<li>".$inputbox."</li>";
                      }
                  }else{
                      echo "";
                  }
               }else{
                  echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
               }

               if(!empty($myarr)){
                  echo "<br><input type=\"submit\" name=\"submit\" value=\"Submit\" />";
               }

               echo "</form>";
               echo "</ul>";

               if (isset($_POST['submit'])){
                  $cats = implode(",",$myarr);
                  $myarr2 = array();
                  foreach($_POST as $key => $value){
                      if($value != "Submit"){
                          $myarr2[] = htmlentities($value,ENT_QUOTES);
                      }
                  }//end fore
                  $vals = implode("','",$myarr2);

                  $gg = 0;
                  foreach($myarr2 as $k => $v){
                     $cc = $gg++;
                     if(empty($v)){
                        echo "<br><div class=\"errormsgee errors\" >\"".$myarr[$cc]."\" input must not be empty. <a style=\"color:black;\" href=\"$baseurl/admin/category.php?cat=$viewform\" >Refresh Page</a></div>";
                        exit;
                     }
                  
                  }

                  CheckIfEmpty($vals);

                  $sql5 = "INSERT INTO $viewform ($cats) VALUES ('$vals')";
                  if(mysqli_query($link, $sql5)){
                     echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/category.php?cat=$viewform\");</script>";
                  }else{
                      echo "ERROR: Could not able to execute $sql5. " . mysqli_error($link);
                  }
               }
             ?>

          <br>
          <h2>Delete Entry</h2>
          <form action="category.php?cat=<?php echo $viewform;?>" method="POST" >
             <label>ID:</label><br>
             <input id="delent" type="text" name="entryid" value="" />
             <br><br>
             <input id="delentsmb" type="submit" name="submit2" value="Submit" />
          </form>

          <?php
            if(isset($_POST['submit2'])) {
               $deleteentry1 = $link->real_escape_string($_POST['entryid']);
               $deleteentry = htmlentities($deleteentry1,ENT_QUOTES);
               CheckIfInt($deleteentry);
               CheckIfEmpty($deleteentry);
               $sql = "DELETE FROM $viewform WHERE id = '$deleteentry' ";
               if(mysqli_query($link, $sql)){
                   echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/category.php?cat=$viewform\");</script>";
                   exit;
               }else{ 
                   echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
               }
            }
          ?>

          <br>
          <div class="errormsgdelent errors" ></div>
          <h2>Edit Entry</h2>
          <form action="category.php?cat=<?php echo $viewform;?>" method="POST" >
             <label>ID:</label><br>
             <input id="eeid" type="text" name="entryid2" value="" />
             <br>
             <label>Entry Column Label:</label><br>
             <input id="eecol" type="text" name="entryinput" value="" />
             <br>
             <label>New Value:</label><br>
             <input id="eeval" type="text" name="newvalue" value="" />
             <br><br>
             <input id="eesbm" type="submit" name="submit3" value="Submit" />
          </form>
          <?php
             if (isset($_POST['submit3'])) {
                $entryid1 = $link->real_escape_string($_POST['entryid2']);
                $entryinp1 = $link->real_escape_string($_POST['entryinput']);
                $newval1 = $link->real_escape_string($_POST['newvalue']);
                $entryid = htmlentities($entryid1,ENT_QUOTES);
                $entryinp = htmlentities($entryinp1,ENT_QUOTES);
                $newval = htmlentities($newval1,ENT_QUOTES);
                CheckIfInt($entryid);
                CheckIfAlphaNumeric($entryinp);
                CheckIfEmpty($entryid);
                CheckIfEmpty($entryinp);

                $sql6 = "UPDATE $viewform SET $entryinp = '$newval' WHERE id = '$entryid'";

                if(mysqli_query($link, $sql6)){
                    echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/category.php?cat=$viewform\");</script>";
                    exit;
                }else{ 
                    echo "ERROR: Could not able to execute $sql6. " . mysqli_error($link);
                }
              }
          ?>

          <br>
          <div class="errormsgee errors" ></div>
          <h2>Show Page Json To Public</h2><br>
          <label>If you want to share your data as json for this page so other people can use. <br><br>( *Note input shortcodes will show as normal text)</label><br><br>

          <?php
             $sql2 = "SELECT shareasjson FROM Categories WHERE category ='$viewform'";
             $sjstat = array();
             if($result2 = mysqli_query($link, $sql2)){
                if(mysqli_num_rows($result2) > 0){ 
                   while($row2 = mysqli_fetch_array($result2)){
                       $sjstat[] = $row2['shareasjson'];
                   }
                }else{
                   echo "";
                }
             }else{
                echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
             }
          ?>

         <form action="category.php?cat=<?php echo $viewform;?>" method="post" >
             <label>Is Json For This Page Public: <b><?php echo $sjstat[0]; ?></b></label><br><br>
             <select name="sharedorpublicjson" >
                <option name="" >Select Yes or No</option>
                <option name="yes" >Yes</option>
                <option name="no" >No</option>
            </select><br><br>
            <input type="submit" name="sharepagejsonsubmit" value="Save" />
         </form>
         <br>
         <?php
            if(isset($_POST['sharepagejsonsubmit'])) {
               $sppjson = $link->real_escape_string($_POST['sharedorpublicjson']);
               $newjsonval = htmlentities($sppjson,ENT_QUOTES);
               CheckIfEmpty($newjsonval);
               if($newjsonval == "Yes"){ $jshares = "Yes"; }else{ $jshares = "No"; }
               $sql6 = "UPDATE Categories SET shareasjson = '$jshares' WHERE category = '$viewform'";
               if(mysqli_query($link, $sql6)){
                  echo "<script data-cfasync=\"false\"> window.location.replace(\"$baseurl/admin/category.php?cat=$viewform\");</script>";
                  exit;
               }else{ 
                  echo "ERROR: Could not able to execute $sql6. " . mysqli_error($link);
               }
            }
         ?>

         </div><!--END Formright-->

      </div><!--End panelbin-->
  
    </div><!--END ROW Container-->
  
  </div><!--END Container-->

  <br><br><br>

  <div class="footer" >Copyright &copy; <script>document.write(new Date().getFullYear())</script> ShortDevs All rights reserved</div>
  

  <script type="text/javascript" src="../js/functions.js"></script>

  <script>  
    $('.verticaltbbtn').click(function(event) {
       //add local storage here
       $( ".catdata" ).toggleClass( "ztb" );
       var classes = $('.catdata').attr('class').split(' ');

       if(classes[1] == "ztb"){
           localStorage.setItem("pageview<?php echo $viewform;?>", "vertical<?php echo $viewform;?>");
       }else{
           localStorage.setItem("pageview<?php echo $viewform;?>", "horizontal<?php echo $viewform;?>");
      } 
    });

    var pageview = localStorage.getItem("pageview<?php echo $viewform;?>");
    console.log(pageview);
    if(pageview == "vertical<?php echo $viewform;?>"){
      $( ".catdata" ).addClass( "ztb" );
    }else{
      localStorage.removeItem('pageview<?php echo $viewform;?>');
    }


    var encodedtxt = $(".catdata").html();
    function decodeHtml(html) {
      var txt = document.createElement("textarea");
      txt.innerHTML = html;
      return txt.value;
    }
    var encodedtxt = decodeHtml(encodedtxt);
    $(".catdata").html(encodedtxt).text();

    var encodedtxt1 = $(".ztb").html();
    function decodeHtmlone(html) {
      var txt = document.createElement("textarea");
      txt.innerHTML = html;
      return txt.value;
    }
    var encodedtxt1 = decodeHtmlone(encodedtxt1);
    $(".ztb").html(encodedtxt1).text();




  </script>


    </body>
  </html>

