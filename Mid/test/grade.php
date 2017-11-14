<?php
    
    $grade = $i = $y = 0;
    $x = 2;
    $givenArgCount = explode('~',$_POST['args']);
    $maxpoints = explode('~',$_POST['points']); 
    $methodname = explode('~',$_POST['funcname']); 
    $temparr = explode("~", $_POST['briansarray']);
    $answers = explode("~",$_POST['results']);
    $errors = array();
    $arr = array();
    
    while($temparr[$x] !== null){
        $arr[$y] = $temparr[$x]; 
        $x += 1;
        $y += 1;
    }   
      
    while(list($key, $studentCode) = each($arr)){
        $n = $i + 1;          
        $points = $maxpoints[$i]/4;
           
        //get parameters from actual method call
        $step = explode("def ", $studentCode);
        $method = explode("(", $step[1]); 
        $step = explode(":", $studentCode);
        $step = explode("$method[0]", $step[1]);
        preg_match('#\((.*?)\)#', $step[1], $parenth);
        $argues = explode(",", $parenth[1]);
        //***check for properly written func name 
        if(strpos($studentCode, "def $methodname[$i]") === false){
            $one = "> (-$points points) Did not name the function '$methodname[$i]' in answer #$n";
            array_push($errors, $one);
        } else{
            $grade += $points;
        }
         //***check for correct number of arguments 
         if(sizeof($argues) == $givenArgCount[$i]){
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
              
    $data = http_build_query($data); 
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ad379/SetStudentGrade.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "$data&errors=$errors");   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $gradecurl = curl_exec($ch); 
    curl_close($ch); 
    
    /*echo "$errors\n";
    echo "$grade\n";  */
    
?> 
