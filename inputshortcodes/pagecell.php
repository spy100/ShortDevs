<?php
     /*
      Shortcode Meaning:
      Add cell "x" From Page A to Page B cell "y" or add cell "x" From Page A to Page A cell "y":
      shortcode:  [page][page name][id][column label name]
     */  
     $codeinc++;
     $shortcode[$codeinc] = "[page]"; //shortcode name
     if(substr($row[$inputname], 0, strlen($shortcode[$codeinc])) == $shortcode[$codeinc]){
        $getshortcode[$codeinc] = substr($row[$inputname], strlen($shortcode[$codeinc]));
        $datashortcode[$codeinc] = preg_split('/\h*[][]/', $getshortcode[$codeinc], -1, PREG_SPLIT_NO_EMPTY);

        //shortcode start
        
        if(count($datashortcode[$codeinc]) == 1 ){
         //need to work 
         echo "<td class=\"".$inputname.$hhid."\" style=\"color:red;\" >"."incorrect shortcode"."</td>";
        }else if(count($datashortcode[$codeinc]) == 2){
         //need to work
         echo "<td class=\"".$inputname.$hhid."\" style=\"color:red;\" >"."incorrect shortcode"."</td>";
        }else if(count($datashortcode[$codeinc]) > 3) {
         echo "<td class=\"".$inputname.$hhid."\" style=\"color:red;\" >"."incorrect shortcode"."</td>";
        }else if(count($datashortcode[$codeinc]) == 3) {
         $catt = $datashortcode[$codeinc][0];
         $idc = $datashortcode[$codeinc][1];
         $entry = $datashortcode[$codeinc][2];
         $sql4 = "SELECT $entry FROM $catt WHERE id='$idc'";
         if($result4 = mysqli_query($link, $sql4)){
           if(mysqli_num_rows($result4) > 0){
         
             while ($row4 = mysqli_fetch_array($result4))
             {
               $inputname4 = $row4[$entry];
        
        
               //check if external data
               if(substr($inputname4, 0, 6) == "[json]"){
        
                 $dat3 = substr($inputname4, 6);
                 $datat3 = preg_split('/\h*[][]/', $dat3, -1, PREG_SPLIT_NO_EMPTY);
                 $label3 = $datat3[0];
                 $key3 = $datat3[1];
                 
               //start add json
                 $sql2 = "SELECT * FROM ExternalData WHERE datalabel ='$label3'";
                 if($result2 = mysqli_query($link, $sql2)){
                   if(mysqli_num_rows($result2) > 0){ 
        
                     while ($row2 = mysqli_fetch_array($result2))
                     {
                       $dtype = $row2['datatype'];
                       $dlabel = $row2['datalabel'];
                       $durl= $row2['dataurl'];
                       $dupdate= $row2['dataallowupdate'];
                       $dtimer= $row2['datatimer'];
                 
                       $json    = file_get_contents($durl);
                       $decoded = json_decode($json,true);
        
        
              
                       if($dupdate == "NO"){
                       function flatten($array, $prefix = '') {
                        $result = array();
                        foreach($array as $key=>$value) {
                            if(is_array($value)) {
                                $result = $result + flatten($value, $prefix . $key . '.');
                            }
                            else {
                                $result[$prefix . $key] = $value;
                            }
                        }
                        return $result;
                       }
        
        
                      $getdata = flatten($decoded);
        
                      echo "<td>".$getdata[$key3]."</td>";
        
        
                       }else{
                         //here add json with update timer
        
                         $keyid = str_replace(".", "", $key3);
                         echo "<td class=\"".$inputname.$hhid."\" id=\""."$dlabel"."-"."$keyid"."-"."$t"."\" ></td>";
        
                         echo "<script>";
        
        
        
        
                         echo "$.ajax({"; 
                             echo "type:"."'GET'".","; 
                             echo "url:\"$durl\",";
                             echo "data: { get_param: 'value'},"; 
                             echo "dataType: 'json',";
                             echo "success: function (data) {"; 
                                 echo "$.each(data, function(index, element) {";
                                  echo "$(\"#"."$dlabel"."-"."$keyid"."-"."$t"."\").text(data.".$key3.");";
                         echo "});";
                         echo "}";
                     echo "});";
        
        
        
        
                         echo "setInterval(function() {";
        
                         echo "$.ajax({"; 
                             echo "type:"."'GET'".","; 
                             echo "url:\"$durl\",";
                             echo "data: { get_param: 'value'},"; 
                             echo "dataType: 'json',";
                             echo "success: function (data) {"; 
                                 echo "$.each(data, function(index, element) {";
                                     //echo "console.log(data.bpi.USD.rate_float);";
                                     echo "$(\"#"."$dlabel"."-"."$keyid"."-"."$t"."\").text(data.".$key3.");";
                         
                                 echo "});";
                             echo "}";
                         echo "});";
                         echo "}," ."$dtimer".");";
        
        
                         echo "</script>";
        
        
        
        
        
                       }
        
        
        
        
                     }
                   }else{
                     echo "";
                   }
                  }else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                  }
        
                //end add json
                
               }else{
                 echo "<td class=\"".$inputname.$hhid."\" >".$inputname4."</td>";
               }
               //end check if external data 
             
             }
           }else{
             echo "";
           }
         }else{
           echo "ERROR: Could not able to execute $sql4. " . mysqli_error($link);
         }
        
        
        
        }else{
          echo "<td class=\"".$inputname.$hhid."\" >".$row[$inputname]."</td>";
        }


        //shortcode end


      }


?>