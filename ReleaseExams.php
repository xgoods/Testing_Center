<?php
    class ReleaseExams {
        public function post($db, $data) {
            $eid = $data['eid'];
            $result = mysqli_query($db,
                "SELECT User.uid, Grades.eid, Grades.grade FROM User LEFT OUTER JOIN Grades
                 ON User.uid = Grades.uid && Grades.eid = $eid
                 WHERE User.role = 'student';");
            if (!$result) {
                mysqli_close($db);
                die(json_encode(array(
                    "status" => -1,
                    "message" => "query failed")));
            }
			
			$release = mysqli_query($db,"UPDATE Exams SET released = 'r' WHERE eid = $eid;");
			if (!$release) {
                mysqli_close($db);
                die(json_encode(array(
                    "status" => -1,
                    "message" => "query failed")));
            }
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
        }
    }
?>
