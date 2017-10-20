<!DOCTYPE html>
<html>
    <head>
	   <h1>Add Questions</h1>
    </head>
    <body>
		<form name="addQuestion" method="post" action="addQuestionSend.php">
           <p>
            	Write a function named <input type="text" name="functionName" size=20>
                that takes 
                <select name="args">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                </select>
                argument(s) and <input type="text" name="return" size='80'>(ex.. "returns the sum")<br>
                   
           </p>
           <p>
                Answer:<textarea type="text" name="answer" id="answer" rows=20 cols=80></textarea>
           </p>
           <p>
           <input type="submit" name="submit" id="submit" value="Submit">
           </p>
        </form>
        <form name="backLogin" action="teacherHome.php">
          <input type="submit" name="submit" id="submit" value="back to menu">
        </form>
    </body>
</html>
