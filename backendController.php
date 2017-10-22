<?php
/* backendController.php
 * central backend hub - routes all requests from middle based
 * on a command field
 */
 
require 'Login.php';
require 'CreateQuestion.php';
require 'GetBank.php';
require 'CreateExam.php';
require 'ListExams.php';
require 'GetExam.php';
require 'GetGrades.php';
require 'SetStudentAnswers.php';
require 'SetStudentGrade.php';
require 'GetStudentAnswer.php';
require 'ReleaseExams.php';
$data = json_decode(file_get_contents('php://input'),true);
$action;
if (!isset($data['cmd'])) {
	http_response_code(501);
	die(json_encode(array(
		"message" => "command field not set")));
}
$db=mysqli_connect("sql2.njit.edu","ad379","admin","ad379");
if (mysqli_connect_errno()) {
	http_response_code(500);
	die(json_encode(array(
		"status" => -1,
		"message" => mysqli_connect_error())));
}
switch ($data['cmd']) {
	case "login":
		$action = new Login;
		$action->post($data,$db);
		break;
	case "createQuestion":
		$action = new CreateQuestion;
		$action->post($data['data'],$db);
		break;
	case "getBank":
		$action = new GetBank;
		$action->post($db, $data['data']);
		break;
	case "createExam":
		$action = new CreateExam;
		$action->post($data['data'],$db);
		break;
	case "listExams":
		$action = new ListExams;
		$action->post($data,$db);
		break;
	case "getExam":
		$action = new GetExam;
		$action->post($data,$db);
		break;
	case "getGrades":
		$action = new GetGrades;
		$action->post($data,$db);
		break;
	case "setStudentAnswers":
		$action = new SetStudentAnswers;
		$action->post($data,$db);
		break;
	case "setStudentGrade":
		$action = new SetStudentGrade;
		$action->post($data,$db);
		break;
	case "getStudentAnswer":
		$action = new GetStudentAnswer;
		$action->post($db);
		break;
    	case "release":
		$action = new ReleaseExams;
		$action->post($db, $data['data']);
		break;
}
http_response_code(501);
mysqli_close($db);
die(json_encode(array(
	"message" => "invalid command or not yet implemented")));
?>
