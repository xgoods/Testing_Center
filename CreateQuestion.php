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
		$args = $_POST['args'];
    $return = $_POST['returns'];
    $ranswer = "place hold";//$_POST['ranswer'];

		$result = mysqli_query($db, "INSERT INTO Bank VALUES ('$newqid','$question','$type','$fname','$args','$return','$ranswer');");
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
//	 }
//}
?>
