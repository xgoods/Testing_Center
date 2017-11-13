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
//    $contents = file_get_contents('php://input');
		
		$eid = $_POST['eid'];
    $questionarr = explode(" ",$_POST['question']);
    for ($i = 0; $i < 4; $i++) {
      $question = $questionarr[$i];
      $qid = mysqli_query($db, "SELECT qid FROM BANK WHERE question = $question;");
			$result = mysqli_query($db, "DELETE FROM QAA WHERE(eid='$eid' AND qid='$qid');");
    }
		die(json_encode(array(
			"status" => 1,
			"message" => "Questions successfully deleted")));
//	}
//}
?>
