<?php
class Likes {

    public static function like($con, $userId, $postId) {
        $query = self::getLikesInfo($con, $userId, $postId);
        $count = $query->rowcount();
        
        if ($count == 0) {
            $query = $con->prepare("INSERT INTO likes (userId, postId) VALUES (:userId, :postId)");
            $query->bindValue(":userId", $userId);
            $query->bindValue(":postId", $postId);
            $query->execute();
        }
        else {
            $query = $con->prepare("DELETE FROM likes WHERE userId=:userId AND postId=:postId");
            $query->bindValue(":userId", $userId);
            $query->bindValue(":postId", $postId);
            $query->execute();
            $count = $query->rowcount();
        }
    }
    
    public static function getLikesCount($con, $postId) {

        $query = $con->prepare("SELECT * FROM likes WHERE postId=:postId");
        $query->bindValue(":postId", $postId);
        $query->execute();
        return $query->rowcount();
    }
    
    
    public static function getUserLike($con, $userId) {
        
        $query = $con->prepare("SELECT * FROM likes WHERE userId=:userId");
        $query->bindValue(":userId", $userId);
        $query->execute();
        return $query;
    }

    public static function likesView($con, $userId, $postId) {
        $query = self::getLikesInfo($con, $userId, $postId);
        $count = $query->rowcount();

        if ($count == 1) {
            return "liked";
        }
    }
    
    public static function getLikesInfo($con, $userId, $postId) {
        $query = $con->prepare("SELECT * FROM likes WHERE userId=:userId AND postId=:postId");
        $query->bindValue(":userId", $userId);
        $query->bindValue(":postId", $postId);
        $query->execute();
        return $query;

    }

}
?>