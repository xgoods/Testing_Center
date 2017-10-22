<?php
class GetGradingRubric {
	public function post($data,$db) {
		$qid = $data['qid'];
		$ques = mysqli_query($db,"SELECT * FROM Bank WHERE qid = '$qid'");
		$question = mysqli_fetch_array($result);
		if ($question = NULL) {
			die(json_encode(array(
				"status" => 0,
				"message" => "question does not exist")));
    } else {
			$result = mysqli_query($db,"SELECT fname FROM Bank WHERE qid = '$qid';");
      $row = mysqli_fetch_array($result);
      $fname = $row['fname'];
      $arg1 = $row['arg1'];
      $arg2 = $row['arg2'];
      $arg3 = $row['arg3'];
      die(json_encode(array(
	  "status" => 1
          "fname" => $fname)));
   }
	}
}
?>
