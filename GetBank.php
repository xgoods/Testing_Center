<?php
class GetBank {
   public function post($db, $data) {
        if (!isset($data)) {
            $result = mysqli_query($db, "SELECT * FROM Bank;");
        }
/*        else if (!isset($data['type'])) {
            $result = mysqli_query($db, "SELECT * FROM Bank;");
        }
*/
        else {
           die(json_encode(array(
               "status" => -1,
               "message" => "unrecognized json"
           )));
        }
        if (!$result) {
            mysqli_close($db);
            die(json_encode(array(
                "status" => -1,
                "message" => mysqli_connect_error())));
        }
        $return = array();
        while ($row = mysqli_fetch_array($result)) {
            $return[$row['qid']] = array($row['qid'] => $row);
        }
        $return['status'] = 1;
        mysqli_close($db);
        die(json_encode($return));
    }
}
?>
