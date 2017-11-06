<?php
session_start();
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        if ($user=="teacher1"){}
        else{
            header("Location:index.html");
            exit;
        }
    }
    else{
        header("Location:index.html");
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Grades</title>
        <meta http-equiv="Content-type" content="text/html"; charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    
    <body>
        <div class="header">Teacher's Platform</div>
        
        <div class="sidebar bar-block animate-left" style="display:none;z-index:5" id="sidebar">
            <button class="bar-item buttonBar large" style="color: rgba(79, 80, 73, 1); background-color: rgba(1, 55, 6, 0.24);" onclick="bar_close()">Close &times;
            </button>
            <a href="teacher.php" class="bar-item buttonBar">Home</a>
            <a href="createexam.php" class="bar-item buttonBar">Create Exams</a>
            <a href="addquest.php" class="bar-item buttonBar">Add Questions</a>
            <a href="index.html" class="bar-item buttonBar">Log out</a>
        </div>

        <div class="overlay animate-opacity" onclick="bar_close()" style="cursor:pointer" id="overlay">
        </div>
 
        <div> 
            <button class=" buttonBar btnLay xxlarge" onclick="bar_open()">&#9776;
            </button>
        </div>

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
    
    echo "<form name='selectExam' method='post' action='gradesT.php'>";
    echo "<select name='exam' id='exam'>";
    echo "<option selected='selected'></option>";

    foreach($examArray as $exam){
        $value = array_search($exam, $eexamArray);
        echo "<option value='$value'>$exam</option>";
    }

    echo "</select>";
    echo "<input type='submit' name='submit' value='release'>";
    echo "</form>";

	$theExam = $_POST['exam'];
	print_r($theExam);
    
	$url = "https://web.njit.edu/~ad379/ReleaseExams.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $theExam);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $getQuestions = curl_exec($ch);
    curl_close($ch);
?>

</div>
<div class='fti'>       
        <img src="./img2.jpg"> 
     </div>

     <script>
        function bar_open() {
            document.getElementById("sidebar").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }
        function bar_close() {
            document.getElementById("sidebar").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }
    </script>
</body>
</html>