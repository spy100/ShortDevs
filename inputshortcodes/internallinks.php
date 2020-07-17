<?php
     /*
      Shortcode Meaning:
      Show a internal link inside a cell
      shortcode:  [s][label]
     */ 
     $codeinc++;
     $shortcode[$codeinc] = "[s]"; //shortcode name
     if(substr($row[$inputname], 0, strlen($shortcode[$codeinc])) == $shortcode[$codeinc]){
        $getshortcode[$codeinc] = substr($row[$inputname], strlen($shortcode[$codeinc]));
        $datashortcode[$codeinc] = preg_split('/\h*[][]/', $getshortcode[$codeinc], -1, PREG_SPLIT_NO_EMPTY);

        //shortcode start



        $labellink =  $datashortcode[$codeinc][0];


        echo "<td class=\"".$inputname.$hhid."\" ><a href=\"index.php?superpage=$labellink\" >".$labellink."</a></td>";

        //shortcode end


      }


?>