<?php

if (isset($_POST['submitButton'])){
   session_start();
    $username = $_POST["user"];
    $password = $_POST["pass"];
    
   
    $creds = array('username'=>$username,'password'=>$password);
    $credsToSend = json_encode($creds);
    $mid = curl_init();
    curl_setopt($mid, CURLOPT_URL, "https://web.njit.edu/~bg245/loginmid.php");
    curl_setopt($mid, CURLOPT_POST, 1);
    curl_setopt($mid, CURLOPT_POSTFIELDS, $credsToSend);   
    curl_setopt($mid, CURLOPT_FOLLOWLOCATION, 1);
    $midexec = curl_exec($mid);
    curl_close($mid);
    
          
}
?>