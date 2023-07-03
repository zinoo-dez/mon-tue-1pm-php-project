<?php
setcookie("name", "bobo", time() + 60 * 60 * 24 * 30, "/", "", 0);
setcookie("age", "20", time() + 60, "/", "", 0);
setcookie("gender", "male", time() + 60, "/", "", 0);

echo $_COOKIE['name'];
echo $_COOKIE['age'];
echo $_COOKIE['gender'];
echo time();
    // 01/01/1970 timestamps
    // setcookie($key, $value, $time, $path, $domain, $secure);

// $password = "hello";
// $hash = password_hash($password, PASSWORD_BCRYPT, [rand()]);
// echo $hash;
// if (password_verify("hello", $hash)) {
//     echo "match";
// } else {
//     echo "wrong";
// }