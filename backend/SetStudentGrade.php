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
    
		$points = $_POST['points'];
		$comments = $_POST['comments'];
    $a = mysqli_fetch_array(mysqli_query($db, "SELECT qid FROM Exams WHERE (eid='$eid');"));
    while ($row = mysqli_fetch_assoc($a)) {
        $qid = $row['qid'];
		    $b = mysqli_query($db, "INSERT INTO Students (uid,eid,qid,points,comments) VALUES ('$uid','$eid','$qid','$points','$comments');");
    }
    if (!$result) {
			$status = -1;
			$message = mysqli_error($db);
		}
		else {
			$status = 1;
			$message = "Question successfully graded";
		}
//	}
//}
?>
