<?php
// ob_start(); // Turns on output buffering
// session_start();

// date_default_timezone_set("Asia/Tomsk");

// try {
//     $con = new PDO('mysql:dbname=tuda;host=localhost;port=8889', 'root', 'root');
//     $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
// }
// catch (PDOException $e){
//     exit("Connection failed: " . $e->getMessage());
// }
session_start();
try {
    $con = new PDO('mysql:dbname=tuda2;host=localhost;port=8889;charset=utf8',
    'root', 'root');
} catch(PDOException $e) {
    print('DB接続エラー:' . $e->getMessage());
}
?>