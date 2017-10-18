import java.io.*;
import java.nio.file.*;
import java.io.File;
import java.util.List; 
import java.util.ArrayList;

class grade{

   public static void main(String[] args) throws IOException{ 

         String text = "", rules = "", ruletext;
         int currgrade = 25, deduct = 0, rulecount = 5, i = 0;
      
         //get student code and store to variable 'text'
         Path studentPath = Paths.get("");
         String s = studentPath.toAbsolutePath().toString();   
         FileReader file = new FileReader(s+"\\tograde.txt");
         BufferedReader reader = new BufferedReader(file);
  
         String sline = reader.readLine();
      
         while (sline != null){
              text = text + sline;
              sline = reader.readLine();
          }   
          
         //store rules into an array
         List<String> rulearray = new ArrayList<>();  
      
         try{
             for (String rline : Files.readAllLines(Paths.get(s+"\\rules.txt"))) {
                 for (String part : rline.split("\\r?\\n")) {
                    rulearray.add(part);
              }
            }
         }
         catch(Exception e){
              System.out.println("error");
         }
      
         //grading
         while (i < rulearray.size()-1){
              ruletext = rulearray.get(i);
              deduct = grade(ruletext, text);
              currgrade = currgrade - deduct;
              deduct = 0;
              rulecount--;
              i++; 
          }
          
          //deduct 25 points max per question
          if(currgrade < 0){
              currgrade = 0;
          }
          
          System.out.println("you received " + currgrade + " points");  
     
  }
  
     public static int grade(String x, String text){
     int count = 0;
     
     if(text.contains(x)){
            
               //donothing
            
            } else{
            
                count = count + 3;
                System.out.println("did not properly implement '" + x + "' within the code");
            
            }
           
           return count;
            
          }  

}
