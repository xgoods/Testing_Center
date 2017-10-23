<?php
    
    $studentCode = $_POST["studentcode"];
    $contents = file_get_contents('php://input');
    
    //get array of rules from db
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~kl297/test/testicurl.php");  
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);
    
    $rules = json_decode($dbexec);
    $first = $rules->{'arg1'}; 
    $second = $rules->{'arg2'};
    $third = $rules->{'arg3'};
    $fourth = $rules->{'arg4'};
    
    //execute java grader
    $grade = exec("java grade '$studentCode' '$first' '$second' '$third' '$fourth'");
    
    //send to backend
    /*$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "grade database");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grade=$grade");   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $gradecurl = curl_exec($ch); 
    curl_close($ch);*/
    
    echo $grade;
    echo "\n";

?>
