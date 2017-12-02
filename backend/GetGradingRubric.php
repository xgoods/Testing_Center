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
        $eid = $_POST['eid'];
        $qidarr = mysqli_query($db, "SELECT qid FROM QAA WHERE(eid = '$eid');");
        $return = array();
        $parr = array();
        $varr = array();
        $farr = array();
        $tarr = array();
        $sarr = array();
        $iarr = array();
        $oarr = array();
        while ($rowqid = mysqli_fetch_assoc($qidarr)) {
            $qid = $rowqid['qid'];
        
//           $qarr = mysqli_query($db,"SELECT points,ranswer FROM Bank WHERE(qid = '$qid')");
            $pr = mysqli_query($db,"SELECT points FROM Bank WHERE(qid = '$qid')");
            $par = mysqli_fetch_array($pr);
            $parr[] = $par['points'];
            
            $vr = mysqli_query($db,"SELECT args FROM Bank WHERE(qid = '$qid')");
            $var = mysqli_fetch_array($vr);
            $varr[] = $var['args'];
            
            $fr = mysqli_query($db,"SELECT fname FROM Bank WHERE(qid = '$qid')");
            $far = mysqli_fetch_array($fr);
            $farr[] = $far['fname'];
            
            $tr = mysqli_query($db,"SELECT type FROM Bank WHERE(qid = '$qid')");
            $tar = mysqli_fetch_array($tr);
            $tarr[] = $tar['type'];
            
            $sr = mysqli_query($db,"SELECT answer FROM Answers WHERE(qid = '$qid')");
            $sar = mysqli_fetch_array($sr);
            $sarr[] = $sar['answer'];
            
            $ir = mysqli_query($db,"SELECT input FROM Cases WHERE(qid = '$qid')");
            $iar = mysqli_fetch_array($ir);
            $riar[] =  array();
            while ($row = mysqli_fetch_assoc($iar)) {
            $riar[] =  $row['input'];
            }
            $iiar = implode("@",$riar);
            $iarr[] = $iiar;
            
            $or = mysqli_query($db,"SELECT output FROM Cases WHERE(qid = '$qid')");
            $oar = mysqli_fetch_array($or);
            $roar[] =  array();
            while ($row = mysqli_fetch_assoc($oar)) {
            $roar[] =  $row['output'];
            }
            $oiar = implode("@",$roar);
            $oarr[] = $oiar;
            
//            while ($rowq = mysqli_fetch_assoc($qarr)) {
//                $return[] = $rowq;
//            }
        }
        $points = implode("~",$parr);
        $args = implode("~",$varr);
        $fname = implode("~",$farr);
        $type = implode("~",$tarr);
        $answer = implode("~",$sarr);
        $input = implode("~",$iarr);
        $output = implode("~",$oarr);

        $return['points'] = $points;
        $return['args'] = $args;
        $return['fname'] = $fname;
        $return['type'] = $type;
        $return['answer'] = $answer;
        $return['testcase'] = $input;
        $return['output'] = $output;
        
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

   
//   }
//}
?>
