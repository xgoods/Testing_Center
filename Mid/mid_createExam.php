//connects to fronts 'selectQuestions.php'
<?php
    
    $contents = file_get_contents('php://input');
    
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/backendController.php");
    curl_setopt($db, CURLOPT_POST, 1);
    curl_setopt($db, CURLOPT_POSTFIELDS, "$contents&cmd=createExam");   
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);  

?>
