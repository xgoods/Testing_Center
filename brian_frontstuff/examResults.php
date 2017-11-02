<?php
    session_start();
    if(isset($_SESSION['user'])){
    }
    else{
        header("Location:https://web.njit.edu/~bg245");
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
	    <h1>View Exam Results</h1>
       
        <h2>Select an exam:</h2>
        
    </head>
    <body>
        <p>
            Select an exam:
        </p>
    </body>
</html>

<?php

    $userName = $_SESSION['user'];
    $post = "user=".$userName;
    $url = "https://web.njit.edu/~ad379/ListStudentExams.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $releaseExam = curl_exec($ch);
    curl_close($ch);
    $examArray = json_decode($releaseExam, true);
    $sendBack = array();
    //echo $response;
    
    echo "<form name='selectExam' method='post' action='examResults.php'>";
    foreach($examArray as $exam) {
    	$value = array_search($exam, $examArray);
    	echo $value;
        echo "<input type='radio' name='examName' value='$value'>".$exam."<br>";
    }
    echo "<p>";
    echo "<input type='submit' name='submit' value='View'>";
    echo "</p>";
    echo "</form>";
    echo "<form name='backLogin' action='studentHome.php'>
            <input type='submit' name='submit' id='submit' value='Back to Menu'>
          </form>";
	array_push($sendBack,$userName);
	$value = $_POST['examName'];
	array_push($sendBack,$value);
	$an = implode(' ',$sendBack);

	//print_r($an);
	
	$url = "https://web.njit.edu/~ad379/ListStudentGrades.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $an);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $releaseExam = curl_exec($ch);
    curl_close($ch);
    $questionArray = json_decode($releaseExam, true);
    print_r($questionArray);
	
?>

