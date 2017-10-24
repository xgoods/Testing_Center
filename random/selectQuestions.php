/<!DOCTYPE html>
<html>
    <header>
	   <h1>Create an Exam</h1>
    </header>
</html>

<?php
	
	  $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~kl297/mid_selectQuestions.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $getQuestions = curl_exec($ch);
    curl_close($ch);
    $questionsArray = json_decode($getQuestions, true);
	
	$count = 1;
    echo "<form name='createExam' method='post' action='selectQuestions.php' value=></br>";
    echo "Enter the exam name: <input type='text' name='examName' value='$examName'><br>";
    foreach ($questionsArray as $question){
    	$value = array_search($question, $questionsArray);
    	echo $value;
        echo "<input type='checkbox' name='quests[]' id='quests[]' value='$value'>".$question."<br>";
        $count++;
        
    }
    //echo $count;
    echo "<input type='submit' name='submit' id='submit' value='Submit'>";
    echo "</form>";
    echo "<form name='backLogin' action='teacherHome.php'>
            <input type='submit' name='submit' id='submit' value='back to menu'>
          </form>";
          
    
    if (isset($_POST['quests'])) {
    	$quests = implode(' ', $_POST['quests']);
    	}
   
    //echo $quests;
    
   if(empty($_POST['examName'])) {
        echo "You must enter the name of the exam";
        exit();
    }
    
    $examName = $_POST['examName'];
	$post = array('questions'=>$quests, 'examName'=>$examName);
	print_r($post); 
	$url = "https://web.njit.edu/~kl297/mid_createExam.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $sendQuestions = curl_exec($ch);
    curl_close($ch);
    echo $sendQuestions;    
  
?>
