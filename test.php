<?php
session_start();
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        if ($user=="student1"){}
        else{
            header("Location:index.html");
            exit;
        }
    }
    else{
        header("Location:index.html");
        exit;
    }
?>

<!DOCTYPE html>
<html>
   
   <head>
      <title>Welcome!</title>
      <meta http-equiv="Content-type" content="text/html"; charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>

  <body>
<?php 
  
  $value = $_POST["exam"];
  $userName = $_SESSION["user"];

  $url = "https://web.njit.edu/~ad379/GetExam.php";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $value);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $takeExam = curl_exec($ch);
  $examArray = array();
  curl_close($ch);
  $questionArray = json_decode($takeExam, true);

  echo "<div name='header'>EXAM $examName</div>";
//  echo "<form name='examSelect' id='takeExam' method='post' tion='test.php'";
  //  echo "<h1>EXAM $value</h1>";
    //$examName = $_POST['examSelect'];
  foreach($questionArray as $question) {
    echo "<p>".$question."</p>";
    echo "Answer: <form name='form_name'>
      <textarea name='count[]' rows=20 cols=80></textarea>
    </form>";
  }
    
    echo "<input type='textbox' name='examName' value='$examName'>";
    echo "<p>";
    echo "<input type='submit' name='submit' value='Submit' onclick='func()'>";
    echo "</p>";
    array_push($examArray, $_POST['userName']);
    array_push($examArray, $_POST['examName']);

    $an = array_merge($examArray, $_POST['count']);
    
    echo "</form>";
    $finalArray = implode(' ',$an);
    
    $url2 = "https://web.njit.edu/~kl297/grade.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url2);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "array=$finalArray");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $hello = curl_exec($ch);
    curl_close($ch);
    
  //  echo $hello;
?>
</body>
</html>
