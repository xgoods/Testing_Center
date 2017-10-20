<?php
	$functionName = $_POST['functionName'];
    $args = $_POST['args'];
    $return = $_POST['return'];
    $answer = $_POST['answer'];
      
    $question = "Write a function named " . $functionName . " that takes " . $args . " argument(s) and " . $return . " (ex.. 'returns the sum)'";
      
    if($question == null || $answer == null){
        echo "Please enter all the inputs.";
        exit();
    }
      
    $post = 'functionName='.$functionName.'&args='.$args."&returns=".$return.'&question='.$question.;
      
	$url='kevins mid for this';
	$ch = curl_init();
 	curl_setopt($ch, CURLOPT_URL, $url);
 	curl_setopt($ch, CURLOPT_POST, 1);
 	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
  	$questionSend = curl_exec($ch);
 	curl_close($ch);
  	
  	//echo $questionSend
  	echo "Your question has been added.";

?>
