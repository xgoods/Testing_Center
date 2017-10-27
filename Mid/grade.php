<?php
    
    $i = 0; 
    //$grade = $_POST['grade'];
    $grade = 0;
    //assign student input to array
    //$data = $_POST['array'];
    $data = "student1,0,def test1(,c,def test3(,c";
    $temparr = explode(",", $data);
    $arr = array($temparr[2], $temparr[3], $temparr[4], $temparr[5]);
    
    //TEMPORARY VARIABLES
    $sampleinput = 'print("3")';
    $samplemethod = 'def test1(1,2,3):';
    $requiredoutput = 3;
    
    //get array of rules from db
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/GetGradingRubric.php");  
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);
    //FIGURE OUT DEF
    $rules = json_decode($dbexec);
    $first = "def {$rules->{'0'}}(";
    $second = "def {$rules->{'1'}}(";
    $third = "def {$rules->{'2'}}(";
    $fourth = "def {$rules->{'3'}}(";
    $rulearray = array($first, $second, $third, $fourth);

    //ARGUMENT VARIABLES HERE
    
    //check for properly implemented func - '5 points max per q'
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
        } else if(`python test.py` == $requiredoutput){
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
