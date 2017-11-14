<?php

    session_start();
    if(isset($_SESSION['user'])){
    }
    else{
        header("Location:https://web.njit.edu/~bg245/");
        exit;
    }
   
?>
<html>
<link rel="stylesheet" href="css/style.css">
<h1 style="color:white">Take Your Exam</h1>
</html>
<?php	
	
	
	$examName = $_POST['examSelect'];
	$userName = $_SESSION['user'];
	echo $examName;
	$url = "https://web.njit.edu/~kl297/mid_getExam.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $examName);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $takeExam = curl_exec($ch);
    $examArray = array();
    curl_close($ch);
    $questionArray = json_decode($takeExam, true);
    echo "<div class='question-card'>";
    echo "<class='logo' float='left'><img src='img/logo.jpg'>";
    //echo "<h2 align='center'>$examName</h2>";
    echo "<form name='takeExam' id='takeExam' method='post' action='takeExam.php'></br>";
   	
    //$examName = $_POST['examSelect'];
    foreach($questionArray as $question) {
    echo "<p>".$question['question']."</p>";
    
    echo "Answer: <textarea name='count[]' rows=20 cols=80></textarea>";
	}
   	//print_r($examName);
   	
   	echo "<input type='radio' name='examName' value='$examName' checked hidden>";
   	echo "<input type='radio' name='userName' value='$userName' checked hidden>";
   	echo "<p>";
   	echo "<input class='teacherBtn' type='submit' name='submit' value='Submit'>";
   	echo "</p>";
   	array_push($examArray, $_POST['userName']);
   	array_push($examArray, $_POST['examName']);
   	
   	$an = array_merge($examArray, $_POST['count']);
    
    echo "</form>";
   	$finalArray = implode('~',$an);
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
    $output = shell_exec("php test.php $finalArray");
  	//  echo "$output\n";

   	
   	//print_r($finalArray);
   	
   	$url2 = "https://web.njit.edu/~kl297/grade.php";
   	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url2);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "array=$finalArray");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $hello = curl_exec($ch);
    curl_close($ch);

?>
