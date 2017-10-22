<?php
class GetExam {
	public function post($data,$db) {
		$eid = $data['data'];
		$return = array();
		$exams = mysqli_query($db, "SELECT * FROM QAA WHERE eid = '$eid';");
		if (!$exams) {
			die(json_encode(array(
				"status" => -1,
				"message" => mysqli_error($db))));
		}
		while($exam = mysqli_fetch_array($exams)) {
			$return[$exam['qid']] = $exam['qid'];
		}
		die(json_encode($return));
	}
}
