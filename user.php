<?php
require("includes/header.php");

if (isset($_POST["followButton"])) {
    Follow::followAction($con, $userId, $shownUserId);
}
if (isset($_POST["unFollowButton"])) {
    Follow::unFollowAction($con, $userId, $shownUserId);
}

$userLike = Likes::getUserLike($con, $shownUserId);
if (isset($_POST["likeButton"])) {
    $postId = $_POST["postId"];

    Likes::like($con, $userId, $postId);
}
?>

    <div class="container">
        <div class="title">
            <a href="user.php?id=<?php echo $shownUserId; ?>"><h1><?php echo $shownUserInfo["username"]; ?>のTodo</h1></a>
            <h2><a href="post.php">todoを作成</a></h2>
            <br>
            <h3><a href="showJoiningGroup.php?shownUserId=<?php echo $shownUserId; ?>">参加しているグループを表示</a></h3>
            <?php if ($userId == $shownUserId) : ?>
                <br>
                <h3><a href="makeGroup.php">新しいグループを作成</a></h3>
            <?php endif; ?>
        </div>
        <?php require("includes/userInfoView.php"); ?>
        <br>
        <br>

        <?php 
        $todoControllers = $con->query("SELECT * FROM todocontroller ORDER BY id DESC"); 

        while ($todoController = $todoControllers->fetch()) {

            $todoControllerId = $todoController["id"];

            $query = $con->prepare("SELECT * FROM eachtodo WHERE controllerId=:controllerId");
            $query->bindValue(":controllerId", $todoControllerId);
            $query->execute();

            $authorId = $todoController["authorId"];
            $authorInfo = Info::getUserInfoById($con, $authorId);

            if ($authorId == $shownUserId) {
                require("includes/contentsProvider.php");
            } 

        }

        ?>

        <br>
    </div>
</body>
</html>