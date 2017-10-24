
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
    $url = "https://web.njit.edu/~ad379/GetExam.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $examExec = curl_exec($ch);
    curl_close($ch);
    $examArray = json_decode($examExec, true);
    
    echo "<form name='examSelect' method='post' action='takeExam.php'>";
    foreach($examArray as $exam)
        echo "<input type='radio' name='examSelect' value='$exam' required>".$exam."<br>";
    echo "<p>";
    echo "<input type='submit' name='submit' value='Submit'>";
    echo "</p>";
    echo "</form>";
?>
