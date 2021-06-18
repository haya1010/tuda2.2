<?php
require("includes/config.php");
require("includes/classes/Info.php");
require("includes/classes/Likes.php");
require("includes/classes/Follow.php");

if (!isset($_SESSION["userLoggedIn"])) {
    header("Location: login.php");
}

$userId = $_SESSION["userLoggedIn"];
$userInfo = Info::getUserInfoById($con, $userId);

if (isset($_REQUEST["id"])) {
    $shownUserId = $_REQUEST["id"];
    $shownUserInfos = Info::getUserInfoQueryById($con, $shownUserId);
    if ($shownUserInfos->rowcount() == 1) {
        $shownUserInfo = $shownUserInfos->fetch();
    }
    else {
        header("Location: index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <title>Tuda2.2</title>
    <link rel="stylesheet" href="assets/style2.css?v=2">
    <script src="https://kit.fontawesome.com/a443d77f9e.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="header">
        <a class="logo" href="index.php">
            <h1>Tuda2.2</h1>
        </a>
        <div class="nav">
            <ul>
                <li><a href="user.php?id=<?php echo $userId; ?>"><?php echo $userInfo["username"]; ?></a></li>
                <li><a href="logout.php">ログアウト</a></li>
            </ul>
        </div>
    </div>