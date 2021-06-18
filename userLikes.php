<?php
require("includes/header.php");

$userLike = Likes::getUserLike($con, $shownUserId);
$showPostArr = array();
while ($showPost = $userLike->fetch()) {
    array_push($showPostArr, $showPost["postId"]);
}

if (isset($_POST["followButton"])) {
    Follow::followAction($con, $userId, $shownUserId);
}
if (isset($_POST["unFollowButton"])) {
    Follow::unFollowAction($con, $userId, $shownUserId);
}

if (isset($_POST["likeButton"])) {
    $postId = $_POST["postId"];
    Likes::like($con, $userId, $postId);
}
?>

    <div class="container">
        <div class="title">
            <a href="user.php?id=<?php echo $shownUserId; ?>"><h1><?php echo $shownUserInfo["username"]; ?>のいいね</h1></a>
            <h2><a href="post.php">todoを作成</a></h2>
        </div>
        <?php require("includes/userInfoView.php"); ?>
        <br>
        <br>

        <?php 
        foreach ($showPostArr as $showPostId) {

            $query = $con->prepare("SELECT * FROM eachtodo WHERE controllerId=?"); 
            $query->execute(array($showPostId));

            $todoController = Info::getTodoControllerInfoById($con, $showPostId);

            $authorId = $todoController["authorId"];
            $authorInfo = Info::getUserInfoById($con, $authorId);

            require("includes/contentsProvider.php"); 
        } 

        ?>
        
    </div>
</body>

</html>