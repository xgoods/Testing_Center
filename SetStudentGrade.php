<?php
class SetStudentGrade {
	public function post($data,$db) {
		$eid = $data['eid'];
		$uid = $data['uid'];
		$grade = mysqli_query($db,"SELECT SUM(Answers.qgrade) WHERE Answers.eid = $eid AND Answers.uid = $uid;");
		$result = mysqli_query($db,"INSERT INTO Grades VALUES ('$eid','$grade','$uid');");
		die(json_encode(array(
			"status" => 1)));
	}
}
?>
