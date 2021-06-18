<?php
require("includes/header.php");

if (!empty($_POST)) {
    $groupName = $_POST["groupName"];
    $errorArr = array();
    
    if (isset($_POST["makeGroupButton"])) {

        $query = $con->prepare("SELECT * FROM groups WHERE groupName=:groupName");
        $query->bindValue(":groupName", $groupName);
        $query->execute();
        
        if ($query->rowcount() != 0) {
            array_push($errorArr, "duplicateGroup");
        }
        
        if (empty($errorArr)) {
            
            $query = $con->prepare("INSERT INTO groups (groupName) VALUES (:groupName)");
            $query->bindValue(":groupName", $groupName);
            $query->execute();
    
            $query = $con->prepare("SELECT * FROM groups WHERE groupName=:groupName");
            $query->bindValue(":groupName", $groupName);
            $query->execute();
            $groupId = $query->fetch()["id"];

            $query = $con->prepare("INSERT INTO groupmember (memberId, groupId) VALUES (:memberId, :groupId)");
            $query->bindValue(":memberId", $userId);
            $query->bindValue(":groupId", $groupId);
            $query->execute();

            header("Location: showAllGroup.php");
            // echo "-----inif-----";
            // echo $groupName;
        }
        else {

        }
    }
}
else {
    $groupName = "";
}

?>

    <div class="container">
        <div class="title">
                <a href="user.php?id=<?php echo $userId; ?>"><h1><?php echo $userInfo["username"]; ?>のTodo</h1></a>
                <h2><a href="post.php">todoを作成</a></h2>
                <br>
        </div>
        <br>
        <br>

        <form method="POST">
        <!-- <span class="error"><?php  ?></span> -->
        <input type="text" name="groupName" placeholder="グループ名を入力" value="<?php echo $groupName; ?>">
        <input type="submit" name="makeGroupButton" value="グループを作成">
        </form>

    </div>
</body>
</html>