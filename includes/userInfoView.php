<?php if ($shownUserId != $userId): ?>
<?php if (Follow::followingOrNot($con, $shownUserId, $userId)): ?>
    <span class="notice">フォローされています</span>
<?php endif; ?>
<form method="POST">
    <?php if (Follow::followingOrNot($con, $userId, $shownUserId)): ?>
        <input type="submit" name="unFollowButton" value="フォロー解除">
    <?php else: ?>
        <input type="submit" name="followButton" value="フォローする">
    <?php endif; ?>
</form>
<?php endif; ?>
<br>
<a href="following.php?id=<?php echo $shownUserId; ?>"><?php echo Follow::getFollowingCount($con, $shownUserId); ?>following</a>
<a href="followed.php?id=<?php echo $shownUserId; ?>"><?php echo Follow::getFollowedCount($con, $shownUserId); ?>followed</a>
<br>
<br>
<a href="user.php?id=<?php echo $shownUserId; ?>"><?php echo $shownUserInfo["username"]; ?>のtodoへ</a>
<a href="userLikes.php?id=<?php echo $shownUserId; ?>"><?php echo $userLike->rowcount(); ?>いいね</a>