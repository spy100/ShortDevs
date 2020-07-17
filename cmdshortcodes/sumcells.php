<?php
     /*
      Command Meaning:
      Get the sum of specific cells for this page
      command:  [sumcells][this][id][column name][id][column name][id][column name]
     */ 
     $command = "[sumcells][this]"; //command name
     if(substr($cmdname, 0, strlen($command)) == $command){
        $getcmd = substr($cmdname, strlen($command));
        $datacmd = preg_split('/\h*[][]/', $getcmd, -1, PREG_SPLIT_NO_EMPTY);
 

        $arrids = array();
        $arrcolumns = array();
        foreach($datacmd as $key => $cells){
           if($key % 2 == 0){ 
             $arrids[] = $cells;
           }else{ 
             $arrcolumns[] = $cells;
           } 
        }
        $cyz = 0;
        $arrvals = array();
        foreach($arrids as $idkey => $id){
          $cyz++;

          $colnam = $arrcolumns[$cyz-1];
          
          $sql = "SELECT $colnam FROM $categorycmd WHERE id='$id'";
          if($result = mysqli_query($link, $sql)){
           if(mysqli_num_rows($result) > 0){ 
            while ($row = mysqli_fetch_array($result))
            {
               $arrvals[] = $row[$colnam];
            }
           }else{
            echo "";
           }
          }else{
           echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
          }        
          
          
        }

        $total = array_sum($arrvals);
        
        echo "<div>Total: <b>".$total."</b></div>";



        


     }else{
        $doesnotexist = $cc++;
     }
   

?>
