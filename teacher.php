<?php
session_start();
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        if ($user=="teacher1"){}
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

    <div class="header">Teacher's Platform</div>
        
    <div class="sidebar bar-block animate-left" style="display:none;z-index:5" id="sidebar">
        <button class="bar-item buttonBar large" style="color: rgba(79, 80, 73, 1); background-color: rgba(1, 55, 6, 0.24);" onclick="bar_close()">Close &times;
        </button>
        <a href="grades.php" class="bar-item buttonBar">Grades</a>
        <a href="addquest.php" class="bar-item buttonBar">Add Questions</a>
        <a href="createexam.php" class="bar-item buttonBar">Create Exams</a>
        <a href="index.html" class="bar-item buttonBar">Log out</a>
    </div>

    <div class="overlay animate-opacity" onclick="bar_close()" style="cursor:pointer" id="overlay">
    </div>
 
    <div> 
        <button class=" buttonBar btnLay xxlarge" onclick="bar_open()">&#9776;
        </button>
    </div>

    <div class="content display-container" style="width:2%; height: 80%;">
        <img class="teacherImg" name="slides" src="./teacher.jpg">
        <img class="teacherImg" name="slides" src="./teacher2.jpg">
        <img class="teacherImg" name="slides" src="./teacher3.jpg">

        <button class="buttonBar black display-left" onclick="plusDivs(-1)">&#10094;
        </button>
        <button class="buttonBar black display-right" onclick="plusDivs(1)">&#10095;
        </button>
    </div>

    <div class="teacherMain">Welcome, to the teacher page. Here you can 
    add questions, create exams, and release grades for the exams...
    </div>
    
    <div class='fti'>       
        <img src="./img2.jpg"> 
    </div>

    <script>
        function bar_open() {
            document.getElementById("sidebar").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }
        function bar_close() {
            document.getElementById("sidebar").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }
    </script>

    <script>
        var slideIndex = 1;
        showDivs(slideIndex);

        function plusDivs(n) {
        showDivs(slideIndex += n);
        }

        function showDivs(n) {
        var i;
        var x = document.getElementsByName("slides");
        if (n > x.length) {slideIndex = 1}    
        if (n < 1) {slideIndex = x.length}
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";  
        }
        x[slideIndex-1].style.display = "block";  
        }
    </script>
    
</body>
    
</html>
