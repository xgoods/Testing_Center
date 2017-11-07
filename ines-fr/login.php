<?php
if (isset($_POST['submit'])){
    session_start();
    $username = $_POST["user"];
    $password = $_POST["pass"];
    
   
    $post = 'user='.$username.'&pass='.$password;
    $mid = curl_init();
    curl_setopt($mid, CURLOPT_URL, "https://web.njit.edu/~kl297/loginmid.php");
    curl_setopt($mid, CURLOPT_POST, 1);
    curl_setopt($mid, CURLOPT_POSTFIELDS, $post);   
    curl_setopt($mid, CURLOPT_RETURNTRANSFER, 1);
    $midexec = curl_exec($mid);
    curl_close($mid);
    
    
    $rules = json_decode($midexec);
    $status = $rules->{'status'}; 
    $role = $rules->{'role'};
    $_SESSION["user"] = $username;
    if($status == "1"){
        $login = strcmp($role, "teacher");
        if(!$login){
            header("Location:teacher.php");
            exit;
        }
        else{
            header("Location:student.php");
            exit;
        }
    }
    else{
        echo "invalid credentials";
        header("Location:index.html");
    }
}  
?>
