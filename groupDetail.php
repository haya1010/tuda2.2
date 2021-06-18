<?php
require("includes/header.php");
require("includes/classes/Group.php");

$groupId = $_REQUEST["groupId"];
$groupInfo = Group::getGroupInfoByGroupId($con, $groupId);

$groupMembersInfo = Group::getGroupMembersInfoByGroupId($con, $groupId);

if (isset($_POST["followButton"])) {
    $groupMemberId = $_POST["groupMemberId"];
    Follow::followAction($con, $userId, $groupMemberId);
}
if (isset($_POST["unFollowButton"])) {
    $groupMemberId = $_POST["groupMemberId"];
    Follow::unFollowAction($con, $userId, $groupMemberId);
}

if (isset($_POST["likeButton"])) {
    $postId = $_POST["postId"];
    Likes::like($con, $userId, $postId);
} 
?>

    <div class="container">
        <div class="title">
            <a href="groupindex.php?groupId=<?php echo $groupId; ?>"><h1><?php echo $groupInfo["groupName"]; ?>のTodo</h1></a>
            <h2><a href="post.php">todoを作成</a></h2>
            <br>
            <h3><a href="groupDetail.php?groupId=<?php echo $groupId; ?>"><?php echo $groupInfo["groupName"]; ?>の詳細</a></h3>
            <br>
            <h3><a href="showAllGroup.php">全グループを表示</a></h3>
            <br>
            <br>
            <?php if (!isset($fileName)) : ?>
            <br>
            <!-- <a href="limitedIndex.php">フォローしているユーザーのみ表示</a> -->
            <?php endif; ?>
        </div>
            <h4>参加しているユーザー</h4>
        <br>
        <?php 
            while ($groupMemberInfo = $groupMembersInfo->fetch()) :
                $groupMemberId = $groupMemberInfo["memberId"];
                // echo $groupMemberId;
                $memberInfo = Info::getUserInfoById($con, $groupMemberId);
                // var_dump($memberInfo);

                $memberName = $memberInfo["username"];
                // echo $memberName;
        ?>
            <a href="user.php?id=<?php echo $groupMemberId; ?>"><?php echo $memberName; ?></a>
            <?php if ($groupMemberId != $userId): ?>
                <form method="POST">
                    <?php if (Follow::followingOrNot($con, $userId, $groupMemberId)): ?>
                        <input type="submit" name="unFollowButton" value="フォロー解除">
                    <?php else: ?>
                        <input type="submit" name="followButton" value="フォローする">
                    <?php endif; ?>
                    <input type="hidden" name="groupMemberId" value="<?php echo $groupMemberId; ?>">
                </form>
                <br>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
</body>
</html>