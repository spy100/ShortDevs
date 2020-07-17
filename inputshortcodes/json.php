<?php
     /*
      Shortcode Meaning:
      Add Json Data Inside Page Form Inputs
      shortcode:  [json][data label][key]
     */ 
     $codeinc++;
     $shortcode[$codeinc] = "[json]"; //shortcode name
     if(substr($row[$inputname], 0, strlen($shortcode[$codeinc])) == $shortcode[$codeinc]){
        $getshortcode[$codeinc] = substr($row[$inputname], strlen($shortcode[$codeinc]));
        $datashortcode[$codeinc] = preg_split('/\h*[][]/', $getshortcode[$codeinc], -1, PREG_SPLIT_NO_EMPTY);

        //shortcode start

        $label = $datashortcode[$codeinc][0];
        $key = $datashortcode[$codeinc][1];
      
        $sql2 = "SELECT * FROM ExternalData WHERE datalabel ='$label'";
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
      
      //without update
      
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
      
             echo "<td class=\"".$inputname.$hhid."\" >".$getdata[$key]."</td>";
      
      
      
      //without update
      
      
              }else{
                //here add json with update timer
      
                $keyid = str_replace(".", "", $key);
                echo "<td class=\"".$inputname.$hhid."\" id=\""."$dlabel"."-"."$keyid"."\" ></td>";
      
                echo "<script>";
      
      
      
      
                echo "$.ajax({"; 
                    echo "type:"."'GET'".","; 
                    echo "url:\"$durl\",";
                    echo "data: { get_param: 'value'},"; 
                    echo "dataType: 'json',";
                    echo "success: function (data) {"; 
                        echo "$.each(data, function(index, element) {";
                         echo "$(\"#"."$dlabel"."-"."$keyid"."\").text(data.".$key.");";
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
                            echo "$(\"#"."$dlabel"."-"."$keyid"."\").text(data.".$key.");";
                
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
           echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
         }



        //shortcode end


      }


?>