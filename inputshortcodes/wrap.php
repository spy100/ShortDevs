<?php
     /*
      Shortcode Meaning:
      Wrap text inside a cell (so it goes down to next line if text to long):
      shortcode:  [wrap][your very long text here]
     */ 
     $codeinc++;
     $shortcode[$codeinc] = "[wrap]"; //shortcode name
     if(substr($row[$inputname], 0, strlen($shortcode[$codeinc])) == $shortcode[$codeinc]){
        $getshortcode[$codeinc] = substr($row[$inputname], strlen($shortcode[$codeinc]));
        $datashortcode[$codeinc] = preg_split('/\h*[][]/', $getshortcode[$codeinc], -1, PREG_SPLIT_NO_EMPTY);

        //shortcode start


        $wraptext = $datashortcode[$codeinc][0];
        echo "<td class=\"".$inputname.$hhid."\" ><div class=\"wrap\">".$wraptext."</div></td>";

        //shortcode end


      }


?>