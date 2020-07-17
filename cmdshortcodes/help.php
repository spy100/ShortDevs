<?php
     /*
      Command Meaning:
      Get list of all commands and help information
      command:  [help]
     */ 
     $command = "[help]"; //command name
     if(substr($cmdname, 0, strlen($command)) == $command){
        $getcmd = substr($cmdname, strlen($command));
        $datacmd = preg_split('/\h*[][]/', $getcmd, -1, PREG_SPLIT_NO_EMPTY);
        
        echo "<h2>About ShortDevs</h2><br>";
        echo "<ul><li>";
        echo "
             
        Shortdevs is a tool created with html / css / php / mysql / js and jquery.<br><br>
        
        Shordevs allows the user to collect, manipulate, share data on the web and it simplifies work.<br><br>
        
        Shortdevs allows a non-programmer to create anything that he can imagine with the help of shortcodes and tables.<br><br>
        
        In Shortdevs a table is called a \"page\" or as \"superpage\".<br><br>
        
        Pages are private, only the json data for the pages can be shared on the web.<br><br>
        
        Superpages can be shared public or stay private,and they can be catalogs, websites,business cards,web pages, forms, charts, inventories,newspapers, games, CADs, electronic circuits, directories or anything that the user will create.<br><br>
        
        Programmers / Developers can create an unknown number of shortcodes for the users of Shortdevs.<br><br>
        
        A shortcode can be anything that a programmer can imagine. ( A calculator, a shortcode to solve a math problem, a convertor, something that parses data, a form that collects data for the user on a superpage, a chart, a html element etc.)<br><br>
        
        Shortdevs is the universe of shortcodes and tables.<br><br>
        
        ShortDevs is a tool with many uses created by © Alin C. Tanase in 2020.<br>


        ";
        echo "</li><ul><br><br>";

        echo "<h2>Some basic short codes to get you started:</h2><br><br>";
        echo "<h2>Page Form Shortcodes :</h2><br><br>";
        echo "<ul>";
        echo "<li><h4>Add Json Data Inside Page Form Inputs</h4>[json][data label][key]</li><br>";
        echo "<li><h4>Add cell \"x\" From Page A to Page B cell \"y\" or add cell \"x\" From Page A to Page A cell \"y\": </h4>[page][page name][id][column label name]</li><br>";
        echo "<li><h4>Add a youtube video inside a cell:</h4> [youtube][youtube video string][width][height]</li><br>";
        echo "<li><h4>Make math operations in the page form input:</h4>[math][ex:10+5]</li><br>"; 
        echo "<li><h4>Wrap text inside a cell (so it goes down to next line if text to long):</h4> [wrap][your very long text here]</li>";
        echo "</ul>";
         
        echo "<br><h2>Page Command Line Shortcodes :</h2><br>";
        echo "<ul>";
        echo "<li><h4>Get the sum of all cells in a column for this page</h4>[sumcolumn][this][column name]</li><br>";
        echo "<li><h4>List of basic commands,basic page input shortcodes and help information: </h4>[help]</li><br>";
        echo "<li><h4>Get the sum of specific cells for this page: </h4>[sumcells][this][id][column name][id][column name][id][column name]</li><br>";  
        echo "<li><h4>Find cells with same value in this page: </h4>[samevalue][this][id][column name][highlight background color]</li><br>";
        echo "<li><h4>Make math operations via the command line:</h4>[math][ex:10+5]</li><br>"; 
        echo "</ul>";      
           
    
        

     
     }else{
        $doesnotexist = $cc++;
     }
   

?>