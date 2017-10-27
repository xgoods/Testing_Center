<?php
    
    $grade = 0;
    $i = 0; 
    //assign student input to array
    //$data = $_POST['array'];
    $data = "student1,0,test1(,c,test3,c";
    $temparr = explode(",", $data);
    $arr = array($temparr[2], $temparr[3], $temparr[4], $temparr[5]);
    
    $sampleinput = 'print("5")';
    $samplemethod = 'def test1(1,2,3):';
    
    //get array of rules from db
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/GetGradingRubric.php");  
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);
    //FIGURE OUT DEF
    $rules = json_decode($dbexec);
    $first = "{$rules->{'0'}}(";
    $second = "{$rules->{'1'}}(";
    $third = "{$rules->{'2'}}(";
    $fourth = "{$rules->{'3'}}(";
    $rulearray = array($first, $second, $third, $fourth);

    //ARGUMENT VARIABLES HERE
    
    //check for correct function name - '5 points max per q'
    while (list($key, $studentCode) = each($arr)) {
        if(strpos($studentCode, "$rulearray[$i]") === false){
            //do nothing
        } else{
            $grade += 5;
        }
        //$temp = `python grade.py $studentCode $rulearray[$i]`;
        //$grade = $grade + $temp; 
        //echo "$rulearray[$i]\n";
        //echo $temp;
        //check for successful execution/return value - '10 points max per q'
        file_put_contents ('test.py', $sampleinput);
        if(`python test.py` == null){
            //do nothing
        } else if(`python test.py` == 5){
            $grade += 10;
        }else{
            $grade += 5;
        }       
        //check for number of arguments;
        if(strpos($samplemethod, "def $rulearray[$i]") === false || 
           strpos($samplemethod, "):") === false ||
           strpos($samplemethod, "(") === false){
            //do nothing
        } else{
            $stepone = explode("def", $samplemethod);
            $steptwo = explode(":", $stepone[1]);
            preg_match('#\((.*?)\)#', $steptwo[0], $parenthesis);
            $arguments = explode(",", $parenthesis[1]);
            //echo sizeof($arguments);
        }
        $i += 1; 
    }
    
    //100 max
    if($grade > 100){
        $grade = 100;
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
