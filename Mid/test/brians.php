<?php

    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~kl297/test.txt");  
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db); 
    
    //replace $briansarray, its the array with uid,eid,and student answers
    $briansarray = implode('~',$briansarray);
    
    file_put_contents('test.php',$dbexec);
    $output = shell_exec("php test.php $briansarray");

  //  echo "$output\n";

?>
