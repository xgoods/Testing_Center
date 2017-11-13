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
		$type = $_POST['type'];
		$newqid = $qid[0];
		$fname = $_POST['functionName'];
		$args = $_POST['args'];
    $return = $_POST['returns'];
    $ranswer = $_POST['ranswer'];
    $difficulty = $_POST['difficulty'];
    $points = $_POST['points'];
    $var1 = $_POST['var1'];
    $var2 = $_POST['var2'];
    $var3 = $_POST['var3'];
		$result = mysqli_query($db, "INSERT INTO Bank VALUES ('$newqid','$question','$type','$fname','$args','$return','$ranswer','$difficulty','$points','$var1','$var2','$var3');");
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
