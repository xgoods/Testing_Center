<?php
if (isset($_POST['submitButton'])){
    session_start();
    $contents = file_get_contents('php://input');
    
    $mid = curl_init();
    curl_setopt($mid, CURLOPT_URL, "https://web.njit.edu/~kl297/loginmid.php");
    curl_setopt($mid, CURLOPT_POST, 1);
    curl_setopt($mid, CURLOPT_POSTFIELDS, $contents);   
    curl_setopt($mid, CURLOPT_RETURNTRANSFER, 1);
    $midexec = curl_exec($mid);
    curl_close($mid);
    
    //echo $midexec;
    
    $rules = json_decode($midexec);
    $first = $rules->{'status'}; 
    $second = $rules->{'role'};
    
    if($first == "1"){
    $_SESSION["user"] = $username;
    $type_match = strcmp($second, "teacher");
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
    echo "<script language=\"JavaScript\">\n";
         echo "alert('invalid username/password');\n";
         echo "window.location='index.html'";
         echo "</script>";
  }
}
else
  echo "You must have a username and password."
   
?>
