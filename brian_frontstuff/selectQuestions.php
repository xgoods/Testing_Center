<!DOCTYPE html>
<html>
    <header>
	   <h1>Create an Exam</h1>
    </header>
</html>

<?php
	$post = "questionBank";
	$url = 'kevins get question curl';
	
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $getQuestions = curl_exec($ch);
    curl_close($ch);
    $questionsArray = json_decode($getQuestions, true);
	
	$count = 1;
    echo "<form name='createExam' method='post' action='selectQuestions.php' value=></br>";
    echo "Enter the exam name: <input type='text' name='examName' value='$examName'><br>";
    foreach ($questionsArray as $question){
        $value = array_search($question, $questionsArray);
        echo "<input type='checkbox' name='$count' id='$count' value='$value'>".$question."<br>";
        $count++;
    }
    echo "<input type='submit' name='submit' id='submit' value='Submit'>";
    echo "</form>";
    echo "<form name='backLogin' action='teacherHome.php'>
            <input type='submit' name='submit' id='submit' value='back to menu'>
          </form>";
          
    $questionCount = array();
    for($i = 1; $i < $count+1; $i++)
        if(!empty($_POST[$i])) {
            if($questionCount == null)
                $questionCount = array($i);
            else
                array_push($questionCount, $i);
        }

    if($questionCount == null ) {
        echo "You need to select atleast 1 question";
        exit();
    }
    else if(empty($_POST['examName'])) {
        echo "You must enter the name of the exam";
        exit();
    }

    $post = null;
    foreach($questionCount as $question)
        if($post == null)
            $post = $question."=".$_POST[$question];
        else
            $post = $post."&".$question."=".$_POST[$question];

    $post = $post."&count=".$count."&examName=".$_POST['examName'];
	$url = "kevins mid for this";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $sendQuestions = curl_exec($ch);
    curl_close($ch);
    echo $sendQuestions;    
  
?>
