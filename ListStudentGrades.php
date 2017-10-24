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
      $uid = $_POST['uid'];
            $return = array();
            while ($row = mysqli_fetch_array($result)) {
                if ($row['grade'] == null) {
                    $uid = $row['uid'];
                    $insert = mysqli_query($db,
                        "INSERT INTO Grades(uid, eid, grade) VALUES( ('$uid'), $eid, 0);");
                    $return[$row['uid']] = array($row['uid'] => $row);
                }
                else {
                    $return[$row['uid']] = array($row['uid'] => $row);
                }
            }
            $return['status'] = 1;
            mysqli_close($db);
            die(json_encode($return));
//        }
//    }
?>
