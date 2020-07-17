<?php
     /*
      If this is not a shortcode show database data
     */ 

      $checkifshortcode = $row[$inputname];
      if($checkifshortcode[0] != "[" && substr($checkifshortcode, -1) != "]"){
        echo "<td class=\"".$inputname.$hhid."\" >".htmlentities($row[$inputname],ENT_QUOTES)."</td>";
      }
?>