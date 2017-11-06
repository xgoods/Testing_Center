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
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	</head>

   <body>
   		<div class="header">Student's Platform
   		</div>

		<div class="sidebar bar-block animate-left" style="display:none;z-index:5" id="sidebar">
  			<button class="bar-item buttonBar large" style="color: rgba(79, 80, 73, 1); background-color: rgba(1, 55, 6, 0.24);" onclick="bar_close()">Close &times;
  			</button>
   			<a href="grades.php" class="w3-bar-item w3-button">Grades</a>
  			<a href="index.html" class="w3-bar-item w3-button">Log out</a>
		</div>

		<div class="overlay animate-opacity" onclick="bar_close()" style="cursor:pointer" id="overlay">
		</div>
    
    	<div> 
  			<button class=" buttonBar btnLay xxlarge" onclick="bar_open()">&#9776;
  			</button>
		</div>

    <section class="container">
    <div class="intro">
    		<div class="description"> Attempt exams your instructor has made available for you.<br>
    		The exam is consisted of 4 questions, aimed at testing your Pyhon coding skills.<br> 
    		You will have only one attempt.
    		Good luck!
    		</div>
    </div>
    	
    <div name="chooseExam" class="chooseExam">
<?php  
    	$userName = $_SESSION['user'];
    	echo "<form name='examSelect' method='post' action='test.php'>";
    	echo "<select class='dropDown' name='exam' id='exam'>";
    	echo "<option selected='selected'>Select available exams</option>";

    	$url = "https://web.njit.edu/~ad379/ListStudentExams.php";
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
   		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    	$examExec = curl_exec($ch);
    	curl_close($ch);
    	$examArray = json_decode($examExec, true);    

    	foreach($examArray as $exam){
    		$value = array_search($exam, $examArray);
    		echo "<option style='background-color:rgba(58, 138, 56, 0.29);' class='option' value='$value'>$exam</option>";
      	}
      		
      	$value = $_POST['examSelect'];
        $url='https://web.njit.edu/~ad379/GetExam.php';
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $value);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    	curl_close($ch);	  		
      	echo "</select>";
      	echo "<input type='submit' class='button' name='submit' value='Start Exam' style='width:200px;'>";	
      	echo "<input type='textbox' value=$userName style='visibility:hidden;'>";
      	echo "</form>";  	
?>

    </div> 
	</section>
    
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