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

$followedInfo = Follow::getFollowedInfoById($con, $shownUserId);
?>

    <div class="container">

        <div class="title">
            <a href="user.php?id=<?php echo $shownUserId; ?>"><h1><?php echo $shownUserInfo["username"]; ?></h1></a>
            <h2>フォロワー</h2>
        </div>

        <a href="following.php?id=<?php echo $shownUserId; ?>"><?php echo Follow::getFollowingCount($con, $shownUserId); ?>following</a>
        <a href="followed.php?id=<?php echo $shownUserId; ?>"><?php echo Follow::getFollowedCount($con, $shownUserId); ?>followed</a>
        <br>
        <br>
        <?php while ($followedMember = $followedInfo->fetch()): ?>

            <?php 
            $followedMemberId = $followedMember["followingId"];
            $followedMemberInfo = Info::getUserInfoById($con, $followedMemberId);
            ?>

            <?php if (Follow::followingOrNot($con, $followedMemberId, $userId)): ?>
                <span class="notice">フォローされています</span>
            <?php endif; ?>

            <a href="user.php?id=<?php echo $followedMemberInfo["id"]; ?>"><?php echo $followedMemberInfo["username"]; ?></a>

            <?php if ($followedMemberId != $userId): ?>
                <form method="POST">
                    <?php if (Follow::followingOrNot($con, $userId, $followedMemberId)): ?>
                        <input type="submit" name="unFollowButton" value="フォロー解除">
                    <?php else: ?>
                        <input type="submit" name="followButton" value="フォローする">
                    <?php endif; ?>
                    <input type="hidden" name="followingMemberId" value="<?php echo $followedMemberId; ?>">
                </form>
            <?php endif; ?>
            <br>
            <br>
        <?php endwhile; ?>
    </div>
</body>

</html>