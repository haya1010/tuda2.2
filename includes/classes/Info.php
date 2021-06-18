<?php
class Info {

    public static function getUserInfoById($con, $id) {

        $query = $con->prepare("SELECT * FROM users WHERE id=:id");
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch();
    }
    
    public static function getUserInfoQueryById($con, $id) {
        
        $query = $con->prepare("SELECT * FROM users WHERE id=:id");
        $query->bindValue(":id", $id);
        $query->execute();
        return $query;
    }
    
    public static function getTodoControllerInfoById($con, $todoControllerId) {
        
        $query = $con->prepare("SELECT * FROM todocontroller WHERE id=:todoControllerId");
        $query->bindValue(":todoControllerId", $todoControllerId);
        $query->execute();
        return $query->fetch();
    }

}
?>