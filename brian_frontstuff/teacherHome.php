<!DOCTYPE html>
<html>
    <head>
        <h1>Welcome Teacher</h1>
    </head>
    <body>
        <form name="addQuestion" method="post" action="addQuestion.php">
            <p>
                <input type="button" value="Add Question" onclick="location.href='addQuestion.php'">
            </p>
        </form>
        <form name="createExam" method="post" action="selectQuestions.php">
            <p>
                <input type="button" value="Create Exam" onclick="location.href='selectQuestions.php'">
            </p>
        </form>
        <form name="releaseGrade" method="post" action="frontRelease.php">
            <p>
                <input type="button" value="Release Grades" onclick="location.href='releaseGrade.php'">
            </p>
        </form>
        <form name="backLogin" action="index.html">
          <input type="submit" name="submit" id="submit" value="Back to Login">
        </form>
	</body>
</html>
