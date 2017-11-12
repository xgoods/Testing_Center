<?php
//class CreateQuestion {
//	public function post($data,$db) {
$db=mysqli_connect("sql2.njit.edu","ad379","admin","ad379");
if (mysqli_connect_errno()) {
	http_response_code(500);
	die(json_encode(array(
		"status" => -1,
		"message" => mysqli_connect_error())));
}
		$qid = $_POST['qid'];
		$uid = $_POST['uid'];
		$eid = $_POST['eid'];
		$points = $_POST['points'];
		$comments = $_POST['comments'];

		$result = mysqli_query($db, "INSERT INTO Students (uid,eid,qid,points,comments) VALUES ('$uid','$eid','$qid','$points','$comments');");
		if (!$result) {
			$status = -1;
			$message = mysqli_error($db);
		}
		else {
			$status = 1;
			$message = "Question successfully graded";
		}
		mysqli_close($db);
		$je = (json_encode(array(
			"status" => $status,
			"message" => $message)));
    echo $je;
//	}
//}
?>
