<?php
require("includes/header.php");


if (isset($_POST["followButton"])) {
    $followingMemberId = $_POST["followingMemberId"];
    Follow::followAction($con, $userId, $followingMemberId);
}
if (isset($_POST["unFollowButton"])) {
    $followingMemberId = $_POST["followingMemberId"];
    Follow::unFollowAction($con, $userId, $followingMemberId);
}

$followingInfo = Follow::getFollowingInfoById($con, $shownUserId);
?>

    <div class="container">

        <div class="title">
            <a href="user.php?id=<?php echo $shownUserId; ?>"><h1><?php echo $shownUserInfo["username"]; ?></h1></a>
            <h2>フォロー中</h2>
        </div>

        <a href="following.php?id=<?php echo $shownUserId; ?>"><?php echo Follow::getFollowingCount($con, $shownUserId); ?>following</a>
        <a href="followed.php?id=<?php echo $shownUserId; ?>"><?php echo Follow::getFollowedCount($con, $shownUserId); ?>followed</a>
        <br>
        <br>
        <?php while ($followingMember = $followingInfo->fetch()): ?>

            <?php 
            $followingMemberId = $followingMember["followedId"];
            $followingMemberInfo = Info::getUserInfoById($con, $followingMemberId);
            ?>

            <?php if (Follow::followingOrNot($con, $followingMemberId, $userId)): ?>
                <span class="notice">フォローされています</span>
            <?php endif; ?>

            <a href="user.php?id=<?php echo $followingMemberInfo["id"]; ?>"><?php echo $followingMemberInfo["username"]; ?></a>

            <?php if ($followingMemberId != $userId): ?>
                <form method="POST">
                    <?php if (Follow::followingOrNot($con, $userId, $followingMemberId)): ?>
                        <input type="submit" name="unFollowButton" value="フォロー解除">
                    <?php else: ?>
                        <input type="submit" name="followButton" value="フォローする">
                    <?php endif; ?>
                    <input type="hidden" name="followingMemberId" value="<?php echo $followingMemberId; ?>">
                </form>
            <?php endif; ?>
            <br>
            <br>
        <?php endwhile; ?>
    </div>
</body>

</html>