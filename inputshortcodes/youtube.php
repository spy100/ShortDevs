<?php
     /*
      Shortcode Meaning:
      Add a youtube video inside a cell:
      shortcode:  [youtube][youtube video string][width][height]
     */ 
     $codeinc++;
     $shortcode[$codeinc] = "[youtube]"; //shortcode name
     if(substr($row[$inputname], 0, strlen($shortcode[$codeinc])) == $shortcode[$codeinc]){
        $getshortcode[$codeinc] = substr($row[$inputname], strlen($shortcode[$codeinc]));
        $datashortcode[$codeinc] = preg_split('/\h*[][]/', $getshortcode[$codeinc], -1, PREG_SPLIT_NO_EMPTY);

        //shortcode start
        $youtubelink = $datashortcode[$codeinc][0];
        $w = $datashortcode[$codeinc][1];
        $h = $datashortcode[$codeinc][2];
       
        echo "<td class=\"".$inputname.$hhid."\" ><iframe width=\"$w\" height=\"$h\" src=\"https://www.youtube.com/embed/$youtubelink\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe></td>";

        //shortcode end


      }


?>