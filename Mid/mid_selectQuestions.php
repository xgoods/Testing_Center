//connects to fronts 'selectQuestions.php'
<?php
    
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/GetBank.php");  
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);     
    
    echo $dbexec;
        
?>
