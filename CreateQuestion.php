<?php
class CreateQuestion {
	public function post($data,$db) {
		$qid = mysqli_query($db, "SELECT COUNT(*) FROM Bank;");
		$qid = mysqli_fetch_array($qid);
		$question = mysqli_real_escape_string($db,$data['question']);
		$type = mysqli_real_escape_string($db,$data['type']);
		$newqid = $qid[0];
		$fname = mysqli_real_escape_string($db,$data['fname']);
		$arg1 = mysqli_real_escape_string($db,$data['arg1']);
		$arg2 = mysqli_real_escape_string($db,$data['arg2']);
		$arg3 = mysqli_real_escape_string($db,$data['arg3']);
    $answer = mysqli_real_escape_string($db,$data['answer']);
    $answer = mysqli_real_escape_string($db,$data['ranswer']);

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
		die(json_encode(array(
			"status" => $status,
			"message" => $message)));
	}
}
?>
