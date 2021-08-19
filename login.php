<?php

require("includes/config.php");
require("includes/classes/Constants.php");
require("includes/classes/Account.php");

$account = new Account($con);

if (isset($_POST["loginButton"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $loginId = $account->login($username, $password);
    // var_dump($loginId);
    if ($loginId) {
        // echo '----inif----';
        $_SESSION["userLoggedIn"] = $loginId;
        header("Location: index.php");
    }
}
function getInputValue($name) {
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta name="google-site-verification" content="2oiQ7jpso5JMgpa3KvMJNFMkleQy1zg9Hving6N9Rwk" />
    <title>Tuda</title>
    <link rel="stylesheet" href="assets/style2.css">
</head>
<body>
    <div class="container">
        <div class="form">
            <h1 class="logo">Tuda</h1>
            <form method="POST">
                <span class="error"><?php echo $account->getError(Constants::$loginFailed); ?></span>
                <!-- <input type="text" name="username"　value="" required> -->
                <input type="text" name="username" placeholder="ユーザー名を入力" value="<?php getInputValue("username"); ?>" required>
                <br>
                <input type="password" name="password" placeholder="パスワードを入力してください" required>
                <br>
                <br>
                <input type="submit" name="loginButton" class="submit" value="ログイン">
            </form>
            <br>
            <a href="register.php">新規登録ページへ</a>
        </div>
    </div>
</body>
</html>
