<!DOCTYPE html>
<html>
    <head>
        <h1>Welcome Student</h1>
    </head>
    <body>
        <form name="takeExam" method="get" action="takeExam.php">
            <p>
                <input type="button" value="Take Exam" onclick="location.href='frontSelectExam.php'">
            </p>
        </form>
        <form name="viewGrade" method="get" action="results.php">
            <p>
                <input type="button" value="View Exam Results" onclick="location.href='frontResults.php'">
            </p>
        </form>
        <form name="backLogin" action="index.html">
          <input type="submit" name="submit" id="submit" value="Back to login">
        </form>
	</body>
</html>
