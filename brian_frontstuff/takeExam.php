<?php
    /*session_start();
    if(isset($_SESSION['Username'])){
    }
    else{
        header("Location:http://localhost/cs431/Front/login.html");
        exit;
    }

    if(empty($_POST['examSelect'])){
        echo "Please select an exam.";
        exit();
    }*/

    $examName = $_POST['examSelect'];
    $post = "examName=".$examName;

    $url = "https://web.njit.edu/~tkt6/cs490/Middle/middleTakeExam.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($ch);
    //echo $response;
    curl_close($ch);
    $resultArray = json_decode($response, true);
    
    echo "<form name='takeExam' id='takeExam' method='post' action='frontTakeExamProcess.php'";
    $counter = 1;
    foreach($resultArray as $value){
        echo "<p>".$counter.")</p>";
        if($value["Type"] == "mc"){
            $correct = "CorrectAnswer";
            $a1 = $value["CorrectAnswer"];
            $a2 = $value["Answer2"];
            $a3 = $value["Answer3"];
            $answerArray = array($a1, $a2, $a3);
            $shuffle = shuffle($answerArray);
            echo "<p>".$value["Question"]."</p>";
            
            echo "<input type='radio' name='$counter' value='$answerArray[0]'>".$answerArray[0];
            echo "<input type='radio' name='$counter' value='$answerArray[1]'>".$answerArray[1];
            echo "<input type='radio' name='$counter' value='$answerArray[2]'>".$answerArray[2];
            echo "<input type='radio' name='answer$counter' value='$value[$correct]' checked hidden>";
        }
        else if($value["Type"] == "fitb"){
            $correct = "CorrectAnswer";
            echo "<p>".$value["Question"]."</p>";
            echo "<input type='text' name='$counter'>";
            echo "<input type='radio' name='answer$counter' value='$value[$correct]' checked hidden>";
        }
        else if($value["Type"] == "tf"){
            $correct = "CorrectAnswer";
            echo "<p>".$value["Question"]."</p>";
            echo "True<input type='radio' name='$counter' value='true'>";
            echo "False<input type='radio' name='$counter' value='false'>";
            echo "<input type='radio' name='answer$counter' value='$value[$correct]' checked hidden>";
        }
        else if($value["Type"] == "oe"){
            $arg1 = null;
            $arg2 = null;
            $arg3 = null;
            $arg4 = null;
            $type1 = null;
            $type2 = null;
            $type3 = null;
            $type4 = null;
            
            if($value['Type1']){
              $type1 = $value['Type1'];
              echo "<input type='radio' name='type1-$counter' value='$type1' checked hidden>";
            }
            if($value['Type2']){
              $type2 = $value['Type2'];
              echo "<input type='radio' name='type2-$counter' value='$type2' checked hidden>";
            }
            if($value['Type3']){
              $type3 = $value['Type3'];
              echo "<input type='radio' name='type3-$counter' value='$type3' checked hidden>";
            }
            if($value['Type4']){
              $type4 = $value['Type4'];
              echo "<input type='radio' name='type4-$counter' value='$type4' checked hidden>";
            }
            if($value['Arg1']){
              $arg1 = $value['Arg1'];
              echo "<input type='radio' name='arg1-$counter' value='$arg1' checked hidden>";
            }
            if($value['Arg2']){
              $arg2 = $value['Arg2'];
              echo "<input type='radio' name='arg2-$counter' value='$arg2' checked hidden>";
            }
            if($value['Arg3']){
              $arg3 = $value['Arg3'];
              echo "<input type='radio' name='arg3-$counter' value='$arg3' checked hidden>";
            }
            if($value['Arg4']){
              $arg4 = $value['Arg4'];
              echo "<input type='radio' name='arg4-$counter' value='$arg4' checked hidden>";
            }
      
            $funcName = "FuncName";
            $correct = "CorrectAnswer";
            echo "<p>".$value["Question"]."</p>";
            echo "Answer: <textarea name='oe$counter' rows=15 cols=75></textarea>";
            echo "<input type='radio' name='oe-answer$counter' value='$value[$correct]' checked hidden>";
            echo "<input type='radio' name='oe-funcName$counter' value='$value[$funcName]' checked hidden>";
        }
        echo "<hr>";
        $counter++;
    }
    echo "<input type='radio' name='examName' value='$examName' checked hidden>";
    echo "<input type='submit' name='submit' value='Submit'>";
    echo "</form>";
?>

<?php
    //session_destroy();
?>
