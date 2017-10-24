<?php
    session_start();
    if(isset($_SESSION['user'])){
    }
    else{
        header("Location:https://web.njit.edu/~bg245/");
        exit;
    }
   
?>
<?php	
	
	
	$examName = $_POST['examSelect'];
	$userName = $_SESSION['user'];
	
	$url = "https://web.njit.edu/~ad379/GetExam.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $examName);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $takeExam = curl_exec($ch);
    $examArray = array();
    curl_close($ch);
    $questionArray = json_decode($takeExam, true);
    echo "<h1>EXAM $examName</h1>";
    echo "<form name='takeExam' id='takeExam' method='post' action='takeExam.php'";
   	echo "<h1>EXAM $examName</h1>";
    //$examName = $_POST['examSelect'];
    foreach($questionArray as $question) {
    echo "<p>".$question."</p>";
    
    echo "Answer: <textarea name='count[]' rows=20 cols=80></textarea>";
	}
   	//print_r($examName);
   	
   	echo "<input type='radio' name='examName' value='$examName' checked hidden>";
   	echo "<input type='radio' name='userName' value='$userName' checked hidden>";
   	echo "<p>";
   	echo "<input type='submit' name='submit' value='Submit'>";
   	echo "</p>";
   	array_push($examArray, $_POST['userName']);
   	array_push($examArray, $_POST['examName']);
   	
   	$an = array_merge($examArray, $_POST['count']);
    
    echo "</form>";
   	//$finalArray = implode(' ',$an);  */
    $finalArray = "student1 0 test1 x x x";
    
    
    $grade = 0;
    //assign student input to array
    $temparr = explode(" ", $finalArray);
    $arr = array($temparr[2],$temparr[3],$temparr[4],$temparr[5]);
    
    //get array of rules from db
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/GetGradingRubric.php");  
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);
    
    $rules = json_decode($dbexec);
    $first = $rules->{'0'}; 
    $second = $rules->{'1'};
    $third = $rules->{'2'};
    $fourth = $rules->{'3'};
    
    while (list($key, $studentCode) = each($arr)) {
        //execute java grader
        $temp = exec("java grade '$studentCode' '$first' '$second' '$third' '$fourth'");
        $grade = $grade + $temp;
    }
    
    //send to backend
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~kl297/grade.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "uid=$temparr[0]&eid=$temparr[1]&grade=$grade");   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $gradecurl = curl_exec($ch); 
    curl_close($ch);
    

?>
