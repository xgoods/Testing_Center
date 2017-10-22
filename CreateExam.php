<?php
class CreateExam {
	public function post($data,$db) {
		$eid = mysqli_query($db, "SELECT COUNT(*) FROM Exams;");
		$eid = mysqli_fetch_array($eid);
		$neweid = $eid[0];
		$name = mysqli_real_escape_string($db,$data['name']);
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
	}
}
?>
