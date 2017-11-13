<?php
    error_reporting(0);
    //trial students code first-fourth
    $first = 'add = [1,2,3,4,5]
def addarray(add):
    total = 0
    for i in range(len(add)):
        total = total + add[i]
    return total
    
output = addarray(add)
print(output)';
    
    $second = 'def test2(one,two,three): test2(9,3,5); return';
    $third = 'def test3(one,two,three): test3(9,3,5); return';
    $fourth = 'def test1(one,two): test1(3,5); return';
    $briansarray = array("student1","0","$first","$second","$third","$fourth");
    
    //trial teachers code
    $teachers = 'add = [1,2,3,4,5]
def addarray(add):
    total = 0
    for i in range(len(add)):
        total = total + add[i]
    return total    
output = addarray(add)
print(output)';
    
    
    $loops = array();
    $vars = array();
    $func = array();
    for($n = 0; $n < sizeof($briansarray)-5; $n++){
        $b = $n + 2;
        
        //check to see necessary loops/statements
        $directions = "for loop";
        if(strpos($directions, "for loop") !== false){
            $separator = "for";
            $keyword = "for";
        } elseif(strpos($directions, "while loop") !== false){
                $separator = "while";
                $keyword = "while";
            } else{
                   $separator = "):";
                   $keyword = "if";
        }
        
        if(strpos($briansarray[$b], "$keyword") !== false){
            for($m = 0; $m < 2; $m++){
                if($m == 0){
                  $temp = $briansarray[$b];
                  } else{
                    $temp = $teachers;
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
               /* $funk = explode("def ", $temp);
                $funk = explode(":", $funk[1]);
                $func[$m] = $funk[0];   */        
            }

            //execute teachers, replace code, then test students code
            file_put_contents('test.py', $teachers);
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


           // $studenttest = str_replace("$func[1]","$func[0]",$teachers);
            $studenttest = str_replace("$loops[1]","$loops[0]",$teachers);
            file_put_contents('test.py', $studenttest);
            exec('python test.py', $output, $return);
              if($return){
                $results[$n] = 'null';
                $studentop = `python test.py`;
              } elseif(`python test.py` == $teacherop){
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
        echo "$loops[1]\n";
        //echo "$studenttest\n";   
      //  echo "$loops[1]\n";
} 
     
?>
