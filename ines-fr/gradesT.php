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

        <div id='teacher_editor_div' class='head' style='background-color: rgba(17, 120, 102, 1); padding-left: 10px; padding-top:20px; padding-right: 10px; width:auto; border-radius: 5px; visibility: hidden'>Exam scores:</div>
        
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

<?php   // list students
error_reporting(0);
    $userName = $_SESSION['user'];
   // $post = "user=".$userName;


    $url = "https://web.njit.edu/~ad379/ListStudents.php";
    $ch = curl_init();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $examExec = curl_exec($ch);
    curl_close($ch);
    $studentArray = json_decode($examExec, true);    
    
    echo "<form name='selectStudent' method='post' action='gradesT.php'>";
    
    echo "<select class='dropDown' name='studentName' id='student' style='position:fixed; top:15%; left:10%;'>";
    echo "<option class='option' selected='selected'>Select student</option>";

    foreach($studentArray as $student){
        $value = array_search($student, $studentArray);
        echo "<option clas='optionSelect' name='option' value='$student'>$student</option>";
    }
    $value = $_POST['studentName'];

    //echo "<input type='textbox' name='studentName' value='$student' style='visibility:hidden';>";
    echo "<input type='textbox' name='userName' value='$userName' style='visibility:hidden';>";

    echo "<input type='submit' name='submit' value='submit' class='button' style='position:fixed; top:13%; left:5%; width:180px;'> ";
    echo "</form>";

    if (isset($_POST['submit'])){
        //print_r($value);
       // $post = "&uid=".$value;
    }

?>

<?php  //list exams
error_reporting(0);
   $uid = $_POST['studentName'];
   $post = "&uid=".$uid;
 //  print_r($post); 

    $url = "https://web.njit.edu/~ad379/ListStudentExams.php";
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $releaseExam = curl_exec($ch);
    curl_close($ch);
    $examArray = json_decode($releaseExam, true);
   // $questionArray = json_decode($return, true); 
 
    echo "<form name='selectExam' method='post' action='gradesT.php'>";
//var_dump($examArray);
    echo "<select class='dropDown' name='exam' id='exam' style='position:fixed; top:25%; left:10%;'>";
    echo "<option class='option' selected='selected'>Select exam</option>";

    foreach($examArray as $exam){
        $value = array_search($exam, $examArray);
        echo "<option clas='optionSelect' name='option' value='$value'>$exam</option>";
    }
    $value = $_POST['exam'];
    echo "<input type='textbox' name='studentName1' value='$uid' style='visibility:hidden';>";
    echo "<input type='textbox' name='userName' value='$userName' style='visibility:hidden';>";

    echo "<input type='submit' name='submit1' value='submit' class='button' style='position:fixed; top:23%; left:5%; width:180px;'> ";
    echo "</form>";

    if (isset($_POST['submit1'])){
      //  print_r($value);
       // print_r($_POST['studentName1']);
      //  $post = "&uid=".$value;
    }
?>

<?php //get results
error_reporting(0);
    $uid = $_POST['studentName1'];
    $eid = $_POST['exam'];
    $post = "&uid=".$uid."&eid=".$eid;
   // echo $post;
 
    $url = "https://web.njit.edu/~ad379/GetStudentResults.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $releaseExam = curl_exec($ch);
    curl_close($ch);
    $results = json_decode($releaseExam, true);

   // var_dump($results);
    
    echo "<div class='examQuestion' style='top:35%; width:90%; height: 50%;'>";
    echo "<form method='post' action='gradesT.php'>";

     echo "<input type='textbox' name='studentName2' value='$uid' style='visibility:hidden';>";
    echo "<input type='textbox' name='examName' value='$eid' style='visibility:hidden';>";

    foreach($results as $result) {
        echo "<p>Question: ".$result['question']."</p>";
        echo "<p>Grade: ".$result['qgrade']." out of ".$result['points']."</p>";
        echo "<p>Student answer: ".$result['answer']."</p>";
        echo "<p style=''>
        <textarea name='questId[]' style='visibility:hidden;'>".$result['qid']."</textarea>
        </p>";
        echo "<p>Errors:".$result['comments']."</p>";
        echo "Your comments: <textarea class='inputbox' 
        style='height:30px; width:auto;' placeholder='here' name='teachercomments[]'></textarea>";
        echo "<br><br>";
        echo "Your grade: <input class='inputbox' 
        style='height:30px; width:auto;' placeholder='here' name='grade[]'>";
        echo "<br>";
        echo "--------------------------------------------------------------------------------------------------------------------";
        echo "<br><br>";      
}
        echo "<input type='submit' name='submit3' value='Release Exam' class='button' style='position:fixed; top:80%; left:10%; width:180px;'> ";
        echo "</form>";

        $array = array();
        if (isset($_POST['submit3'])){
            $quid = implode('~', $_POST['questId']);
            $grade = implode('~',$_POST['grade']);
            $teachercomments = implode('~', $_POST['teachercomments']);
            $array="&eid=".$_POST['examName']."&uid=".$_POST['studentName2']."&qid=".$quid."&grade=".$grade."&teachercomments=".$teachercomments;
           // print_r($array);
        
        $url = "https://web.njit.edu/~ad379/EditAndReleaseExam.php";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $getQuestions = curl_exec($ch);
        curl_close($ch);


        }
  echo "</div>";

   /* echo "<form name='selectExam' method='post' action='gradesT.php'>";
    echo "<select class='dropDown' name='examName' id='exam' style='position:fixed; top:50%; left:25%;'>";
    echo "<option class='option' selected='selected'>Select Exam</option>";

    foreach($examArray as $exam){
        $value = array_search($exam, $examArray);
        echo "<option value='$value'>$exam</option>";
    }

    echo "</select>";
    echo "<input type='submit' name='submit' value='Release Grades' class='button' style='position:fixed; top:65%; left:5%; width:300px;'> ";
    echo "</form>";

    if (isset($_POST['submit'])){
    $examName = $_POST['examName'];
    $url = "https://web.njit.edu/~kl297/mid_sendReleaseGrade.php";
    $post = "examName=".$examName;
  
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $sendExam = curl_exec($ch);
    curl_close($ch);
    echo $sendExam;

    echo "<div class='head' style='top:40%;'>";
    echo "Score released";
    echo "</div>";

//	print_r($theExam);
    
	/*$url = "https://web.njit.edu/~kl297/mid_releaseGrade.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $theExam);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $getQuestions = curl_exec($ch);
    curl_close($ch);*/
  //  }
//}
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
