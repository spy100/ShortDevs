<?php
     /*
      Shortcode Meaning:
      Show a image inside a cell from a url
      shortcode:  [img][url][width][height]
     */ 
     $codeinc++;
     $shortcode[$codeinc] = "[img]"; //shortcode name
     if(substr($row[$inputname], 0, strlen($shortcode[$codeinc])) == $shortcode[$codeinc]){
        $getshortcode[$codeinc] = substr($row[$inputname], strlen($shortcode[$codeinc]));
        $datashortcode[$codeinc] = preg_split('/\h*[][]/', $getshortcode[$codeinc], -1, PREG_SPLIT_NO_EMPTY);

        //shortcode start


        $imgurl = $datashortcode[$codeinc][0];
        $imgw =  $datashortcode[$codeinc][1];
        $imgh =  $datashortcode[$codeinc][2];

        echo "<td class=\"".$inputname.$hhid."\" ><img src=\"$imgurl\" width=\"$imgw\" height=\"$imgh\" alt=\"\" ></td>";

        //shortcode end


      }


?>