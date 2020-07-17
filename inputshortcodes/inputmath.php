<?php
     /*
      Shortcode Meaning:
      Command Meaning:
      Make math operations in the page form input 
      shortcode:  [math][your equation]
      example: [math][1+2]
     */ 
     $codeinc++;
     $shortcode[$codeinc] = "[math]"; //shortcode name
     if(substr($row[$inputname], 0, strlen($shortcode[$codeinc])) == $shortcode[$codeinc]){
        $getshortcode[$codeinc] = substr($row[$inputname], strlen($shortcode[$codeinc]));
        $datashortcode[$codeinc] = preg_split('/\h*[][]/', $getshortcode[$codeinc], -1, PREG_SPLIT_NO_EMPTY);

        //shortcode start


        function calc($equation)
        {
            // Remove whitespaces
            $equation = preg_replace('/\s+/', '', $equation);       
            $number = '((?:0|[1-9]\d*)(?:\.\d*)?(?:[eE][+\-]?\d+)?|pi|π)'; 
        
            $functions = '(?:sinh?|cosh?|tanh?|acosh?|asinh?|atanh?|exp|log(10)?|deg2rad|rad2deg|sqrt|pow|abs|intval|ceil|floor|round|(mt_)?rand|gmp_fact)'; 
            $operators = '[\/*\^\+-,]'; // Allowed math operators
            $regexp = '/^([+-]?('.$number.'|'.$functions.'\s*\((?1)+\)|\((?1)+\))(?:'.$operators.'(?1))?)+$/'; 
        
            if (preg_match($regexp, $equation))
            {
                $equation = preg_replace('!pi|π!', 'pi()', $equation); 
                //echo "$equation\n";
                eval('$result = '.$equation.';');
            }
            else
            {
                $result = false;
            }
            return $result;
        }
 
        echo "<td class=\"".$inputname.$hhid."\" >".calc($datashortcode[$codeinc][0])."</td>";


        //shortcode end


      }


?>