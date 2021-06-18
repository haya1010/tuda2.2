<?php
require("includes/header.php");
require("includes/classes/Group.php");

$shownUserId = $_REQUEST["shownUserId"];
$shownUserInfo = Info::getUserInfoById($con, $shownUserId);

if (!empty($_POST)) {
    $groupId = $_POST["groupId"];

    if (isset($_POST["join"])) {
        Group::joinAction($con, $userId, $groupId);
    }
    
    if (isset($_POST["unJoin"])) {
        Group::unJoinAction($con, $userId, $groupId);
    }
    
}

?>
    <div class="container">
        <div class="title">
                <a href="user.php?id=<?php echo $shownUserId; ?>"><h1><?php echo $shownUserInfo["username"]; ?>のTodo</h1></a>
                <h2><a href="post.php">todoを作成</a></h2>
                <br>
        </div>
        <br>
        <br>

        <?php
        $groups = $con->query("SELECT * FROM groups");
        while ($group = $groups->fetch()) :
            $groupId = $group["id"];
            $groupName = $group["groupName"];
            // echo $groupName;

            $query = $con->prepare("SELECT * FROM groupmember WHERE groupId=:groupId");
            $query->bindValue(":groupId", $groupId);
            $query->execute();
            $rowcount = $query->rowcount();
            // echo $rowcount;
        ?>
            <?php if (Group::alreadyMemberOrNot($con, $shownUserId, $groupId)): ?>
                <a href="groupIndex.php?groupId=<?php echo $groupId; ?>"><?php echo $groupName; ?></a>
                <span><?php echo $rowcount; ?>人</span>
                <br>
                <br>
                <form method="POST">
                    <?php if (Group::alreadyMemberOrNot($con, $userId, $groupId)): ?>
                        <input type="submit" name="unJoin" value="退会">
                    <?php else : ?>
                        <input type="submit" name="join" value="グループに参加">
                    <?php endif; ?>
                    <input type="hidden" name="groupId" value="<?php echo $groupId; ?>">
                </form>
            <?php endif; ?>

        <?php endwhile; ?>
    </div>
</body>
</html>