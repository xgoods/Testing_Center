easy:
//1) Write an if/else function that takes 2 args and compares them and returns the larger one

def compare(a,b):
    if a > b:
        return a
    else:
        return b
    
compare = compare(2,3)
print(compare)  

//2) write a program that takes 3 args, a,b,N, and keeps adding N in a while loop and returns a once a > b. if a already > b, //return a

def whileadd(a,b,N):
    while a <= b:
        a = a + N
    return a
    
output = whileadd(1,5,2)
print(output)


//3) write an if else program that takes one arg, checks if it is positive or negative, else returns -1
def posorneg(a):
    if a > 0:
        return "positive"
    elif a < 0:
        return "negative"
    else:
        return -1
addarray = posorneg(-1)
print(addarray)

med:
//1) write a program that takes one arg, an array, returns largest integer in an array
large = [3,4,1,6]
def largest(a):
    curr = 0
    for i in range(len(large)):
        if large[i] > curr:
            curr = large[i]
    return curr
output = largest(large)
print(output)

//2) write a while program that takes one argument, an array, and adds elements
add = [1,2,3,4,5]
def addarray(add):
    total = 0
    for i in range(len(add)):
        total = total + add[i]
    return total
    
output = addarray(add)
print(output)


3) 


hard:
//1) operator

def operation(op,a,b):
    if op == "+":
        return a+b
    if op == "-":
        return a-b
    if op == "/":
        return a/b
    else:
        return -1
            
output = operation("z",2,3)
print(output)


2) 


3)
