<?php
    error_reporting(0);
    //trial students code first-fourth
    $first = 'def operation(b,a):
    for dixx in coxrange(3,6):
        return x';
    

    $second = 'def test2(one,two,three): test2(9,3,5); return';
    $third = 'def test3(one,two,three): test3(9,3,5); return';
    $fourth = 'def test1(one,two): test1(3,5); return';
    $briansarray = array("student1","0","$first","$second","$third","$fourth");
    
    //trial teachers code
    $teachers = 'def operation(a,b):
    for x in range(3,6):
        return x
    
ness = operation(1,2)
print(ness)';
    
    

$loops = array();
$vars = array();


for($n = 0; $n < sizeof($briansarray)-5; $n++){
$b = $n + 2;
        
        //check to see necessary loops/statements
        $directions = "for loop";
        if(strpos($directions, "for loop") !== false){
            $keyword = "for";
        } elseif(strpos($directions, "while loop") !== false){
                $keyword = "while";
            } else{
                   $keyword = 'if';
        }
        
        for($m = 0; $m < 2; $m++){
            if($m == 0){
              $temp = $briansarray[$b];
              } else{
                $temp = $teachers;
              } 
            //isolate loops/statements
            $step = explode("$keyword", $temp);  
            
            if($keyword == "if"){
                $step = explode("-1", $step[1]); 
            } else{
                $forcheck = explode(PHP_EOL,$step[1]);
            }
            if($keyword !== "if"){
                $studentreplace = $forcheck[0];
              
                for($i = 0;$i < sizeof($forcheck);$i++){
                    if(preg_match("/^[A-Za-z].*$|    /i", $forcheck[$i])){
                        if(!preg_match('/for|while|if|else|     /i', $forcheck[$i])){
                            $replacevar = $forcheck[$i];
                            break;
                        }
                    }
                }                
                if (preg_match('/[A-Za-z0-9]+/',$replacevar)) {
                     $step = explode("$replacevar", $step[1]);
                     $loops[$m] = "    $keyword$step[0]";
                } else{
                     $loops[$m] = "    $keyword$step[1]";
                }
            } else{
                $loops[$m] = "    if$step[0]-1";
            }
        }
        
        //execute teachers, replace code, then test students code
        file_put_contents('test.py', $teachers);
        $teacherop = `python test.py`;
        
        
        for($m = 0; $m < 2; $m++){
                if($m == 0){
                  $teehee = explode(PHP_EOL,$loops[0]);
                  $toreplace = preg_split('/\s+/', $teehee[0]);
                  $var[0] = $toreplace[2];
                  $var[1] = $toreplace[4];   
                } else{
                    //replace students variables with teachers
                    $studvar = "$var[0] in $var[1]";          
                    $loops[0] = str_replace(" $studvar","$studentreplace",$loops[0]);
                }
        }
        $studenttest = str_replace("$loops[0]","$loops[1]",$teachers);
        file_put_contents('test.py', $studenttest);
          if(`python test.py` == null){
            $studentop = "fuck u m8";
          } else{
            $studentop = `python test.py`;
          }
         
        echo "$teacherop\n";   
        echo "$studentop\n";
} 
     
?>