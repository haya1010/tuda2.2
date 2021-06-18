<?php
require("includes/header.php");
require("includes/classes/Post.php");

$todoControllerId = $_REQUEST["todoControllerId"];
$todoControllerInfo = Info::getTodoControllerInfoById($con, $todoControllerId);
$authorId = $todoControllerInfo["authorId"];

if ($authorId != $userId) {
    header("Location: index.php");
}

if (!empty($_POST)) {

    $postAction = new Post($_POST);

    $postAction->setDoneOrNotYetArr();
    $postAction->makeNewTodoIfRequired();
    $postAction->deleteTodoIfRequired();
    $doneOrNotYetArr = $postAction->doneOrNotYetArr;

    $postAction->updateTodoIfRequired($con, $todoControllerId);

    $todoArr = $postAction->todoArr;
    
} else {
    $todoArr = array();
    $doneOrNotYetArr = array();
    $todos = $con->prepare("SELECT * FROM eachtodo WHERE controllerId=?");
    $todos->execute(array($todoControllerId));

    while ($todo = $todos->fetch()) {
        array_push($todoArr, $todo["contents"]); 
        array_push($doneOrNotYetArr, $todo["doneOrNotYet"]);
    }

}
$count = 0;
?>

    <div class="container">
        <form action="update.php?todoControllerId=<?php echo $todoControllerId; ?>" method="post">
            <ul>
                <?php foreach ($todoArr as $todo) : ?>
                    <li>
                        <input type="text" name="todoArr[<?php echo $count; ?>]" value="<?php echo $todo; ?>">

                        <input type="checkbox" name="doneOrNotYetTmp[<?php echo $count; ?>]" value="done" 
                        <?php 
                        if (!empty($doneOrNotYetArr)) {
                            if ($doneOrNotYetArr[$count] == "done") {
                                echo "checked";
                            }
                        }
                        ?>
                        >終了
                        <input type="submit" name="delete<?php echo $count; ?>" value="このtodoを削除">
                    </li>
                    <?php $count += 1; ?>

                <?php endforeach; ?>
            </ul>
            <br>
            <input type="hidden" name="count" value="<?php echo $count; ?>">
            <input type="submit" name="updateButton" value="todoを更新する">
            <input type="submit" name="makeTodo" value="新しいtodo">
        </form>
        <br>
        <a href="index.php">みんなのtodoへ</a>
    </div>
</body>
</html>