<?php
    
    $contents = file_get_contents('php://input');
    
    //connects to brians 'selectQuestions.php'
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/CreateExam.php");
    curl_setopt($db, CURLOPT_POST, 1);
    curl_setopt($db, CURLOPT_POSTFIELDS, "$contents");   
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);  

?>
