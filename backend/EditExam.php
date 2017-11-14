<?php
$db=mysqli_connect("sql2.njit.edu","ad379","admin","ad379");
if (mysqli_connect_errno()) {
	http_response_code(500);
	die(json_encode(array(
		"status" => -1,
		"message" => mysqli_connect_error())));
}
		$qid= 555555555555555555555555555;
		$eid = $_POST['eid'];
    $questionarr = explode("~",$_POST['question']);
    $c = count($questionarr);
    for ($i = 0; $i < $c; $i++) {
      $question = $questionarr[$i];
      $q = mysqli_query($db, "SELECT qid FROM Bank WHERE (question = '$question');");
		  while($row = mysqli_fetch_assoc($q))
	  	  $qid = $row['qid'];
           echo $qid;
           echo $question;
           echo $eid;
			$result = mysqli_query($db, "DELETE FROM QAA WHERE(eid='$eid' AND qid='$qid');");
    }
		die(json_encode(array(
			"status" => 1,
			"message" => "Questions successfully deleted")));
?>
