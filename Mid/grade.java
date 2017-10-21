import java.io.*;
/*import java.nio.file.*;
import java.io.File;
import java.util.List; 
import java.util.ArrayList;*/


class grade{

   public static void main(String[] args) throws IOException{ 

         String text = "", rules = "", ruletext, temp;
         int currgrade = 0, points = 0, i = 0;
     
         //get student code and store to variable 'text
         text = args[0];  
          
         //store rules into an array
         temp = args[1];
         temp = temp.substring(1,temp.length()-1); 
         String[] rulearray = temp.split(",");
         
         /*List<String> rulearray = new ArrayList<>();  
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
         }*/ 
         
         //grading
         while (i < rulearray.length){
              ruletext = rulearray[i];
              points = grade(ruletext, text);
              currgrade = currgrade + points;
              points = 0;
              i++; 
          } 
          
          //deduct 25 points max per question
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
