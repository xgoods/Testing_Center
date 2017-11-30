<?php
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
    $difficulty = $_POST['difficulty'];
    $points = $_POST['points'];
    $var1 = $_POST['var1'];
    $var2 = $_POST['var2'];
    $var3 = $_POST['var3'];
    $input = explode("~",$_POST['input']);
    $output = explode("~",$_POST['output']);
		$result = mysqli_query($db, "INSERT INTO Bank VALUES ('$newqid','$question','$type','$fname','$args','$return','$difficulty','$points','$var1','$var2','$var3');");
		
    $c = count($questionarr);
    for ($i = 0; $i < $c; $i++) {
      $qid = $questionarr[$i];
			$result = mysqli_query($db, "INSERT INTO Cases(qid,input,output) VALUES('$newqid','$input[$i]','$output[$i]');");
    }
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
?>
