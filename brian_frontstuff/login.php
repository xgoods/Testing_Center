<?php
if(!empty($_POST['Username'] && $_POST['Password'])){
    $username = $_POST["user"];
    $password = $_POST["pass"];
    
    $creds = array('username'=>$username,'password'=>$password);
    $url = "https://web.njit.edu/~kl297/loginmid.php";
    $mid = curl_init();
    curl_setopt($mid, CURLOPT_URL, $url);
    curl_setopt($mid, CURLOPT_POST, 1);
    curl_setopt($mid, CURLOPT_POSTFIELDS, $creds);   
    curl_setopt($mid, CURLOPT_FOLLOWLOCATION, 1);
    $midexec = curl_exec($mid);
    curl_close($mid);
    
    if($midexec[0] == 1){
    $_SESSION["user"] = $username;
    $type_match = strcmp($midexec[1], "t");
    if(!$type_match){
        header("Location:https://web.njit.edu/~bg245/teacherHome.php");
        exit;
    }
    else{
        header("Location:https://web.njit.edu/~bg245/studentHome.php");
        exit;
    }
  }
  else {
    echo "The username and/or password is incorrect."."<br>";
  }
}
else
  echo "You must have a username and password."
   
?>
