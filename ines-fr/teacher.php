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
        <a href="gradesT.php" class="bar-item buttonBar">Grades</a>
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

     <div class="slideshow-container">
        <div class="slides fade">
            <div class="numbertext"></div>
            <img class="teacherImg" src="./teacher.jpg" style="width:100%">
            <a class="text" href="https://www.python.org/">Official python.org</a>
        </div>

        <div class="slides fade">
            <div class="numbertext"></div>
            <img class="teacherImg" src="./teacher3.jpg" style="width:100%">
            <a class="text" href="http://docs.python-guide.org/en/latest/intro/news/">latest Python news</a>
        </div>

        <div class="slides fade">
            <div class="numbertext"></div>
            <img class="teacherImg" src="./teacher2.jpg" style="width:100%">
            <a class="text" href="http://planetpython.org/">Planet Python</a>
        </div>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
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
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }
        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("slides");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slides[slideIndex-1].style.display = "block";
        } 
    </script>
    
</body>
    
</html>
