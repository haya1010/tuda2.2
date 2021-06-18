<div class="todoTable">
    <div class="todos">

        <div class="info">
            <span class="author"><a href="user.php?id=<?php echo $todoController["authorId"]; ?>"><?php echo $authorInfo["username"]; ?></a></span>
            <br>
        </div>

        <?php while ($todo = $query->fetch()): ?>
            <br>
            <div class="todo">
                    <a href="update.php?todoControllerId=<?php echo $todoControllerId; ?>">・<?php echo $todo["contents"]; ?>
                    <?php if ($todo["doneOrNotYet"] == "done") : ?>
                    <p><i class="fas fa-check check"></i></p>
                    <?php endif; ?>
                    </a>
                    <br>
            </div>
        <?php endwhile; ?>

        <div class="info">
            <form method="POST">
                <input type="submit" name="likeButton" value="いいね">
                <i class="fas fa-heart heart <?php echo Likes::likesView($con, $userId, $todoController["id"]); ?>"></i>
                <?php echo Likes::getLikesCount($con, $todoController["id"]); ?>
                <input type="hidden" name="postId" value="<?php echo $todoController["id"]; ?>">
            </form>
            <span class="created_at"><?php echo $todoController["createdAt"]; ?></span>
        </div>
    </div>

</div>



