<?php
class Post {

    public $POST;
    public $todoArr = array();
    public $doneOrNotYetArr = array();
    public $count;

    public function __construct($POST) {
        $this->POST = $POST;
        // $this->count = $this->POST["count"];
        $this->count = $this->POST["count"] - 1;


        if (isset($this->POST["todoArr"])) {
            $this->todoArr = $this->POST["todoArr"];
        }
        // if (!isset($this->POST["todoArr"])) {
        //     $this->todoArr = array();
        // } else {
        //     $this->todoArr = $this->POST["todoArr"];
        // }

    }
    
    public function makeNewTodoIfRequired() {
        if (isset($this->POST["makeTodo"])) {
            array_push($this->todoArr, '');
            array_push($this->doneOrNotYetArr, "notYet");
        }
    }
    
    public function deleteTodoIfRequired() {
        for ($i = 0; $i <= $this->count; $i++) {
            if (isset($this->POST["delete$i"])) {
                unset($this->todoArr[$i]);
                unset($this->doneOrNotYetArr[$i]);
            }
            $this->todoArr = array_values($this->todoArr);
            $this->doneOrNotYetArr = array_values($this->doneOrNotYetArr);
        }
    }
    
    public function registerTodoIfRequired($con, $userId) {
        
        if (isset($this->POST["submitButton"])) {
            $i = 0;
            // var_dump(!empty($this->todoArr));
            // if (!empty($this->todoArr)) {
            //     header("Location: post.php");
            // }
            foreach ($this->todoArr as $todo) {
                if (empty($todo)) {
                    unset($this->todoArr[$i]);
                } 
                $i++;
            }

            if (!empty($this->todoArr)) {
                $identifier = time();
                $query = $con->prepare("INSERT INTO todocontroller (authorId, identifier) VALUES (:authorId, :identifier)");
                $query->bindValue(":authorId", $userId);
                $query->bindValue(":identifier", $identifier);
                $query->execute();
                
                
                $query = $con->prepare("SELECT * FROM todocontroller WHERE authorId=:authorId AND identifier=:identifier");
                $query->bindValue(":authorId", $userId);
                $query->bindValue(":identifier",$identifier);
                $query->execute();
                $todoControllerInfo = $query->fetch();
                $todoControllerId = $todoControllerInfo["id"];
                
                foreach ($this->todoArr as $todo) {
                    $query = $con->prepare("INSERT INTO eachtodo (controllerId, contents, doneOrNotYet) VALUES (:controllerId, :contents, :doneOrNotYet)");
                    $query->bindValue(":controllerId", $todoControllerId);
                    $query->bindValue(":contents", $todo);
                    $query->bindValue(":doneOrNotYet", "notYet");
                    $query->execute();
                }

                header("Location: index.php");
            }
            else {
                header("Location: post.php");
            }
        }
    }

    public function updateTodoIfRequired($con, $todoControllerId) {
        
        if (isset($this->POST["updateButton"])) {
            $i = 0;
            // var_dump(!empty($this->todoArr));
            // if (!empty($this->todoArr)) {
            //     header("Location: post.php");
            // }
            foreach ($this->todoArr as $todo) {
                if (empty($todo)) {
                    unset($this->todoArr[$i]);
                } 
                $i++;
            }

            if (!empty($this->todoArr)) {
                $query = $con->prepare("DELETE FROM eachtodo WHERE controllerId=:controllerId");
                $query->bindValue(":controllerId", $todoControllerId);
                $query->execute();

                $i = 0;
                foreach ($this->todoArr as $todo) {
                    $query = $con->prepare("INSERT INTO eachtodo (controllerId, contents, doneOrNotYet) VALUES (:controllerId, :contents, :doneOrNotYet)");
                    $query->bindValue(":controllerId", $todoControllerId);
                    $query->bindValue(":contents", $todo);
                    if ($this->doneOrNotYetArr[$i] == "done") {
                        $query->bindValue(":doneOrNotYet", "done");
                    }
                    else {
                        $query->bindValue(":doneOrNotYet", "notYet");
                    }
                    $query->execute();
                    $i++;
                }


                header("Location: index.php");
            }
            else {
                header("Location: post.php");
            }
        }
    }

    public function setDoneOrNotYetArr () {

        // $this->doneOrNotYetArr = array();
        for ($i = 0; $i <= $this->count; $i++) {
            array_push($this->doneOrNotYetArr, "notYet");
        }

        if (isset($_POST["doneOrNotYetTmp"])) {
            $doneOrNotYetTmp = $_POST["doneOrNotYetTmp"];
            $doneOrNotYetTmp = array_keys($doneOrNotYetTmp);

            for ($i = 0; $i <= $this->count; $i++) {
                if (in_array($i, $doneOrNotYetTmp)) {
                    $this->doneOrNotYetArr[$i] = "done";
                    // array_push($this->doneOrNotYetArr, "done");
                }
            }

        }
        

    }
    
}
?>