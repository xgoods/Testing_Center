<?php
if (isset($_POST['submitButton'])){
    session_start();
    $contents = file_get_contents('php://input');
    
    $mid = curl_init();
    curl_setopt($mid, CURLOPT_URL, "https://web.njit.edu/~kl297/loginmid.php");
    curl_setopt($mid, CURLOPT_POST, 1);
    curl_setopt($mid, CURLOPT_POSTFIELDS, $contents);   
    curl_setopt($mid, CURLOPT_FOLLOWLOCATION, 1);
    $midexec = curl_exec($mid);
    curl_close($mid);
    
    if($midexec[0] == 1){
    $_SESSION["user"] = $username;
    $type_match = strcmp($midexec[1], "teacher");
    if(!$type_match){
        header("Location:https://web.njit.edu/~kl297/teacherHome.html");
        exit;
    }
    else{
        header("Location:https://web.njit.edu/~kl297/studentHome.html");
        exit;
    }
  }
  else {
    echo "The username and/or password is incorrect $midexec[0]."."<br>";
  }
}
else
  echo "You must have a username and password."
   
?>
