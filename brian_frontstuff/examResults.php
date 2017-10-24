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
    $url = "https://web.njit.edu/~ad379/GetGrade.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    $resultArray = json_decode($response, true);
    //echo $response;
    
    echo "<form name='examSelect' method='post' action='sendResults.php'>";
    foreach($resultArray as $value)
        echo "<input type='radio' name='examName' value='$value'>".$value."<br>";
    echo "<p>";
    echo "<input type='submit' name='submit' value='Submit'>";
    echo "</p>";
    echo "</form>";
?>

<?php
    //session_destroy();
?>
