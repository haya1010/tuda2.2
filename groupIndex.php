<?php
require("includes/header.php");
require("includes/classes/Group.php");

$groupId = $_REQUEST["groupId"];
$groupInfo = Group::getGroupInfoByGroupId($con, $groupId);

if (isset($_POST["likeButton"])) {
    $postId = $_POST["postId"];
    Likes::like($con, $userId, $postId);
} 
?>

    <div class="container">
        <div class="title">
            <a href="GroupIndex.php?groupId=<?php echo $groupId; ?>"><h1><?php echo $groupInfo["groupName"]; ?>のTodo</h1></a>
            <h2><a href="post.php">todoを作成</a></h2>
            <br>
            <h3><a href="groupDetail.php?groupId=<?php echo $groupId; ?>"><?php echo $groupInfo["groupName"]; ?>の詳細</a></h3>
            <br>
            <h3><a href="showAllGroup.php">全グループを表示</a></h3>
            <?php if (!isset($fileName)) : ?>
            <br>
            <!-- <a href="limitedIndex.php">フォローしているユーザーのみ表示</a> -->
            <?php endif; ?>
        </div>
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

            if (Group::alreadyMemberOrNot($con, $authorId, $groupId)) {
                // if (isset($fileName)) {
                //     if ($fileName == "limitedIndex.php") {
                //         if (Follow::followingOrNot($con, $userId, $authorId)) {
                //             require("includes/contentsProvider.php");
                //         }
                //     }
                // } else {
                    require("includes/contentsProvider.php");
                // }
            }

        }

        ?>

    </div>
</body>
</html>