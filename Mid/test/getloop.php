<?php
    error_reporting(0);
   
    $briansarray = explode('~',$argv[1]);   
    
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/GetGradingRubric.php");
    curl_setopt($db, CURLOPT_POST, 1);
    curl_setopt($db, CURLOPT_POSTFIELDS, "eid=$briansarray[1]");   
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);     
    $obj = json_decode($dbexec);
    
    $teachinput = $obj->{'tanswer'};
    $teachinput = explode('~',$teachinput);
    $argcount = $obj->{'args'};
    $funcname = $obj->{'fname'};
    $points = $obj->{'points'};
    $directions = $obj->{'type'};
    $directions = explode('~',$argv[2]);
    
    $loops = array();
    $vars = array();
    for($n = 0; $n < sizeof($briansarray)-2; $n++){
        $b = $n + 2;
        
        //check to see necessary loops/statements
        
        if(strpos($directions[$n], "For Loop") !== false){
            $separator = "for";
            $keyword = "for";
        } elseif(strpos($directions[$n], "While Loop") !== false){
                $separator = "while";
                $keyword = "while";
            } else{
                   $separator = "):";
                   $keyword = "if";
        }
        
        file_put_contents('test.py', $briansarray[$b]);
        exec('python test.py', $output, $return);
        if(strpos($briansarray[$b], "$keyword") !== false && !$return){
            for($m = 0; $m < 2; $m++){
                if($m == 0){
                  $temp = $briansarray[$b];
                  } else{
                    $temp = $teachinput[$n];
                  } 
                //isolate loops/statements
                $step = explode("$separator", $temp); 
                if($separator == '):'){
                    $step = explode("-1", $step[1]); 
                    $forcheck = explode(PHP_EOL,$step[1]);
                } else{
                    $forcheck = explode(PHP_EOL,$step[1]);
                }
                if($separator !== "):"){
                    $studentreplace = $forcheck[0];
                    //check to see if student attempts hardcode
                    for($i = 0;$i < sizeof($forcheck);$i++){     
                        if(preg_match("/^[A-Za-z].*$/i", $forcheck[$i]) 
                           || preg_match("/    /", $forcheck[$i])
                           && preg_match("/([a-z])+$/i", $forcheck[$i])){
                            if(!preg_match('/for|while|if|else|return|     /i', $forcheck[$i])){
                                $replacevar = $forcheck[$i];
                                break;
                            }
                        }
                    } 
                  
                    if (preg_match('/[A-Za-z0-9]+/',$replacevar)) {
                         $step = explode("$replacevar", $step[1]);
                         $loops[$m] = "    $separator$step[0]";
                    } else{
                         $loops[$m] = "    $separator$step[1]";
                    }
                } else{
                    $loops[$m] = "    $step[0]-1";
                    preg_match('/^(\s+)/',$loops[$m],$matches);
                    $identSize = strlen($matches[1]);
                    $identSize = $identSize - 6;
                    $indent = str_repeat(" ", "$identSize");
                    $loops[$m] = str_replace("$indent\n","",$loops[$m]);
                }       
      
            }
            //execute teachers, replace code, then test students code
            file_put_contents('test.py', $teachinput[$n]);
            $teacherop = `python test.py`;    
            if($separator == 'for'){
                $teehee = explode(PHP_EOL,$loops[0]);
                $studentfor = preg_split('/\s+/', $teehee[0]);
                $teacherfor = preg_split('/\s+/', $studentreplace);
                $var[0] = $studentfor[2];
                $var[1] = $studentfor[4];   
                //replace students variables with teachers
                $studvar = "$var[0] in $var[1]";          
                $loops[0] = str_replace(" $studvar","$studentreplace",$loops[0]);
                $loops[0] = str_replace("$var[0]","$teacherfor[1]",$loops[0]);
            }
            $studenttest = str_replace("$loops[1]","$loops[0]",$teachinput[$n]);
           
            file_put_contents('test.py', $studenttest);
            exec('python test.py', $output, $return);
              if(`python test.py` == $teacherop){
                  $results[$n] = 'perf';
                  $studentop = `python test.py`;
              } else{
                  $results[$n] = 'ok';
                  $studentop = `python test.py`;
              }
        } else{
            $results[$n] = 'null';
        }
        $outresult = implode('~',$results);  
      //  echo "$loops[1]\n";
} 
        echo "$outresult\n"; 
        
        $db = curl_init();
        curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~kl297/grade.php");
        curl_setopt($db, CURLOPT_POST, 1);
        curl_setopt($db, CURLOPT_POSTFIELDS, "briansarray=$argv[1]&results=$outresult&points=$points&args=$argcount&funcname=$funcname");   
        curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
        $dbexec = curl_exec($db); 
        curl_close($db);     
        echo $dbexec;
?>
