<?php
    
    $grade = $i = $y = 0;
    $x = 2;
    $argcount = array("2","2","3");
    $maxpoints = array(20,30,15); 
    $methodname = array("compare","compare","compare"); 
    $temparr = urldecode($_POST['studentinput']);
    $temparr = explode('~',$temparr); 
    //$answers = explode("~",$_POST['results']);
    $testcases = array("compare(1,2)","compare(3,2)","compare(1,4)");
    $expectedoutput = array("-1","true","-1");
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
        $step = explode("$method[0]", $step[0]);
        preg_match('#\((.*?)\)#', $step[1], $parenth);
        $argues = explode(",", $parenth[1]);
        
        //***check for properly written func name 
        if(strpos($studentCode, "def $methodname[$i]") === false){
            $one = "> (-$points points) Expected function name: '$methodname[$i]' | Given: '$method[0]' in answer #$n";
            $check = "yes";
            array_push($errors, $one);
        } else{
            $grade += $points;
	
        }
         //***check for correct number of arguments 
         if(sizeof($argues) == $argcount[$i] && strpos($studentCode, '):') !== false){
            $grade += $points;
		
         } else{
            $size = sizeof($argues);
            $two = "> (-$points points) Number of arguments expected: $argcount[$i] | Given: $size in #$n";
            array_push($errors, $two);

         }
 
        //***check for successful execution/return value
	      $dubpoints = $points * 2;        
        if($check == "yes"){
            $testcases[$i] = str_replace($methodname[$i],$method[0],$testcases[$i]);
        }
        $studenttest = "$arr[$i]\noutput = $testcases[$i]\nprint(output)";
        file_put_contents('test.py', $studenttest);
        $studentout = `python test.py`;
        $studentout = str_replace("\n","",$studentout);
        
        exec('python test.py', $output, $return); 
        if($return){
            $three = "> (-$dubpoints points) Unable to execute code in answer #$n";
            array_push($errors, $three);
        } else if($studentout == $expectedoutput[$i]){
            $grade += $dubpoints;
        } else{
            $four = "> (-$points points) Expected output: $expectedoutput[$i] | Given: $studentout #$n";
            array_push($errors, $four);
            $grade += $points;
        } 
         //reset values
         $argues = array();
         $i += 1; 
    }
    //send to backend
    $studentinput = implode('~',$arr);
    $errors = implode("~", $errors);
    $data = array('uid'=>$temparr[0],
                  'eid'=>$temparr[1],
                  'grade'=>$grade,
		              'errors'=>$errors,
		              'studentinput'=>$studentinput);
              
    $data = http_build_query($data);
    $data = urldecode($data); 
  /*  $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ad379/SetStudentGrade.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "$data");   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $gradecurl = curl_exec($ch); 
    curl_close($ch); */
    
    echo "$errors\n";   
    
?> 
