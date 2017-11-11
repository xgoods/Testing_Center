<?php
    
    $first = 'def cocks(op,a,b):
    if op == "+":
        return a + b
    
    else:
        return -1
    
breast = cocks("-", 3, 3)
    
print(breast)';

        $directions = "if";

        if(strpos($directions, "for loop") !== false){
            $keyword = "for";
        } elseif(strpos($directions, "while loop") !== false){
                $keyword = "while";
            } else{
                   $keyword = 'if';
        }

        $step = explode("$keyword", $first);
        if($keyword == "if"){
            $step = explode("-1", $step[1]); 
        } else{
            $forcheck = explode(PHP_EOL,$step[1]);
        }

        if($keyword !== "if"){
            
            for($i = 0;$i < sizeof($forcheck);$i++){
                if(preg_match("    ",$forcheck[$i])){
                    if(!preg_match("     ",$forcheck[$i])){
                        $forcheck[0] = $forcheck[$i];
                        break;
                    }
                }
            } 
            if (preg_match('/[A-Za-z0-9]+/',$forcheck[0])) {
                 $step = explode("$forcheck[0]", $step[1]);
                 $result = "    $keyword$step[0]";
            } else{
                 $result = "    $keyword$step[1]";
            }
        } else{
            $result = "    if$step[0]-1";
        }
     echo "$result\n";    
?>
