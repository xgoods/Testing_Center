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
      $uid = $_POST['uid'];
      $eid = $_POST['eid'];
      $return = array();
      $n=1;
      
      $a = mysqli_query($db,"SELECT grade FROM Grades WHERE (Grades.release='r' AND eid=$eid);");
      $exams = mysqli_fetch_array($a);
      if ($exams) {
      
      $result = mysqli_query($db,"SELECT qid,question,answer,qgrade,points,comments,tcdata,teachercom FROM (SELECT Answers.qid,question,answer,qgrade,points,comments,tcdata,uid,eid,teachercom FROM Answers INNER JOIN Bank ON (Answers.qid = Bank.qid)) AS T1 WHERE (uid= '$uid' And eid= '$eid');");
      
      $finalgrade =  mysqli_query($db,"(SELECT grade,totalpoints FROM Grades Inner Join Exams on (Grades.eid = Exams.eid) WHERE (uid = '$uid' AND Grades.eid = '$eid'));");
      $fg = mysqli_fetch_assoc($finalgrade);
      $return['finalgrade'] = $fg;

      while ($row = mysqli_fetch_assoc($result)) {
          $return[$n] = $row;
      }
      
/*      
      
            $result = mysqli_query($db,"SELECT grade,comments FROM Grades WHERE (uid='$uid' AND eid='$eid');");
            
            while ($row = mysqli_fetch_assoc($result)) {
                $return['grade'] = $row['grade'];
                $return['comments'] = $row['comments'];
            }
            $aarr = array();
            $result = mysqli_query($db,"SELECT answer FROM Answers WHERE (uid='$uid' AND eid='$eid');");
            while ($arow = mysqli_fetch_assoc($result)) {
                $aaar[] = $arow['answer'];
            }
            $answers = implode('~',$aaar);
            $return['answers'] = $answers;
            
            $qarr = array();
            $exams = mysqli_query($db, "SELECT Bank.question FROM ((SELECT * FROM QAA WHERE (QAA.eid='$eid')) AS T1) INNER JOIN (Bank) ON (Bank.qid = T1.qid);");
            while ($qrow = mysqli_fetch_assoc($exams)) {
                $qaar[] = $qrow['question'];
            }
            $questions = implode('~',$qaar);
            $return['questions'] = $questions;
*/           
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
