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

<html>
	<head>
    	<title>Create Exam</title>
    	<meta http-equiv="Content-type" content="text/html"; charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
    
    <body>
		<div class="header">Teacher's Platform</div>
        
    	<div class="sidebar bar-block animate-left" style="display:none;z-index:5" id="sidebar">
        	<button class="bar-item buttonBar large" style="color: rgba(79, 80, 73, 1); background-color: rgba(1, 55, 6, 0.24);" onclick="bar_close()">Close &times;
        	</button>
        	<a href="teacher.php" class="bar-item buttonBar">Home</a>
        	<a href="gradesT.php" class="bar-item buttonBar">Grades</a>
        	<a href="addquest.php" class="bar-item buttonBar">Add Questions</a>
        	<a href="index.html" class="bar-item buttonBar">Log out</a>
    	</div>

    	<div class="overlay animate-opacity" onclick="bar_close()" style="cursor:pointer" id="overlay">
    	</div>
 
    	<div> 
        	<button class=" buttonBar btnLay xxlarge" onclick="bar_open()">&#9776;
        	</button>
    	</div>
	
		<div id="display">
			
		</div>

<?php
	$post = "questionBank";
	$url = 'https://web.njit.edu/~kl297/mid_selectQuestions.php';
	
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $getQuestions = curl_exec($ch);
    curl_close($ch);
    $questionsArray = json_decode($getQuestions, true);

	$count = 1;
    echo "<form name='createExam' method='post' action='createexam.php'>";

    echo "<div>";
    echo "Enter the exam name: <input type='text' name='examName' value='$examName'><br>";
    echo "</div>";

    echo "<div>";
    echo "Choose from existing questions";echo"<br><br>";
    foreach ($questionsArray as $question){
    	$value = array_search($question, $questionsArray);
    	echo $value;
        echo "<input type='checkbox' name='quests[]' id='quests[]' value='$value'>".$question."<br>";
        $count++;
    }
    echo "</div>";

    echo "<div>";
    echo "Add a new question"; echo"<br><br>";
    echo "<form name=addQuest>";

    echo "</form>";
    echo "</div>";

    echo "<input type='submit' name='submit' id='submit' value='Submit'>";
    echo "</form>";
          
    
    if (isset($_POST['quests'])) {
    	$quests = implode(' ', $_POST['quests']);
    }
    
   if(empty($_POST['examName'])) {
        echo "You must enter the name of the exam";
        exit();
    }
    
    $examName = $_POST['examName'];
	$post = array('questions'=>$quests, 'examName'=>$examName);
	print_r($post); 
	
	$url = "https://web.njit.edu/~ad379/CreateExam.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $sendQuestions = curl_exec($ch);
    curl_close($ch);
    echo $sendQuestions;    
  
?>
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

