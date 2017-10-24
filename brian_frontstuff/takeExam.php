<?php	
	
	
	$examName = $_POST['examSelect'];
	
	$url = "https://web.njit.edu/~ad379/GetExam.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $examName);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $takeExam = curl_exec($ch);
    //echo $response;
    curl_close($ch);
    $questionArray = json_decode($takeExam, true);
    
     echo "<form name='takeExam' id='takeExam' method='post' action='sendTakeExam.php'";
    $count=1;
    foreach($questionArray as $question) {
    echo "<p>".$question."</p>";
    echo "Answer: <textarea name='$count' rows=15 cols=75></textarea>";
	$count++;    
   	}
   	echo "<p>";
   	echo "<input type='submit' name='submit' value='Submit'>";
   	echo "</p>";
    echo "</form>";
