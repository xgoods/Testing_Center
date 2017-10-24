<?php
//class GetGradingRubric {
//	public function post($db) {
$db=mysqli_connect("sql2.njit.edu","ad379","admin","ad379");
if (mysqli_connect_errno()) {
	http_response_code(500);
	die(json_encode(array(
		"status" => -1,
		"message" => mysqli_connect_error())));
}
        $result = mysqli_query($db,"SELECT * FROM Bank");
        $return = array();
        while ($row = mysqli_fetch_assoc($result)) {
              $return[] = $row['fname'];
        }
        $return['status'] = 1;
        mysqli_close($db);
        $je = (json_encode($return));
        echo $je;
/*
$ = $_POST["qid"];
//    $qid = 1;//$data['qid'];
		$ques = mysqli_query($db,"SELECT * FROM Bank WHERE qid = '$qid'");
		$question = mysqli_fetch_array($result);
		if ($question = NULL) {
			die(json_encode(array(
				"status" => 0,
				"message" => "question does not exist")));
    } else {
			$result = mysqli_query($db,"SELECT fname FROM Bank WHERE qid = '$qid';");
      $row = mysqli_fetch_array($result);
      $fname = $row['fname'];
      echo $fname;
//      $arg1 = $row['arg1'];
//      $arg2 = $row['arg2'];
//      $arg3 = $row['arg3'];
		$je =(json_encode(array(
			"status" => 1,
      'fname' => $fname)));
   echo $je;
   } 
*/

   
//    }
//}
?>
