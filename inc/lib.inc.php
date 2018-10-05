<?php
// Функция перехвата ошибок
function myError($errno, $errmsg, $errfile, $errline){
  if($errno==E_USER_ERROR){
    echo "Полный ахтунг";
  };
  //echo $errno, $errmsg, $errfile, $errline;
  $s = date("d-m-Y H:i:s")." - $errmsg в $errfile: $errline";
  error_log("$s\n",3,"error.log");
	// Логгируем пользовательские ошибки
	// switch ($errno) {
	  // case E_USER_ERROR:
	  // case E_USER_WARNING:
	  // case E_USER_NOTICE:
		// error_log("$errmsg\n", 3, "error.log");
   // }

}


function drawMenu($Menu,$Vertical = true){
       if(!is_array($Menu)) {
         return false;
       }
          $Style = "";
          if (!$Vertical)
            {
              $Style = " style='display:inline; margin-right:25px'";
            }
          echo '<ul>';
          foreach($Menu as $key)
             {
              echo "<li".$Style."><a href=".$key[href].">".$key[about]."</a> </li>";
             }
           echo "</ul>";   
       return true;           
        }

function drawTable ($row, $cols, $color = "red"){
     echo "<table border='1' width='200'>";   
    $i=1; 
    while($i<=$row)
      { echo "<tr>\n"; 
        $j=1;
        while($j<=$cols)
         {  
          if ($i==1 or $j==1){
          echo "<td style='background:" . $color . "'> <center> <strong>".$i*$j."</strong> </center> </td>\n";
                             }
         else echo "<td>".$i*$j."</td>\n";
           $j++;
         }
         $i++;
       echo "</tr>\n"; 
      }  
     echo "</table>"; 
   }        
?>