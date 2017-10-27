import sys

student_text, ruletext = "", ""
currgrade, points, i = 0, 0, 0

#get student code and assign it to 'text'
student_text = sys.argv[1]
  
#store rules into array
rulearray = [sys.argv[2], sys.argv[3], sys.argv[4], sys.argv[5]]

#function to check if method is within student input
def grade(rules, student_text):
    count = 0
    
    if rules in student_text:
      count = 5
      return count
    else:
      count = 0
      return count

while(i < len(rulearray)):
    ruletext = rulearray[i];
    points = grade(ruletext, student_text)
    currgrade = currgrade + points
    points = 0
    i += 1
 
if(currgrade > 5):
    currgrade = 5
  
print(currgrade)
  
