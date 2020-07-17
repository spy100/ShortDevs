<?php
     /*
      Shortcode Meaning:
      Show a link inside a cell
      shortcode:  [link][url][label]
     */ 
     $codeinc++;
     $shortcode[$codeinc] = "[a]"; //shortcode name
     if(substr($row[$inputname], 0, strlen($shortcode[$codeinc])) == $shortcode[$codeinc]){
        $getshortcode[$codeinc] = substr($row[$inputname], strlen($shortcode[$codeinc]));
        $datashortcode[$codeinc] = preg_split('/\h*[][]/', $getshortcode[$codeinc], -1, PREG_SPLIT_NO_EMPTY);

        //shortcode start


        $linkurl = $datashortcode[$codeinc][0];
        $labellink =  $datashortcode[$codeinc][1];


        echo "<td class=\"".$inputname.$hhid."\" ><a href=\"$linkurl\" >".$labellink."</a></td>";

        //shortcode end


      }


?>