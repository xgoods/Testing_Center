<?php
$db=mysqli_connect("sql2.njit.edu","ad379","admin","ad379");
if (mysqli_connect_errno()) {
	http_response_code(500);
	die(json_encode(array(
		"status" => -1,
		"message" => mysqli_connect_error())));
}
    $i = $y = 0;
    $x = 2;
		$arr = explode("~",$_POST['array']);
    $eid = $arr[1];
		$uid = $arr[0];
   echo $eid;
   echo $uid;
   $answers = array();
   $qidr = mysqli_fetch_array(mysqli_query($db,"SELECT qid FROM QAA WHERE (eid = '$eid');"));
        while($arr[$x] !== null){
            $answers[$y] = $arr[$x];
            echo $answers[$y];
            echo $uid;
            $a = $answers[$y];
            $result = mysqli_query($db,"INSERT INTO Answers(uid, eid, qid, answer) VALUES ('$uid','$eid','$qidr[$y]','$answers[$y]');"); 
            $x += 1;
            $y += 1;
        }

		die(json_encode(array(
			"status" => 1)));
?>
