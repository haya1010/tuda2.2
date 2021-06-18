<?php

class Follow {

    // public static function followAction ($con, $followingId, $followedId) {
    //     $followInfo = self::getFollowInfo($con, $followingId, $followedId);
    //     $count = $followInfo->rowcount();
    
    //     if ($count == 0) {
        //         $query = $con->prepare("INSERT INTO follow (followingId, followedId) VALUES (:followingId, :followedId)");
        //         $query->bindValue(":followingId", $followingId);
        //         $query->bindValue(":followedId", $followedId);
        //         $query->execute();
        //     }
        //     else {
            //         $query = $con->prepare("DELETE FROM follow WHERE followingId=:followingId AND followedId=:followedId");
            //         $query->bindValue(":followingId", $followingId);
            //         $query->bindValue(":followedId", $followedId);
            //         $query->execute();
            //     }
            // }


    public static function followingOrNot ($con, $followingId, $followedId) {

        $followInfo = self::getFollowInfo($con, $followingId, $followedId);
        $count = $followInfo->rowcount();
                
        if ($count==0) {
            return False;
        }
        else {
            return True;
        }

    }

    public static function followAction ($con, $followingId, $followedId) {
        
        $query = $con->prepare("INSERT INTO follow (followingId, followedId) VALUES (:followingId, :followedId)");
        $query->bindValue(":followingId", $followingId);
        $query->bindValue(":followedId", $followedId);
        $query->execute();
        
    }
    
    public static function unFollowAction ($con, $followingId, $followedId) {
        
        $query = $con->prepare("DELETE FROM follow WHERE followingId=:followingId AND followedId=:followedId");
        $query->bindValue(":followingId", $followingId);
        $query->bindValue(":followedId", $followedId);
        $query->execute();

    }

    
    public static function getFollowingCount ($con, $followingId) {
        $query = self::getFollowingInfoById ($con, $followingId);
        return $query->rowcount();
        
    }

    public static function getFollowingInfoById ($con, $followingId) {
        $query = $con->prepare("SELECT * FROM follow WHERE followingId=:followingId");
        $query->bindValue(":followingId", $followingId);
        $query->execute();
        return $query;
    }
    
    public static function getFollowedCount ($con, $followedId) {
        $query = self::getFollowedInfoById ($con, $followedId);
        return $query->rowcount();
    }
    
    public static function getFollowedInfoById ($con, $followedId) {
        $query = $con->prepare("SELECT * FROM follow WHERE followedId=:followedId");
        $query->bindValue(":followedId", $followedId);
        $query->execute();
        return $query;
    }

    public static function getFollowInfo ($con, $followingId, $followedId) {
        $query = $con->prepare("SELECT * FROM follow WHERE followingId=:followingId AND followedId=:followedId");
        $query->bindValue(":followingId", $followingId);
        $query->bindValue(":followedId", $followedId);
        $query->execute();
        return $query;
    }
}

?>