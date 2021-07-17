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

// ↓ローカルで使う時
// session_start();
// try {
//     $con = new PDO('mysql:dbname=tuda2;host=localhost;port=8889;charset=utf8',
//     'root', 'root');
// } catch(PDOException $e) {
//     print('DB接続エラー:' . $e->getMessage());
// }
// ↑ローカルで使う時

// ↓リモートで使う時
session_start();
try {
    $con = new PDO('mysql:dbname=heroku_2687c39ba144552;host=us-cdbr-east-04.cleardb.com;charset=utf8',
    'b6d756068fa695', '0d92fdd5');
} catch(PDOException $e) {
    print('DB接続エラー:' . $e->getMessage());
}
// ↑リモートで使う時

?>
