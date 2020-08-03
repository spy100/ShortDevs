<?php
     /*
      Shortcode Meaning:
      Generate random alphanumeric string on page refresh inside a cell:
      shortcode:  [randstring][length]
     */ 
     $codeinc++;
     $shortcode[$codeinc] = "[randstring]"; //shortcode name
     if(substr($row[$inputname], 0, strlen($shortcode[$codeinc])) == $shortcode[$codeinc]){
        $getshortcode[$codeinc] = substr($row[$inputname], strlen($shortcode[$codeinc]));
        $datashortcode[$codeinc] = preg_split('/\h*[][]/', $getshortcode[$codeinc], -1, PREG_SPLIT_NO_EMPTY);

        //shortcode start
        $length = $datashortcode[$codeinc][0];

       

          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength = strlen($characters);
          $randomString = '';
          for ($i = 0; $i < $length; $i++) {
              $randomString .= $characters[rand(0, $charactersLength - 1)];
          }
  
        




        echo "<td class=\"".$inputname.$hhid."\" >".$randomString."</td>";

        //shortcode end


      }


?>
