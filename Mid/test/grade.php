<?php

    $temparr = explode('~',$_POST['studentinput']); 

    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/GetGradingRubric.php");
    curl_setopt($db, CURLOPT_POST, 1);
    curl_setopt($db, CURLOPT_POSTFIELDS, "eid=$temparr[1]");   
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);     
    $obj = json_decode($dbexec);
        
    $argcount = $obj->{'args'};
    $argcount = explode('~', $argcount);
    $methodname = $obj->{'fname'};
    $methodname = explode('~', $methodname);
    $maxpoints = $obj->{'points'};
    $maxpoints = explode('~', $maxpoints);
    $directions = $obj->{'type'};
    $directions = explode('~',$directions);
    $testcases = $obj->{'testcase'};
    $testcases = explode('~',$testcases);
    $expectedoutput = $obj->{'output'};
    $expectedoutput = explode('~',$expectedoutput);    
    
    $grade = $i = $y = $k = 0;
    $x = 2;  
    $errors = array();
    $arr = array();
    $testresults = array();

    while($temparr[$x] !== null){
        $arr[$y] = $temparr[$x]; 
        $x += 1;
        $y += 1;
    }   
      
    while(list($key, $studentCode) = each($arr)){
        $n = $i + 1;          
        $points = $maxpoints[$i]/5;
          
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
    	   if(strpos($studentCode, '):') === false){
    	       $size = 0;
    	   } else{
                   $size = sizeof($argues);
                  }
                   $two = "> (-$points points) Number of arguments expected: $argcount[$i] | Given: $size in #$n";
                   array_push($errors, $two);

         }
        //***check for necessary methods
      	if($directions[$i] == "forLoop"){
          if(strpos($studentCode, "for")){
              $grade += $points;
          } else{
              $five = "> (-$points points) For loop not included within answer #$n";
              array_push($errors, $five);
          }
      } elseif($directions[$i] == "whileLoop"){
          if(strpos($studentCode, "while")){
              $grade += $points;
          } else{
              $five = "> (-$points points) While loop not included within answer #$n";
              array_push($errors, $five);
          }
      } elseif($directions[$i] == 'ifElse'){
          if(strpos($studentCode, 'else')){
              $grade += $points;
          } else{
              $five = "> (-$points points) If/else not included within answer #$n";
              array_push($errors, $five);
          }
      } 
        //***testcase execution
	      $dubpoints = $points * 2;        
        while(strpos($testcases[$k], "$methodname[$i]") !== false){
            $temp = $testcases[$k];
            
            if($check == "yes"){
            $temp = str_replace($methodname[$i],$method[0],$testcases[$k]);
            }
            
            $studenttest = "$arr[$i]\noutput = $temp\nprint(output)";
            file_put_contents('test.py', $studenttest);
            $studentout = `python test.py`;
            $studentout = str_replace("\n","",$studentout);
            if($studentout == null){
                $studentout = "n/a";
            }
            if("$studentout" == "$expectedoutput[$k]"){
                $testout = "> $testcases[$k] -> Expected output: $expectedoutput[$k] | Result: $studentout -> correct";
                array_push($testresults, $testout);
            } else{
                $testout = "> $testcases[$k] -> Expected output: $expectedoutput[$k] | Result: $studentout -> incorrect";
                array_push($testresults, $testout);
            }
            $k += 1; 
        }
        //***check for proper execution/return value
        $testimplode = implode('~', $testresults);
        exec('python test.py', $output, $return); 
        if($return){
            $three = "> (-$dubpoints points) Unable to execute code in answer #$n";
            array_push($errors, $three);
        } else if(strpos($testresults, "incorrect") === false){
            $grade += $dubpoints;
        } else{
            $four = "> (-$points points) Expected output: $expectedoutput[$i] | Given: $studentout #$n";
            array_push($errors, $four);
            $grade += $points;
        } 
         //send data to backend per question
         $studentinput = implode('~',$arr);
         $errors = implode("~", $errors);
         $data = array('uid'=>$temparr[0],
                      'eid'=>$temparr[1],
                      'grade'=>$grade,
    		              'errors'=>$errors,
    		              'studentinput'=>$studentinput,
                      'tcdata'=>$testimplode,
                      'questionid'=>$n);
                  
         $data = http_build_query($data);
         $data = urldecode($data); 
         echo "$testimplode\n";
         //reset values
         $errors = array();
         $testresults = array();
         $argues = array();
         $i += 1; 
         
         //curl to db
         $ch = curl_init(); 
         curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ad379/SetStudentGrade.php");
         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS, "$data");   
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         $gradecurl = curl_exec($ch); 
         curl_close($ch); 
    }
    
?> 
