<?php
class GetGrades {
	public function post($data,$db) {
		$curreid = $data['eid'];
		$grades = mysqli_query($db,"SELECT * FROM Grades WHERE eid = $curreid;");
		$return = array();
		if ($grades != NULL) {
			while ($currgrade = mysqli_fetch_array($grades)) {
					$return[$currgrade['uid']] = $currgrade['grade'];
			}
		}
		die(json_encode($return));
	}
}
?>
