<?php
//class CreateQuestion {
//	public function post($data,$db) {
$db=mysqli_connect("sql2.njit.edu","ad379","admin","ad379");
if (mysqli_connect_errno()) {
	http_response_code(500);
	die(json_encode(array(
		"status" => -1,
		"message" => mysqli_connect_error())));
}



		$qid = mysqli_query($db, "SELECT COUNT(*) FROM Bank;");
		$qid = mysqli_fetch_array($qid);
		$question = $_POST['question'];
		$type = "open";
		$newqid = $qid[0];
		$fname = $_POST['functionName'];
		$arg1 = $_POST['args1'];
		$arg2 = $_POST['args2'];
		$arg3 = $_POST['args3'];
    $answer = $_POST['answer'];
    $ranswer = "place hold";//$_POST['ranswer'];

		$result = mysqli_query($db, "INSERT INTO Bank VALUES ('$newqid','$question','$type','$fname','$arg1','$arg2','$arg3','answer','ranswer');");
		if (!$result) {
			$status = -1;
			$message = mysqli_error($db);
		}
		else {
			$status = 1;
			$message = "Question successfully created";
		}
		mysqli_close($db);
		$je = (json_encode(array(
			"status" => $status,
			"message" => $message)));
    echo $je;
//	}
//}
?>
