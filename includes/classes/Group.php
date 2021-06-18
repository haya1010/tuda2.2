<?php
class Group {

    public static function alreadyMemberOrNot($con, $memberId, $groupId) {
        $query = $con->prepare("SELECT * FROM groupmember WHERE memberId=:memberId AND groupId=:groupId");
        $query->bindValue(":memberId", $memberId);
        $query->bindValue(":groupId", $groupId);
        $query->execute();
        
        if ($query->rowcount() == 1) {
            return True;
        }
        else {
            return false;
        }
    }

    public static function joinAction($con, $memberId, $groupId) {

        $query = $con->prepare("INSERT INTO groupmember (memberId, groupId) VALUES (:memberId, :groupId)");
        $query->bindValue(":memberId", $memberId);
        $query->bindValue(":groupId", $groupId);
        $query->execute();

    }

    public static function unJoinAction ($con, $memberId, $groupId) {
        
        $query = $con->prepare("DELETE FROM groupmember WHERE memberId=:memberId AND groupId=:groupId");
        $query->bindValue(":memberId", $memberId);
        $query->bindValue(":groupId", $groupId);
        $query->execute();

    }

    public static function getGroupInfoByGroupId ($con, $id) {
        $query = $con->prepare("SELECT * FROM groups WHERE id=:id");
        $query->bindValue(":id", $id);
        $query->execute();
        $groupInfo = $query->fetch();
        return $groupInfo;
    }
    
    public static function getGroupMembersInfoByGroupId ($con, $groupId) {
        $query = $con->prepare("SELECT * FROM groupmember WHERE groupId=:groupId");
        $query->bindValue(":groupId", $groupId);
        $query->execute();
        return $query;
    }
}
?>