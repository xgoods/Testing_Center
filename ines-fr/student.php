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

		<div class="tabs" id="studentpg">
    <form>
        <table>
            <tbody>
                <tr>
                    <td valgin="top" style="text-align: right" colspan="1">
                    <a href="grades.php">grades</a>
                    |
                    <a href="index.html">logout</a>
                    </td>    
                </tr>
            </tbody>
        </table>
    </form>
    </div>
  
    <img class="studentImg" src="./board.jpg"> 
    	
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
    		echo "<option class='optionSelect' value='$value'>$exam</option>";
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
      	echo "<input type='submit' class='button' name='submit' style='opacity: 0.8; width:200px;' value='Start Exam'>";	
      	echo "<input type='textbox' value=$userName style='visibility:hidden;'>";
      	echo "</form>";  	
?>

    </div> 
	</section>
    
    <div class='fti'> 		
    	<img src="./img2.jpg"> 
    </div>

   </body>
</html>