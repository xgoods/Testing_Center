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
      $eid = $contents[0];//$_POST['examName'];
			$release = mysqli_query($db,"UPDATE Grades SET Grades.release = 'r' WHERE eid = $eid;");
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
