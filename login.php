<?php
class Login {
	public function post($data,$db) {
		$user = $data['user'];
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
		elseif($data['pass'] == $row['pass']) {
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
		die(json_encode(array(
			"status" => $status,
			"message" => $message,
			"role" => $role)));
	}
}
?>
