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
		$eid = $_POST['eid'];
		$uid = $_POST['uid'];
   $grade = $_POST['grade'];
		$result = mysqli_query($db,"INSERT INTO Grades(uid, eid, grade) VALUES ('$uid','$eid','$grade');");
		die(json_encode(array(
			"status" => 1)));
//	}
//}
?> 
