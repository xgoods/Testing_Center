<?php
    
    //$grade = $_POST['grade'];
    $grade = $i = 0;
    $givenArgCount = 3;
    //assign student input to array
    //$data = $_POST['array'];
    $data = "student1~0~def test1(~c~test3~c";
    $temparr = explode("~", $data);
    $arr = array($temparr[2], $temparr[3], $temparr[4], $temparr[5]);
    $errors = array();
    $reqarray = array(); //will hold stored equations
    
    //TEMPORARY VARIABLES
    $sampleinput = 'print("5")';
    $sampleCode = 'def test1(one,two,three): test1(9,3,5); return';
    
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
      
    while(list($key, $studentCode) = each($arr)){
        $n = $i + 1;
        file_put_contents ('test.py', $sampleinput);//$studentCode
        
        //***check for properly written func name - '5 points'
        if(strpos($studentCode, "def $rulearray[$i](") === false){
            $one = "> (-5 points) Did not name the function '$rulearray[$i]' in answer #$n";
            array_push($errors, $one);
        } else{
            $grade += 5;
        }
        //***check for correct number of arguments - '5 points'
        if(`python test.py` !== null){
           /* $stepone = explode("def", $sampleCode);//$studentCode
            $steptwo = explode(":", $stepone[1]);
            preg_match('#\((.*?)\)#', $steptwo[0], $parenthesis);
            $arguments = explode(",", $parenthesis[1]);   */
            
            //get parameters from actual method call
            $step = explode("def ", $sampleCode);
            $methodname = explode("(", $step[1]); 
            $step = explode(":", $sampleCode);
            $step = explode("$methodname[0]", $step[1]);
            preg_match('#\((.*?)\)#', $step[1], $parenth);
            $argues = explode(",", $parenth[1]); 
        }       
         if(sizeof($argues) == $givenArgCount){
            $grade += 5;
         } else{
            $two = "> (-5 points) Incorrect number of arguments in answer #$n";
            array_push($errors, $two);
         }
        //***check for successful execution/return value - '10 points max per q'
         $test = "var1+var2<var3"; //temp var, will be stored equation
         $test= str_replace(" ","",$test);
         $reqarray[$i] = $test;
        
         for($x = 0; $x < $givenArgCount; $x++){
            $j = $x + 1;
            $reqarray[$i] = str_replace("var$j",$argues[$x],$reqarray[$i]);
        }
        //$lol = implode(' ',$reqarray[$i]);
         for($g = 2; $g <= $givenArgCount; $g++){
                if(preg_match('/(\d+)(?:\s*)([\+\-\*\^\<\>\/])(?:\s*)(\d+)/', $reqarray[$i], $match) !== FALSE){
                switch($match[2]){
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
                    case '<':
                        if($match[1]<$match[3]){
                            $op = $match[1]-0;
                            "$match[1]<$match[3]";
                        } else{
                            $op = $match[3]-0;
                            $str = "$match[1]<$match[3]";
                        }
                        break;
                    case '>':
                        if($match[1]>$match[3]){
                            $op = $match[1]-0;
                            $str = "$match[1]>$match[3]";
                        } else{
                            $op = $match[3]-0;
                            $str = "$match[1]>$match[3]";
                        }
                        break;
                    }
                    $replace = str_replace($str,$op,$reqarray[$i]);
                    $reqarray[$i] = $replace;
                    }
            }      
        if(`python test.py` == null){
            $three = "> (-15 points) Unable to execute '$rulearray[$i]' in answer #$n";
            array_push($errors, $three);
        } else if(`python test.py` == $op){
            $grade += 15;
        } else{
            $four = "> (-8 points) Incorrect output in answer #$n";
            array_push($errors, $four);
            $grade += 7;
        } 
         //reset values
         $argues = array();
         $op = 44.44;
         $i += 1; 
    }
    //100 max
    if($grade > 100){
        $grade = 100;
    }
    
    //send to backend
    $errors = implode("~", $errors);
    //$errors = http_build_query($errors);
    //$errors = urldecode($errors);
    $data = array('uid'=>$temparr[0],
                  'eid'=>$temparr[1],
                  'grade'=>$grade,
                  'size'=>$size);
              
    $data = http_build_query($data); /*
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ad379/SetStudentGrade.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "$data&errors=$errors");   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $gradecurl = curl_exec($ch); 
    curl_close($ch); */ 
    
    echo "$grade\n"; 

?> 
