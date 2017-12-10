<?php
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
      $uid = $_POST['uid'];
      $eid = $_POST['eid'];
      $return = array();
      $result = mysqli_query($db,"Select qid,question,answer,qgrade,points,comments,tcdata From (SELECT Answers.qid,question,answer,qgrade,points,comments,tcdata,uid,eid FROM Answers Inner Join Bank on (Answers.qid = Bank.qid)) As T1 Where (uid= '$uid' And eid= '$eid');");
            while ($row = mysqli_fetch_assoc($result)) {
                $return[] = $row;
            }

      mysqli_close($db);
      $je = (json_encode($return));
      echo $je;      
?>
