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
		$curreid = $_POST['eid'];
		$grades = mysqli_query($db,"SELECT * FROM Grades WHERE eid = $curreid;");
		$return = array();
		if ($grades != NULL) {
			while ($currgrade = mysqli_fetch_array($grades)) {
					$return[$currgrade['uid']] = $currgrade['grade'];
			}
		}
		$je = (json_encode($return));
    echo $je;
//	}
//}
?>
