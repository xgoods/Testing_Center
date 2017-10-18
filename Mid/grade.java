import java.io.*;
import java.nio.file.*;
import java.io.File;
import java.util.List; 
import java.util.ArrayList;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

class grade{

   public static void main(String[] args) throws IOException{ 

         String text = "", rules = "", ruletext;
         int currgrade = 25, deduct = 0, i = 0;
     
         //get student code and store to variable 'text'
         text = args[0];  
          
         //store rules into an array
         List<String> rulearray = new ArrayList<>();  
         Path filePath = Paths.get("");
         String s = filePath.toAbsolutePath().toString();   
         try{
             for (String rline : Files.readAllLines(Paths.get(s+"/rules.txt"))) {
                 for (String part : rline.split("\\r?\\n")) {
                    rulearray.add(part);
              }
            }
         }
         catch(Exception e){
              System.out.println("error");
         } 
         
         //grading
         while (i < rulearray.size()){
              ruletext = rulearray.get(i);
              deduct = grade(ruletext, text);
              currgrade = currgrade - deduct;
              deduct = 0;
              i++; 
          } 
          
          //deduct 25 points max per question
          if(currgrade < 0){
              currgrade = 0;
          }
        
          System.out.println(currgrade);  
     
  }
  
     public static int grade(String x, String text){
     int count = 0;
     
     if(text.contains(x)){        
               //do nothing        
            } else{       
                count = count + 3;            
            }       
           return count;         
          }  

}
