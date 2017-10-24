<?php
//class Login {
//	public function post($data,$db) {
$db=mysqli_connect("sql2.njit.edu","ad379","admin","ad379");
if (mysqli_connect_errno()) {
	http_response_code(500);
	die(json_encode(array(
		"status" => -1,
		"message" => mysqli_connect_error())));
}
		$eid = $data['eid'];
		$uid = $data['uid'];
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
//	}
//}
?>
