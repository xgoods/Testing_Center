<?php
    
    $grade = $i = 0;
    $givenArgCount = 3;
    //assign student input to array
    $data = $_POST['code'];
    $temparr = explode("~", $data);
    $data = $_POST['answers'];
    $answers = explode("~",$data);
    $arr = array($temparr[2], $temparr[3], $temparr[4], $temparr[5]);
    $errors = array();
    $reqarray = array(); //will hold stored equations
    
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
        //***check for properly written func name - '5 points'
        if(strpos($studentCode, "def $rulearray[$i]") === false){
            $one = "> (-5 points) Did not name the function '$rulearray[$i]' in answer #$n";
            array_push($errors, $one);
        } else{
            $grade += 5;
        }
        //***check for correct number of arguments - '5 points'    
        //get parameters from actual method call
        $step = explode("def ", $arr[$i]);
        $methodname = explode("(", $step[1]); 
        $step = explode(":", $arr[$i]);
        $step = explode("$methodname[0]", $step[1]);
        preg_match('#\((.*?)\)#', $step[1], $parenth);
        $argues = explode(",", $parenth[1]);
        
         if(sizeof($argues) == $givenArgCount){
            $grade += 5;
         } else{
            $two = "> (-5 points) Incorrect number of arguments in answer #$n";
            array_push($errors, $two);
         }
        //***check for successful execution/return value - '10 points max per q'
         $test = "var1+var2+var3"; //temp var, will be stored equation
         $test= str_replace(" ","",$test);
         $reqarray[$i] = $test;
        
         for($x = 0; $x < $givenArgCount; $x++){
            $j = $x + 1;
            $reqarray[$i] = str_replace("var$j",$argues[$x],$reqarray[$i]);
        }
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
        if($answers[$i] == 'null'){
            $three = "> (-15 points) Unable to execute code in answer #$n";
            array_push($errors, $three);
        } else if($answers[$i] == $op){
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

    //send to backend
    $errors = implode("~", $errors);
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
    
    echo "$errors\n";
    echo "$grade\n";
    
?> 
