<?php
    
    $i = 0; 
    //$grade = $_POST['grade'];
    $grade = 0;
    $givenArgCount = 2;
    //assign student input to array
    //$data = $_POST['array'];
    $data = "student1,0,def test1(,c,def test3(,c";
    $temparr = explode(",", $data);
    $arr = array($temparr[2], $temparr[3], $temparr[4], $temparr[5]);
    $reqarray = array();
    
    //TEMPORARY VARIABLES
    $sampleinput = 'print("5")';
    $samplemethod = 'def test1(2,3):';
    
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
    $rulearray = array($first, $second, $third, $fourth);
    
    //***check for properly written func name - '5 points max per q'
    while (list($key, $studentCode) = each($arr)) {
        if(strpos($studentCode, "$rulearray[$i]") === false){
            //do nothing
        } else{
            $grade += 5;
        }
        //***check for number of arguments
        if(strpos($samplemethod, "def $rulearray[$i](") === false || 
           strpos($samplemethod, "):") === false){
            //do nothing
        } else{
            $stepone = explode("def", $samplemethod);
            $steptwo = explode(":", $stepone[1]);
            preg_match('#\((.*?)\)#', $steptwo[0], $parenthesis);
            $arguments = explode(",", $parenthesis[1]);
        }       
        //***check for successful execution/return value - '10 points max per q'
          $test = "var1+var2"; //temp var, will be stored equation
          $reqarray[$i] = $test;
            for ($x = 0; $x < $givenArgCount; $x++) {
            $j = $x + 1;
            $reqarray[$i] = str_replace("var$j",$arguments[$x],$reqarray[$i]);
        }   
            for ($g = 2; $g <= $givenArgCount; $g++){
                if(preg_match('/(\d+)(?:\s*)([\+\-\*\^\/])(?:\s*)(\d+)/', $reqarray[$i], $match) !== FALSE){
                $operator = $match[2];
                switch($operator){
                    case '+':
                        $op = $match[1]+$match[3];
                        $str = "$match[1]+$match[3]";
                        break;
                    case '-':
                        $op = $match[1]-$match[3];
                        $str = "$match[1]-$match[3]";
                        break;
                    case '*':
                        $op = $match[1]*$match[3];
                        $str = "$match[1]*$match[3]";
                        break;
                    case '/':
                        $op = $match[1]/$match[3];
                        $str = "$match[1]/$match[3]";
                        break;
                    case '^':
                        $op = pow($match[1],$match[3]);
                        $str = "$match[1]^$match[3]";
                        break;
                    }
                    $replace = str_replace($str,$op,$reqarray[$i]);
                    $reqarray[$i] = $replace;
                    }
            }      
        file_put_contents ('test.py', $sampleinput);
        if(`python test.py` == null){
            //do nothing
        } else if(`python test.py` == $op){
            $grade += 10;
        }else{
            $grade += 5;
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
