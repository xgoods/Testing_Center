<?php
    
    $grade = 0; 
    //assign student input to array
    //$data = $_POST['array'];
    $data = "student1 0 test1 test1 c c";
    $temparr = explode(" ", $data);
    $arr = array($temparr[2],$temparr[3],$temparr[4],$temparr[5]);
    
    $sampleinput = 'print("5")';
    
    //get array of rules from db
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/GetGradingRubric.php");  
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);
    
    $rules = json_decode($dbexec);
    $first = "def {$rules->{'0'}}";
    $second = "def {$rules->{'1'}}";
    $third = "def {$rules->{'2'}}";
    $fourth = "def {$rules->{'3'}}";
    
    while (list($key, $studentCode) = each($arr)) {
        //check for correct function name
        $temp = `python grade.py $studentCode $first $second $third $fourth`;
        $grade = $grade + $temp;
    }
    
    //write student's code to 'test.py'
    file_put_contents ('test.py', $sampleinput);

    //check for successful execution/return value
    if(`python test.py` == null){
        //do nothing
    } else if(`python test.py` == 5){
        $grade += 10;
    }else{
        $grade += 5;
    }
    
    if($grade > 25){
        $grade = 25;
    }
    
    //send to backend
   /* $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ad379/SetStudentGrade.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "uid=$temparr[0]&eid=$temparr[1]&grade=$grade");   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $gradecurl = curl_exec($ch); 
    curl_close($ch);*/
   
    echo "$grade\n";

?> 
