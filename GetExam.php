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
    
		$eid = $_POST['examSelect'];
//    $eid = $eida[0];
		$return = array();
		$exams = mysqli_query($db, "SELECT Bank.question FROM ((SELECT * FROM QAA WHERE (QAA.eid='$eid')) AS T1) INNER JOIN (Bank) ON (Bank.qid = T1.qid);");
    if (!$exams) {
			die(json_encode(array(
				"status" => -1,
				"message" => mysqli_error($db))));
		}
        while ($row = mysqli_fetch_assoc($exams)) {
//            $return[] = array($row['qid'] => $row['question']);
            $return[] = $row['question'];
        }
		$je = (json_encode($return));
    echo $je;
//	 }
//}
?>
