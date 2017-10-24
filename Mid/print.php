//loginmid.php

<?php
    
    $contents = file_get_contents('php://input');
    
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/Login.php");
    curl_setopt($db, CURLOPT_POST, 1);
    curl_setopt($db, CURLOPT_POSTFIELDS, "$contents");   
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db); 
    
    echo $dbexec;
    
?>


//grade.php --------------------------------------

<?php
    
    $grade = 0;
    $arr = array($_POST['inputone'],$_POST['inputtwo'],$_POST['inputthree'],$_POST['inputfour']);
    $contents = file_get_contents('php://input');
    
    //get array of rules from db
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/GetGradingRubric.php");  
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);
    
    $rules = json_decode($dbexec);
    $first = $rules->{'0'}; 
    $second = $rules->{'1'};
    $third = $rules->{'2'};
    $fourth = $rules->{'3'};
    
    while (list($key, $studentCode) = each($arr)) {
        //execute java grader
        $temp = exec("java grade '$studentCode' '$first' '$second' '$third' '$fourth'");
        $grade = $grade + $temp;
    }
    
    //send to backend
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ad379/SetStudentGrade.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "$contents&grade=$grade");   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $gradecurl = curl_exec($ch); 
    curl_close($ch);
    
    //echo "$grade\n";
?>

//mid_addQuestions.php --------------------------------------

<?php
    
    $contents = file_get_contents('php://input');
    
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/CreateQuestion.php");
    curl_setopt($db, CURLOPT_POST, 1);
    curl_setopt($db, CURLOPT_POSTFIELDS, "$contents");   
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);  
    
    echo $dbexec; 
    
?>

//mid_createExam.php --------------------------------------

<?php
    
    $contents = file_get_contents('php://input');
    
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/CreateExam.php");
    curl_setopt($db, CURLOPT_POST, 1);
    curl_setopt($db, CURLOPT_POSTFIELDS, "$contents");   
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);  
    
    echo $dbexec;
    
?>

//mid_getExam.php --------------------------------------

<?php
    
    $contents = file_get_contents('php://input');
    
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/GetExam.php");
    curl_setopt($db, CURLOPT_POST, 1);
    curl_setopt($db, CURLOPT_POSTFIELDS, "$contents");   
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);  

    echo $dbexec;
    
?>

//mid_ListStudentExams.php --------------------------------------

<?php
    
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/ListStudentExams.php"); 
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);  

    echo $dbexec;
    
?>

//mid_selectQuestions.php --------------------------------------

<?php
    
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/GetBank.php");  
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);     
    
    echo $dbexec;
        
?>

//mid_releaseGrade.php --------------------------------------


<?php
    
    $contents = file_get_contents('php://input');
    
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/ReleaseExams.php");
    curl_setopt($db, CURLOPT_POST, 1);
    curl_setopt($db, CURLOPT_POSTFIELDS, "$contents");   
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);  

?>


//mid_sendReleaseGrade.php --------------------------------------


<?php
    
    $contents = file_get_contents('php://input');
    
    $db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~ad379/backendController.php");
    curl_setopt($db, CURLOPT_POST, 1);
    curl_setopt($db, CURLOPT_POSTFIELDS, "$contents");   
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $dbexec = curl_exec($db); 
    curl_close($db);  

?>


//grade.java --------------------------------------

import java.io.*;

class grade{

   public static void main(String[] args) throws IOException{ 

         String text = "", rules = "", ruletext, temp;
         int currgrade = 0, points = 0, i = 0;
     
         //get student code and store to variable 'text
         text = args[0];  
          
         //store rules into an array
         String[] rulearray = {args[1],args[2],args[3],args[4]};
         
         //grading
         while (i < rulearray.length){
              ruletext = rulearray[i];
              points = grade(ruletext, text);
              currgrade = currgrade + points;
              points = 0;
              i++; 
          } 
          
          //25 points max per question
          if(currgrade > 25){
              currgrade = 25;
          }
        
          System.out.println(currgrade);  
     
  }
  
     public static int grade(String x, String text){
     int count = 0;
     
     if(text.contains(x)){        
                count = count + 25;      
            } else{       
                //do nothing            
            }       
           return count;         
          }  

} 
