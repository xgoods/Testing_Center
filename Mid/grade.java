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
