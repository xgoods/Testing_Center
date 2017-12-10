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
        $uid = $_POST['uid'];
        $result = mysqli_query($db, "SELECT eid FROM Grades WHERE (uid = '$uid');");
        if (!$result) {
            mysqli_close($db);
            die(json_encode(array(
                "status" => -1,
                "message" => mysqli_connect_error())));
        }
        $return = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $eid = $row['eid'];
            $result1 = mysqli_query($db, "SELECT name FROM Exams WHERE (eid = '$eid');");
            $row1 = mysqli_fetch_assoc($result1);
            $return[] = $row1['name'];
        }
//        $return['status'] = 1;
        mysqli_close($db);
        $je = (json_encode($return));
        echo $je;

//	}
//}
?>
