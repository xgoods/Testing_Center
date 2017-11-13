<?php
    
    $grade = $i = 0;
    $givenArgCount = 3;
    //**GET IMPLODED ARRAY $maxpoints = $_POST['points'];
    $maxpoints = explode('~',$_POST['points']);
    //assign student input to array
    $data = $_POST['code'];
    $temparr = explode("~", $data);
    $data = $_POST['answers'];
    $answers = explode("~",$data);
    $arr = array($temparr[2], $temparr[3], $temparr[4], $temparr[5]);
    $errors = array();
    
    //get array of rules from db
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/GetGradingRubric.php");  
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);
      
    while(list($key, $studentCode) = each($arr)){
        $n = $i + 1;          
        $points = $maxpoints[$i]/4;
           
        //get parameters from actual method call
        $step = explode("def ", $studentCode);
        $methodname = explode("(", $step[1]); 
        $step = explode(":", $studentCode);
        $step = explode("$methodname[0]", $step[1]);
        preg_match('#\((.*?)\)#', $step[1], $parenth);
        $argues = explode(",", $parenth[1]);
        //***check for properly written func name 
        if(strpos($studentCode, "def $methodname[0]") === false){
            $one = "> (-$points points) Did not name the function '$methodname[0]' in answer #$n";
            array_push($errors, $one);
        } else{
            $grade += $points;
        }
         //***check for correct number of arguments 
         if(sizeof($argues) == $givenArgCount){
            $grade += $points;
         } else{
            $two = "> (-$points points) Incorrect number of arguments in answer #$n";
            array_push($errors, $two);
         }
        //***check for successful execution/return value         
        if($answers[$i] == 'null'){
            $dubpoints = $points * 2;
            $three = "> (-$dubpoints points) Unable to execute code in answer #$n";
            array_push($errors, $three);
        } else if($answers[$i] == 'perf'){
            $grade += $dubpoints;
        } else{
            $four = "> (-$points points) Incorrect output in answer #$n";
            array_push($errors, $four);
            $grade += $points;
        } 
         //reset values
         $argues = array();
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
