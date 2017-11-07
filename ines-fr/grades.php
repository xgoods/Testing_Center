<?php
session_start();
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        if ($user=="student1"){}
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
    	<title>Welcome!</title>
    	<meta http-equiv="Content-type" content="text/html"; charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

    <body>
   		<div class="header">Student's Platform
   		</div>

		<div class="sidebar bar-block animate-left" style="display:none;z-index:5" id="sidebar">
  			<button class="bar-item buttonBar large" style="color: rgba(79, 80, 73, 1); background-color: rgba(1, 55, 6, 0.24);" onclick="bar_close()">Close &times;
  			</button>
   			<a href="student.php" class="w3-bar-item w3-button">Home</a>
  			<a href="index.html" class="w3-bar-item w3-button">Log out</a>
		</div>

		<div class="overlay animate-opacity" onclick="bar_close()" style="cursor:pointer" id="overlay">
		</div>
    
    	<div> 
  			<button class=" buttonBar btnLay xxlarge" onclick="bar_open()">&#9776;
  			</button>
		</div>

    	<div name="getResults">
<?php
    $userName = $_SESSION['user'];
    $post = "user=".$userName;

    echo "<form name='examSelect' method='post' action='grades.php'>";
    echo "<select name='exam'>";
    echo "<option selected='selected'></option>";

    $url = "https://web.njit.edu/~ad379/ListStudentExams.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $an);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $releaseExam = curl_exec($ch);
    curl_close($ch);
    $examArray = json_decode($releaseExam, true);
    $sendBack = array();   
    
    foreach($examArray as $exam) {
   	$value = array_search($exam, $examArray);
   // echo $value;
    echo "<option name='examName' value='$value'>$exam</option>";
    }

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

    echo "</select>";
    echo "<input type='submit' name='submit' value='View'>";
    echo "<input type='textbox' value=$userName style='visibility:hidden;'>";
    echo "</form>";
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