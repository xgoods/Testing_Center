<html>
<link rel="stylesheet" href="css/style.css">
</html>
<?php
    $examArray = array();
    array_push($examArray, $_POST['userName']);
   	array_push($examArray, $_POST['examName']);
   	
   	$an = array_merge($examArray, $_POST['count']);
    //echo "Exam Submitted.";
   	$finalArray = implode('~',$an);
    //$finalArray=urlencode($finalArray);
   	print_r($finalArray);
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~kl297/test.txt");  
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db); 
    
    //replace $briansarray, its the array with uid,eid,and student answers;
    $briansarray = array("student1","0","if","while","if","for");
    $briansarray = implode('~',$briansarray);
    
    file_put_contents('test.php',$dbexec);
    $output = shell_exec("php test.php '$finalArray'");
  	//  echo "$output\n";

   	
    
   	
   	$url2 = "https://web.njit.edu/~kl297/web/grade.php";
   	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url2);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentinput=$finalArray");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $hello = curl_exec($ch);
    curl_close($ch);
    
    //echo "<div class='login-card'>";
    
    echo "<h2 style='color:white'>Exam Submitted.</h2>";
    echo "<form name='backLogin' action='studentHome.php'>
            <input class = 'teacherBtn' type='submit' name='submit' id='submit' value='Back to Menu'>
          </form>"
    //echo "</div>";
    
   
?>
