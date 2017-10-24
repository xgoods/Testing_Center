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
      $a = mysqli_query($db,"SELECT grade FROM Grades WHERE (Grades.release='r' AND eid=$eid);");
      $exams = mysqli_fetch_array($a);
      if ($exams) {
            $result = mysqli_query($db,"SELECT grade FROM Grades WHERE (uid='$uid' AND eid='$eid');");
            $return = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $return[] = $row['grade'];
            }
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
