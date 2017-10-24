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
   	$finalArray = implode(' ',$an);
   	
   	print_r($finalArray);
   	
   	
    //print_r($_post$examName;
    
