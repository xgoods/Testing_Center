<?php
session_start();
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        if ($user!="teacher1"){}
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
      <title>Exam!</title>
      <meta http-equiv="Content-type" content="text/html"; charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>

  <body>
    <div class="header">Good Luck!</div>

<?php 
  
  error_reporting(0);
  
  $examName = $_POST["exam"];
  $userName = $_SESSION["user"];

  $url = "https://web.njit.edu/~kl297/mid_getExam.php";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $examName);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $takeExam = curl_exec($ch);
  $examArray = array();
  curl_close($ch);
  $questionArray = json_decode($takeExam, true);
//var_dump($questionArray);
  echo "<div class='examQuestion' style='width:auto;'>";
  echo "<form method='post' action='test1.php'>";

  foreach($questionArray as $question) {
    echo "<p>".$question['question']." (".$question['points']." points)</p>";

    echo "Answer: <textarea class='teacherInput' name='count[]' rows=20 cols=80></textarea>";
  }
  
    echo "<input type='textbox' name='examName' value='$examName' style='visibility:hidden';>";
    echo "<input type='textbox' name='userName' value='$userName' style='visibility:hidden';>";

    echo "<input type='submit' name='submit' value='submit' class='button'>";
    echo "</form>";
    echo "</div>";

    if (isset($_POST['submit'])){
    $examArray = array();
    array_push($examArray, $userName);
    array_push($examArray, $_POST['examName']);
   
    $an = array_merge($examArray, $_POST['count']);
   // $an = "&examName=".$examName."&uid=".$userName;
    
    print_r($an);
    }
    
    $finalArray = implode('~',$an);
    print_r($finalArray);
   /*
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~kl297/test.txt");  
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db); 
    
    //replace $briansarray, its the array with uid,eid,and student answers;
    $briansarray = array("student1","0","if","while","if","for");
    $briansarray = implode('~',$briansarray);
    
    file_put_contents('test.php',$dbexec);
    $output = shell_exec("php test.php '$finalArray'");
    //  echo "$output\n";
    
    //print_r($finalArray);
    
    $url2 = "https://web.njit.edu/~kl297/web/grade.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url2);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentinput=$finalArray");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $hello = curl_exec($ch);
    curl_close($ch);
    
    echo "your exam has been submitted";
    echo "<form action='student.php'>
       <input class = 'button' type='submit' value='Back to Home'
       style='width:auto; top:90%; left:80%;'>
    </form>";*/
?>
</body>
</html>
