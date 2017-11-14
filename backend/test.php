<?php

$functionName = 'methodcurl';
$args = 2;
$return = 'returns an answer';
$question = 'Write a function named ' . $functionName . ' that takes ' . $args . ' argument(s) and ' . $return . ' ex.. returns the sum';
//$array = array('Write a function named test that takes 1 argument(s) and test', 'Write a function named test2 that takes 1 argument(s) and test2');
$array = array('student1','0');
//$post = implode(" ", $array);

$post = array('eid'=>'0');

$url = 'https://web.njit.edu/~ad379/SetStudentGrade.php';
//$data_string = http_build_query($data);
$errors = array('asdfasf0',
                'asdfasf1',
                'asdfasf2',
                'asdfasf3',
                'asdfasf4',);

$errors = implode("~", $errors);
    $data = array('uid'=>'student1',
                  'eid'=>5,
                  'grade'=>85,
                  'errors'=>$errors);

$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS, $data);

//execute post
$result = curl_exec($ch);
echo $result;

//close connection
curl_close($ch);

?>
