<?php
  $examName = $_POST['examName'];
  $url = "https://web.njit.edu/~kl297/mid_sendReleaseGrade.php";
  $post = "examName=".$examName;
  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $sendExam = curl_exec($ch);
  curl_close($ch);
  echo $sendExam;
  
  header("Location:https://web.njit.edu/~bg245/teacherHome.php");
?>
