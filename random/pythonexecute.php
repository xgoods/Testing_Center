<?php
    
    $data = "student1,0,def test1(,c,def test3(,c";
    $temparr = explode(",", $data);
    $arr = array($temparr[2], $temparr[3], $temparr[4], $temparr[5]);
    
    //TEMP VARIABLES
    $sampleinput = 'print("3")';
    $requiredoutput = 3;
    
    //checks for proper execution / result
    $grade = 0;
    while (list($key, $studentCode) = each($arr)) {
          file_put_contents ('test.py', $sampleinput);
          if(`python test.py` == null){
              //do nothing
          } else if(`python test.py` == $requiredoutput){
              $grade += 10;
          }else{
              $grade += 5;
          }    
      }
            
    /*$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~kl297/grade.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grade=$grade");  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $gradecurl = curl_exec($ch); 
    curl_close($ch);*/
    
    echo "$grade\n";
    
?>
\

<?php
  
    $arguments = array(1, 2, 3, 4);
    $temparray = array("0", "0", "0", "0");
    
    $hey = 0;
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~kl297/test2.php");  
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);
    
    
    for ($i = 0; $i < 4; $i++) {
    $breast[$i] = $dbexec;
            for ($x = 0; $x < 2; $x++) {
            $j = $x + 1;
            $temparray[$i] = str_replace("var$j",$arguments[$x],$temparray[$i]);
        } 
           echo "$temparray[$i]\n";
    } 

?> 
