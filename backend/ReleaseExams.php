<?php
//class Login {
//	public function post($_POST,$db) {
$db=mysqli_connect("sql2.njit.edu","ad379","admin","ad379");
if (mysqli_connect_errno()) {
	http_response_code(500);
	die(json_encode(array(
		"status" => -1,
		"message" => mysqli_connect_error())));
}
      
      $eid = $_POST['eid'];
      $uid = $_POST['uid'];
      $newgrade = explode("~",$_POST['qgrade']);
      $tcomments = explode("~",$_POST['teachercomments']);
      $qid = explode("~",$_POST['qid']);
      $c1 = count($newgrade);
      $c2 = count($tcomments);
      
      for($i=0;$i<$c1;$i++){
        if($newgrade[$i] != NULL)
          $result = mysqli_query($db,"UPDATE Answers SET qgrade = '$newgrade[$i]' WHERE (eid = '$eid' AND uid = '$uid' AND qid = '$qid[$i]');");
      }
      
      for($i=0;$i<$c2;$i++){
        if($tcomments[$i] != NULL)
          $result = mysqli_query($db,"UPDATE Answers SET teachercom = '$tcomments[$i]' WHERE (eid = '$eid' AND uid = '$uid' AND qid = '$qid[$i]');");
      }     

      $ga =  mysqli_query($db,"SELECT qgrade FROM Answers WHERE (eid = '$eid' AND uid = '$uid');");
      $fgrades = mysqli_fetch_array($ga);
      $finalgrade = array_sum($fgrades);
      $fg = mysqli_query($db,"UPDATE Grades SET grade = '$finalgrade' WHERE (eid = '$eid' AND uid = '$uid');");      
			$release = mysqli_query($db,"UPDATE Grades SET Grades.release = 'r' WHERE (eid = '$eid' AND uid = '$uid');");
			if (!$release) {
                mysqli_close($db);
                die(json_encode(array(
                    "status" => -1,
                    "message" => "query failed")));
            }

            $return['status'] = 1;
            mysqli_close($db);
            die(json_encode($return));
//        }
//    }
?>
