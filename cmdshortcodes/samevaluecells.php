<?php
     /*
      Command Meaning:
      Find cells with same value in this page
      command:  [samevalue][this][id][column name][highlight background color]
     */ 
     $command = "[samevalue][this]"; //command name
     if(substr($cmdname, 0, strlen($command)) == $command){
        $getcmd = substr($cmdname, strlen($command));
        $datacmd = preg_split('/\h*[][]/', $getcmd, -1, PREG_SPLIT_NO_EMPTY);
 
        $id = $datacmd[0];
        $column = $datacmd[1];
        $hcolor = $datacmd[2];

        $sql = "SELECT $column FROM $categorycmd WHERE id='$id'";
        $value = array();
        if($result = mysqli_query($link, $sql)){
         if(mysqli_num_rows($result) > 0){ 
          while ($row = mysqli_fetch_array($result))
          {
             $value[] = $row[$column];
          }
         }else{
          echo "";
         }
        }else{
         echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }   

        $sql2 = "SELECT * FROM $categorycmd";
          $columnident = array();
        if($result2 = mysqli_query($link, $sql2)){
         if(mysqli_num_rows($result2) > 0){ 
          while ($row2 = mysqli_fetch_array($result2))
          {

               $counter = 1;
               foreach ($row2 as $key2 => $value2) {
                  
                   if($counter % 2 == 0){ 
                        if($key2 != "id"){
                           if($value2 == $value[0]){
                              $columnident[] = $key2;
                           }
                        }
                  } 
                   $counter++;
               }
          }
         }else{
          echo "";
         }
        }else{
         echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
        }   





        $id4 = array();
        foreach ($columnident as $key3 => $value3) {
        $sql = "SELECT id,$value3 FROM $categorycmd";
        if($result = mysqli_query($link, $sql)){
         if(mysqli_num_rows($result) > 0){ 
          while ($row = mysqli_fetch_array($result))
          {  echo "<pre>";
            if($row[$value3] == $value[0]){
             $id4[] = $row['id'];
            }
          }
         }else{
          echo "";
         }
        }else{
         echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
       }

       //echo "<div>Cell Value Selected: <b>".$value[0]."</b></div><br>";
       echo "<div><b>Cells with same value:</b></div>";
       foreach ($columnident as $key4 => $value4) {
          echo "<div>[".$value4."][".$id4[$key4]."]</div>";
          echo "<style>.".$value4.$id4[$key4]."{background:".$hcolor." !important;}</style>";
       }


     }else{
        $doesnotexist = $cc++;
     }
   

?>
