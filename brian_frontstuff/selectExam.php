
<?php
/*
    session_start();
    if(isset($_SESSION['user'])){
    }
    else{
        header("Location:https://web.njit.edu/~bg245/");
        exit;
    }
    */
?>

<!DOCTYPE html>
<html>
    <head>
	   <h1>Select Exam</h1>
    </head>
    <body>
        <p>
            Select an exam:
        </p>
    </body>
</html>

<?php
    $url = "https://web.njit.edu/~ad379/ListStudentExams.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $examExec = curl_exec($ch);
    curl_close($ch);
    $examArray = json_decode($examExec, true);
    
    echo "<form name='examSelect' method='post' action='takeExam.php'>";
    foreach($examArray as $exam) {
    	$value = array_search($exam, $examArray);
    	echo $value;
        echo "<input type='radio' name='examSelect' id='examSelect' value='$value'>".$exam."<br>";
    }
    echo "<p>";
    echo "<input type='submit' name='submit' value='Submit'>";
    echo "</p>";
    echo "</form>";
    
    //if (isset($_POST['examSelect'])) {
   	$value = $_POST['examSelect'];
    //}
    //$post = array('examNum'=>$value);
    echo $value;
    //$test = 2;
    $url = "https://web.njit.edu/~ad379/GetExam.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $value);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $getQuestions = curl_exec($ch);
    curl_close($ch);
  	//echo $getQuestions;
    $questionArray = json_decode($getQuestions, true);
    
    print_r($questionArray);
    
?>
