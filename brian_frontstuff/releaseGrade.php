
<?php
/*
    session_start();
    if(isset($_SESSION['user'])){
    }
    else{
        header("Location:https://web.njit.edu/~bg245/login.html");
        exit;
    }
*/
?>

<!DOCTYPE html>
<html>
    <head>
	    <h1>View Exams</h1>
        <h2>Select an exam:</h2>
    </head>
    <body>
        <p>
            Select an exam to release your grade:
        </p>
    </body>
</html>

<?php
    $userName = $_SESSION['user'];
    $post = "username=".$userName;
    $url = "https://web.njit.edu/~kl297/mid_releaseGrade.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $releaseExam = curl_exec($ch);
    curl_close($ch);
    $examArray = json_decode($releaseExam, true);
    //echo $response;
    
    echo "<form name='selectExam' method='post' action='sendReleaseGrade.php'>";
    foreach($examArray as $exam)
        echo "<input type='radio' name='examName' value='$exam'>".$exam."<br>";
    echo "<p>";
    echo "<input type='submit' name='submit' value='release'>";
    echo "</p>";
    echo "</form>";
    echo "<form name='backLogin' action='teacherHome.php'>
            <input type='submit' name='submit' id='submit' value='Back to Menu'>
          </form>";
?>
