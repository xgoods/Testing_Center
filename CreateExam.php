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
		$eid = mysqli_query($db, "SELECT COUNT(*) FROM Exams;");
		$eid = mysqli_fetch_array($eid);
		$neweid = $eid[0];
		$name = $_POST['examName'];
		$result = mysqli_query($db, "INSERT INTO Exams(eid, name) VALUES('$neweid','$name');");
		if (!$result) {
			die(json_encode(array(
				"status" => -1,
				"message" => mysqli_error($db))));
		}
		unset($data['name']);
        $weight = $data['qid'];
		foreach($data as $key => $value) {
			$result = mysqli_query($db, "INSERT INTO QAA VALUES('$neweid','$key', '$value');");
			if (!$result) {
				die(json_encode(array(
					"status" => -1,
					"message" => mysqli_error($db))));
			}
		}
		die(json_encode(array(
			"status" => 1,
			"message" => "Exam successfully created")));
//	}
//}
?>
