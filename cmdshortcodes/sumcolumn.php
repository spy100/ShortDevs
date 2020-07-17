<?php
     /*
      Command Meaning:
      Get the sum of all cells in a column for this page
      command:  [sumcolumn][this][column name]
     */ 
     $command = "[sumcolumn][this]"; //command name
     if(substr($cmdname, 0, strlen($command)) == $command){
        $getcmd = substr($cmdname, strlen($command));
        $datacmd = preg_split('/\h*[][]/', $getcmd, -1, PREG_SPLIT_NO_EMPTY);
       
        $sql = "SELECT SUM($datacmd[0]) AS sumcolumn FROM $categorycmd";
        if($result = mysqli_query($link, $sql)){
          if(mysqli_num_rows($result) > 0){ 
            while ($row = mysqli_fetch_array($result))
            {
                echo "<div>Total For ".$datacmd[0].": <b>".$row['sumcolumn']."</b></div>";
            }
          }else{
            echo "";
          }
        }else{
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }

     }else{
        $doesnotexist = $cc++;
     }
   

?>