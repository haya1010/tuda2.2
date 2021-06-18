<?php
require("includes/header.php");
require("includes/classes/Post.php");

if (!empty($_POST)) {
    
    $postAction = new Post($_POST);

    $postAction->makeNewTodoIfRequired();
    $postAction->deleteTodoIfRequired();
    $postAction->registerTodoIfRequired($con, $userId);
    $todoArr = $postAction->todoArr;

} else {
    $todoArr = array();
}
$count = 0;

?>
    <div class="container">
        <form action="post.php" method="post">
            <br>
            <ul>
                <?php foreach ($todoArr as $todo) : ?>
                    <li>
                        <input type="text" name="todoArr[]" value="<?php echo $todo; ?>">
                        <input type="submit" name="delete<?php echo $count; ?>" value="このtodoを削除">
                    </li>
                    <?php $count += 1; ?>
                <?php endforeach; ?>
            </ul>
            <br>
            <input type="hidden" name="count" value="<?php echo $count; ?>">
            <input type="submit" name="submitButton" value="todoを登録する">
            <input type="submit" name="makeTodo" value="新しいtodo">
        </form>
        <br>
        <a href="index.php">みんなのtodoへ</a>
    </div>
</body>
</html>