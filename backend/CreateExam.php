<?php
$db=mysqli_connect("sql2.njit.edu","ad379","admin","ad379");
if (mysqli_connect_errno()) {
	http_response_code(500);
	die(json_encode(array(
		"status" => -1,
		"message" => mysqli_connect_error())));
}
//    $contents = file_get_contents('php://input');
		$eid = mysqli_query($db, "SELECT COUNT(*) FROM Exams;");
		$eid = mysqli_fetch_array($eid);
		$neweid = $eid[0];
		$name = $_POST['examName'];
		$result = mysqli_query($db, "INSERT INTO Exams(eid, name) VALUES('$neweid','$name');");
    $questionarr = explode(" ",$_POST['questions']);
    $c = count($questionarr);
    for ($i = 0; $i < $c; $i++) {
//      $qid = mysqli_query($db, "SELECT qid FROM BANK WHERE question = $question;");
      $qid = $questionarr[$i];
			$result = mysqli_query($db, "INSERT INTO QAA(eid, qid) VALUES('$neweid','$qid');");
    }
		die(json_encode(array(
			"status" => 1,
			"message" => "Exam successfully created")));
?>
