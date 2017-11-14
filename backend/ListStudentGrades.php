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
      
      $contents = file_get_contents('php://input');
      $a = explode(" ",$contents);
      $uid = $a[0];
      $eid = $a[1];
      $return = array();
      $a = mysqli_query($db,"SELECT grade FROM Grades WHERE (Grades.release='r' AND eid=$eid);");
      $exams = mysqli_fetch_array($a);
      if ($exams) {
            $result = mysqli_query($db,"SELECT grade,comments FROM Grades WHERE (uid='$uid' AND eid='$eid');");
            
            while ($row = mysqli_fetch_assoc($result)) {
                $return['grade'] = $row['grade'];
                $return['comments'] = $row['comments'];
            }
/*
            $comments = mysqli_query($db,"SELECT qid,comments FROM Students WHERE (uid='$uid' AND eid='$eid');");
            while ($crow = mysqli_fetch_assoc($comments)) {
                $return[] = $crow;
            }
*/
            mysqli_close($db);
            $je = (json_encode($return));
            echo $je;
      } else {
            $result['status'] = 0;
            mysqli_close($db);
            $je = (json_encode($result));
            echo $je;        
     }
//        }
//    }
?>
