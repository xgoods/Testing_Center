<?php
    $first = 'def test1(one,two,three): 
  added = one + two + three
  return added
exec = test1(3,4,5)
print(exec)';
    $second = 'def test2(one,two,three): test2(9,3,5); return';
    $third = 'def test3(one,two,three): test3(9,3,5); return';
    $fourth = 'def test1(one,two): test1(3,5); return';
    $briansarray = array("student1","0","$first","$second","$third","$fourth");
//-----------------
    $ansarray = array();
    $j = 2;
    for ($i = 0; $i < 4; $i++){
        file_put_contents('test.py', $briansarray[$j]);
        if(`python test.py` !== null){
            $ansarray[$i] = `python test.py`;
        } else{
            $ansarray[$i] = 'null';
        }
        $j += 1;     
    }
    $code = implode('~', $briansarray);
    $answers = implode('~',$ansarray);
//----------------------
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~kl297/grade.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "code=$code&answers=$answers");   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $gradecurl = curl_exec($ch); 
    curl_close($ch); 
    echo $gradecurl;
    
?>
