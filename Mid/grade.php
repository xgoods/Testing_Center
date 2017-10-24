<?php
    
    $grade = 0;
    $arr = array($_POST["inputone"],$_POST["inputtwo"],$_POST["inputthree"],$_POST["inputfour"]);
    $contents = file_get_contents('php://input');
    
    //get array of rules from db
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/GetGradingRubric.php");  
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);
    
    $rules = json_decode($dbexec);
    $first = $rules->{'0'}; 
    $second = $rules->{'1'};
    $third = $rules->{'2'};
    $fourth = $rules->{'3'};

    while (list($key, $studentCode) = each($arr)) {
        //execute java grader
        $temp = exec("java grade '$studentCode' '$first' '$second' '$third' '$fourth'");
        $grade = $grade + $temp;
    }
    
    //send to backend
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "grade database");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grade=$grade");   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $gradecurl = curl_exec($ch); 
    curl_close($ch);
    
    //echo "$grade\n";

?>
