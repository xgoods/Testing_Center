   	$db = curl_init();
    curl_setopt($db, CURLOPT_URL, "https://web.njit.edu/~kl297/grade.php");
    curl_setopt($db, CURLOPT_POST, 1);
    curl_setopt($db, CURLOPT_POSTFIELDS, "array=$finalArray");
    curl_setopt($db, CURLOPT_RETURNTRANSFER, 1);
    $hello = curl_exec($db);
    curl_close($db);
        
    echo $hello;
