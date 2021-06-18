<?php  
require("includes/config.php");
require("includes/classes/Constants.php");
require("includes/classes/Account.php");
// var_dump($_POST);

$account = new Account($con);
if (isset($_POST["submitButton"])) {
    $username = $_POST["username"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];

    $success = $account->register($username, $password1, $password2);
    
    // var_dump($loginId);
    if ($success) {
        // echo '------inif-----';

        $_SESSION["userLoggedIn"] = $account->login($username, $password1);
        // $_SESSION["userLoggedIn"] = $loginId;
        // var_dump($loginId);
        header("Location: index.php");
    }
}

function getInputValue($name) {
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
} 

// var_dump($account->errorArr);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Tuda</title>
    <link rel="stylesheet" href="assets/style2.css">
</head>
<body>
    <div class="container">
        <div class="form">
            <h1 class="logo">Tuda</h1>
            <form method="POST">
                <span class="error"><?php echo $account->getError(Constants::$duplicateRegister); ?></span>
                <input type="text" name="username" placeholder="ニックネーム" value="<?php echo getInputValue("username"); ?>" required>
                <br>
                <span class="error"><?php echo $account->getError(Constants::$passwordsDontMatch); ?></span>
                <span class="error"><?php echo $account->getError(Constants::$passwordLength); ?></span>
                <input type="password" name="password1" placeholder="パスワード" required>
                <br>
                <input type="password" name="password2" placeholder="パスワード確認用" required>
                <br>
                <br>
                <input type="submit" name="submitButton" class="submit" value="新規登録">
            </form>
            <br>
            <a href="login.php">ログインページへ</a>
        </div>
    </div>
</body>
</html>