<?php
include 'functions.php';
$cat = htmlentities($_GET['cat'], ENT_QUOTES);
function CheckIfAlphaNumeric($s)
{
    if (!ctype_alnum($s)) {
        echo "";
        exit;
    }
}
function CheckIfEmpty($s)
{
    if (empty($s)) {
        echo "";
        exit;
    }
}
//validate functions end

CheckIfAlphaNumeric($cat);
CheckIfEmpty($cat);



$sql1 = "SELECT shareasjson FROM Categories WHERE category ='$cat'";


if ($result1 = mysqli_query($link, $sql1)) {
    if (mysqli_num_rows($result1) > 0) {
        while ($row1 = mysqli_fetch_array($result1)) {
            
            if ($row1['shareasjson'] == "Yes") {
              $pagejson = array();
                $sql = "SELECT * FROM $cat";
                if ($result = mysqli_query($link, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                             //print_r($row);
                             $counter = 1;
                             foreach($row as $keyv => $datajson){

                               if($counter % 2 == 0){
                                 
                                 $pagejson[] = array($keyv => $datajson);
                                
                                //echo $key." ".$datajson." ".$counter."<br>";
                               }
                                $counter++;
                             }

                        }
                    } else {
                        echo "";
                    }
                } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }
                

                header('Content-type: application/json');
                echo json_encode($pagejson);





            } else {
                echo "";
            }
            
            
        }
    } else {
        echo "";
    }
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}









?> 