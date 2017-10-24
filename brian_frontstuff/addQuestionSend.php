<?php
  	$functionName = $_POST['functionName'];
    $args = $_POST['args'];
    $return = $_POST['return'];
    $answer = $_POST['answer'];
      
    $question = "Write a function named " . $functionName . " that takes " . $args . " argument(s) and " . $return;
      
    if($question == null || $answer == null){
        echo "Please enter all the inputs.";
        echo "<form name='backaddQuestion' action='addQuestion.php'>
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
  	
  	//echo $questionSend
  	echo "Your question has been added.";
  	
  	echo "<form name='backaddQuestion' action='addQuestion.php'>
            <input type='submit' name='submit' id='submit' value='Add another question'>
          </form>";
	//header("Location:https://web.njit.edu/~bg245/addQuestion.php");
?>
