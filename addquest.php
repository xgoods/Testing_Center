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
    <title>Beta</title>
    <meta http-equiv="Content-type" content="text/html"; charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
    
<body>
    <div class="header">Teacher's Platform</div>
        
    <div class="sidebar bar-block animate-left" style="display:none;z-index:5" id="sidebar">
        <button class="bar-item buttonBar large" style="color: rgba(79, 80, 73, 1); background-color: rgba(1, 55, 6, 0.24);" onclick="bar_close()">Close &times;
        </button>
        <a href="teacher.php" class="bar-item buttonBar">Home</a>
        <a href="grades.php" class="bar-item buttonBar">Grades</a>
        <a href="createexam.php" class="bar-item buttonBar">Create Exams</a>
        <a href="index.html" class="bar-item buttonBar">Log out</a>
    </div>

    <div class="overlay animate-opacity" onclick="bar_close()" style="cursor:pointer" id="overlay">
    </div>
 
    <div> 
        <button class=" buttonBar btnLay xxlarge" onclick="bar_open()">&#9776;
        </button>
    </div>

    <div id='teacher_editor_div' class='head'>Add new python questions you wish to test your students on here:</div>

    <div name='add'>
        <form name="addQ" method='post' action='addquest.php'>
            Write a function named <input type='text' name='functionName' size=20>that takes
            <select name="args">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
            argument(s) and <input type="text" name="return" size='80'> (ex.."returns the sum")<br><br>
            Answer:<textarea type="text" name="answer" rows="20" cols="80"></textarea>
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>

    <div>
<?php
    echo "<input type='submit' name='button' value='show question bank' onclick='showStuff()'> ";
    echo "<script>
    function showStuff(){
        document.getElementById('getExisting').style.visibility='visible';}</script>";

    echo "<form id='getExisting' name='getExisting' method='post' action='addquest.php' style='visibility:hidden'>";
    
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

    foreach ($questionsArray as $question){
        $value = array_search($question, $questionsArray);
        echo "- ";
        echo $question;
        echo "<br>";
    }
    echo "</form>";

    $functionName = $_POST['functionName'];
    $args = $_POST['args'];
    $return = $_POST['return'];
    $answer = $_POST['answer'];
      
    $question = "Write a function named " . $functionName . " that takes " . $args . " argument(s) and " . $return;
      
    if($question == null || $answer == null){
        echo "Please enter all the inputs.";
        echo "<form name='backaddQuestion' action='addquest.php'>
            <input type='submit' name='submit' id='submit' value='Back'>
            </form>";
        exit();
    }
      
    $post = 'functionName='.$functionName.'&args='.$args."&returns=".$return.'&question='.$question;
      
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~kl297/mid_addQuestion.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $questionSend = curl_exec($ch);
    curl_close($ch);
    
    echo "Your question has been added.";
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
