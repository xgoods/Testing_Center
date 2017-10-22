<?php
class SetStudentAnswers {
	public function post($data,$db) {
		unset($data['cmd']);
		$data=$data['data'];
		$eid = $data['eid'];
		unset($data['eid']);
		$uid = $data['uid'];
		unset($data['uid']);
    $answer = $data['answer'];
    $qgrade = $data['grade'];
		$result = mysqli_query($db,"SELECT * FROM Grades WHERE uid = '$uid' AND eid = '$eid'");
		$answers = mysqli_fetch_array($result);
		if ($answers != NULL) {
			die(json_encode(array(
				"status" => 0,
				"message" => "student already took this exam")));
    } else {
			$result = mysqli_query($db,"INSERT INTO Answers VALUES ('$eid','$qid','$uid','$answer','$qgrade');");
		die(json_encode(array(
			"status" => 1)));
   }
	}
}
?>
