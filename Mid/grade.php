<?php
    
    $studentCode = $_POST['studentinput]';
    $contents = file_get_contents('php://input');
    
    //get array of rules from db
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "rule database");
    curl_setopt($db, CURLOPT_POST, 1);
    curl_setopt($db, CURLOPT_POSTFIELDS, "$contents");   
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);
    
    //execute java grader
    $grade = exec("java grade '$studentCode' '$dbexec'");
    
    //send to backend
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "grade database");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grade=$grade");   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $gradecurl = curl_exec($ch); 
    curl_close($ch);
    
    //echo $grade;
    //echo "\n";

?>
