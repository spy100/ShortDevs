
<?php
if(!defined('SHORTDEVS')) {
  header("Location: ../index.php");
  exit;
}


function CheckUser($username,$token,$link){
$sql = "SELECT token FROM Settings WHERE username = '$username'";
if($result = mysqli_query($link, $sql)){
  if(mysqli_num_rows($result) > 0){ 
    while($row = mysqli_fetch_array($result)){
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
}


function PageMenuMobile($li,$link){
  // Attempt select query execution
  $sql = "SELECT * FROM Categories";
  if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){ 
      while($row = mysqli_fetch_array($result)){
        $categorie = htmlentities($row['category'],ENT_QUOTES);
        $sql3 = "SELECT * FROM CategoryInputs WHERE category ='$categorie'";
        if($result3 = mysqli_query($link, $sql3)){
          if(mysqli_num_rows($result3) > 0){
          if($li){echo"<li>";}
          echo "<a id=\"$categorie\" href=\"category.php?cat=$categorie\" >";
          echo $categorie;
          echo "</a>";
          if($li){echo"</li>";}
          }
       }else{
         echo "ERROR: Could not able to execute $sql3. " . mysqli_error($link);
       }
      }
   }else{
     echo "";
   }
  }else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
  }
}



function SelectOptionPage($link){
  $sql = "SELECT * FROM Categories";
  if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){ 
      while($row = mysqli_fetch_array($result)){
          $categorie = htmlentities($row['category'],ENT_QUOTES);
          echo "<option value=\"$categorie\" >";
          echo $categorie;
          echo "</option>";
      }
   }else{
     echo "No records matching your query were found.";
   }
  }else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
  }
}


function SelectPreviewForm($link){
  $sql4 = "SELECT * FROM Categories";
  if ($result4 = mysqli_query($link, $sql4)) {
      if (mysqli_num_rows($result4) > 0) {
          while($row4 = mysqli_fetch_array($result4)){
              $categorie = $row4['category'];
              
              $sql3 = "SELECT * FROM $categorie";
              if ($result3 = mysqli_query($link, $sql3)) {
                  
                  echo "<option value=\"$categorie\" >";
                  echo $categorie;
                  echo "</option>";
                  
              } //check if sql table exists
          }
      } else {
          echo "No records matching your query were found.";
      }
  } else {
      echo "ERROR: Could not able to execute $sql4. " . mysqli_error($link);
  }
}

function SelectInputCreateForm($link){
$sql = "SELECT * FROM Categories";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)){
            $categorie = $row['category'];
      
            $sql3 = "SELECT * FROM $categorie";
            $result3 = mysqli_query($link, $sql3);
            if($result3) {
            }else{
                echo "<option value=\"$categorie\" >";
                echo $categorie;
                echo "</option>";
                
            } //check if sql table exists
        }
    } else {
        echo "No records matching your query were found.";
    }
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
}

function SelectDeletePage($link){
$sql = "SELECT * FROM Categories";
$arr1 = array();
$arr2 = array();
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)){
            $categorie = $row['category'];
            $arr1[] = $categorie;
            $sql3 = "SELECT category FROM CategoryInputs WHERE category = '$categorie'";
            if ($result3 = mysqli_query($link, $sql3)) {
              while ($row = mysqli_fetch_array($result3)) {
                $arr2[] = $row['category'];
              }
            }else{
              echo "";
            } //check if sql table exists
        }
    } else {
        echo "No records matching your query were found.";
    }
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$arr3 = array_unique($arr2);
foreach($arr1 as $akey => $valarr){
  if (!in_array($valarr, $arr3)){
    echo "<option value=\"$valarr\" >";
    echo $valarr;
    echo "</option>";
  }
  
}//end foreach
}

function ExternalDataLabelSelectoption($link){
$sql5 = "SELECT * FROM ExternalData";
if($result5 = mysqli_query($link, $sql5)){
 if(mysqli_num_rows($result5) > 0){ 
   while ($row5 = mysqli_fetch_array($result5))
   {
     $datalabel = htmlentities($row5['datalabel'],ENT_QUOTES);
       echo "<option value=\"$datalabel\" >";
       echo $datalabel;
       echo "</option>";
    }
  }else{
    echo "No records matching your query were found.";
  }
}else{ 
  echo "ERROR: Could not able to execute $sql5. " . mysqli_error($link);
}
}

//validate functions start
function CheckIfInt($s){if(!ctype_digit($s)){ echo "Id must be a integer number";exit;}}
function CheckIfAlphaNumeric($s){if(!ctype_alnum($s)){echo $s." Must have letters and numbers only"; exit;}}
function CheckIfEmpty($s){if(empty($s)){ echo "Must not be empty";exit;}}
function CheckNotice($s){if(!preg_match('/^[a-z0-9 .\-]+$/i', $s)){echo "Alert must have letters numbers spaces . and - only";}}
function CheckIfUrl($url){ 
  $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
  $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
  $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
  $regex .= "(\:[0-9]{2,5})?"; // Port 
  $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
  $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
  $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

     if(!preg_match("/^$regex$/i", $url)) // `i` flag for case-insensitive
     { 
             echo "Sry this is not a url";
     } 
}

function CheckBraketsAlphaNumeric($s){
  $regex = '/^[\[\]\(\)\{\}a-zA-Z][a-zA-Z0-9\{\}\[\]\(\)]+/m';
  if(!preg_match("$regex", $s)){
    echo "Only brakets [](){} and alphanumeric allowed for rows";
    exit;
  }
}

//validate functions end




?>
