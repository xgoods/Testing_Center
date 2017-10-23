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
    
    $user = $_POST['user'];
    $pass = $_POST['pass'];
		$result = mysqli_query($db, "SELECT * FROM User WHERE uid = '$user';");
		if (!$result) {
			mysqli_close($db);
			die(json_encode(array(
				"status" => -1,
				"message" => mysql_error())));
		}
		$row = mysqli_fetch_array($result);
		if ($row == NULL) {
			http_response_code(401);
			$status = 0;
			$message = "not authorized";
			$role = "";
		}
		elseif($pass == $row['pass']) {
			$status = 1;
			$message = "authorized";
			$role = $row['role'];
		}
		else {
			http_response_code(401);
			$status = 0;
			$message = "not authorized";
			$role = "";
		}
		mysqli_close($db);
		$json_encode = (json_encode(array(
			'status' => $status,
      'role' => $role,
			'message' => $message
			)));
      echo $json_encode;
//	}
//}
?>
