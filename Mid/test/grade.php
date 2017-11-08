<?php
    
    $grade = $i = 0;
    $givenArgCount = 3;
    //**GET IMPLODED ARRAY $maxpoints = $_POST['points'];
    $maxpoints = array("25","1","1","1");
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
        $points = $maxpoints[$i]/4;
        //***check for properly written func name 
        if(strpos($studentCode, "def $rulearray[$i]") === false){
            $one = "> (-$points points) Did not name the function '$rulearray[$i]' in answer #$n";
            array_push($errors, $one);
        } else{
            $grade += $points;
        }
        //***check for correct number of arguments    
        //get parameters from actual method call
        $step = explode("def ", $studentCode);
        $methodname = explode("(", $step[1]); 
        $step = explode(":", $studentCode);
        $step = explode("$methodname[0]", $step[1]);
        preg_match('#\((.*?)\)#', $step[1], $parenth);
        $argues = explode(",", $parenth[1]);
        
         if(sizeof($argues) == $givenArgCount){
            $grade += $points;
         } else{
            $two = "> (-$points points) Incorrect number of arguments in answer #$n";
            array_push($errors, $two);
         }
        //***check for successful execution/return value 
         $op = "var1+var2+var3"; //temp var, will be stored equation'
         if(preg_match('/(\d+)(?:\s*)([\+\-\*\^\<\>\/])(?:\s*)(\d+)/', $argues[0], $mat) !== FALSE &&
            $answers[$i] !== 'null'){
            $argues[0] = str_replace('"','',$argues[0]);
            $op = "$argues[1] $argues[0] $argues[2]";       
          
         $op = str_replace(" ", "", "$op");
         $reqarray[$i] = $op;
        
         for($x = 0; $x < $givenArgCount; $x++){
            $j = $x + 1;
            $reqarray[$i] = str_replace("var$j", "$argues[$x]", "$reqarray[$i]");
        }
         for($x = 1; $x < $givenArgCount; $x++){
                if(preg_match('/(\d+)(?:\s*)([\+\-\&\*\^\<\>\/])(?:\s*)(\d+)/', $reqarray[$i], $match) !== FALSE &&
                  $answers[$i] !== 'null'){
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
                        $op = floor($op);
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
                    case '&':
                        $sort = str_split($match[1]);
                        sort($sort);
                        $op = implode('',$sort);
                        $str = "$match[1]&";
                        break;
                    }
                    $replace = str_replace($str,$op,$reqarray[$i]);
                    $reqarray[$i] = $replace;
                    }
            }
        //hard-code prevention, ensures function call is printed
        $temp = $studentCode;
        $step = explode("def ", $temp);
        $methodname = explode("(", $step[1]); 
        $step = explode("$methodname[0]", $step[1]);
        $last = sizeof($step) - 2;
        $varname = explode("=", $step[$last]); 
        $last = sizeof($varname) - 2;
        $step = explode("\n", $varname[$last]);
        $last = sizeof($step)-1;
        $varname = str_replace(" ","",$step[$last]);
        $check = explode("$methodname[0]", $studentCode);
        $last = sizeof($check)-1;
        $occur = substr_count($check[1], $varname);
        
        if($answers[$i] == 'null'){
            $dubpoints = $points * 2;
            $three = "> (-$dubpoints points) Unable to execute code in answer #$n";
            array_push($errors, $three);
        } else if($answers[$i] == $op && strpos($studentCode, "print("$op")" === false
                 && strpos($studentCode, "return $op") === false && $givenArgCount == sizeof($argues)
                 && $occur < 2 || $answers[$i] == -1.1){
            $grade += $dubpoints;
        } else{
            $four = "> (-$points points) Incorrect output in answer #$n";
            array_push($errors, $four);
            $grade += $points;
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
                  'grade'=>$grade);
              
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
