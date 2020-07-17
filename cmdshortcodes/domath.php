<?php
     /*
      Command Meaning:
      Do simple math via the AC.T command line 
      command:  [math][your equation]
      example: [math][1+2]
     */ 
     $command = "[math]"; //command name
     if(substr($cmdname, 0, strlen($command)) == $command){
        $getcmd = substr($cmdname, strlen($command));
        $datacmd = preg_split('/\h*[][]/', $getcmd, -1, PREG_SPLIT_NO_EMPTY);
        
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

       echo calc($datacmd[0]);


       //shortcode end


     }else{
        $doesnotexist = $cc++;
     }
   

?>

