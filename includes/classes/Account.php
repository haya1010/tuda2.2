<?php
class Account {

    private $con;
    public $errorArr = array();

    public function __construct($con) {
        $this->con = $con;
    }

    public function register($username, $password1, $password2) {
        // $this->errorArr = array();
        $this->validatePassword($password1, $password2);
        if (empty($this->errorArr)) {
            $this->validateDuplicateRegister($username, $password1);
        }

        // var_dump($this->errorArr);
        if (empty($this->errorArr)) {
            // echo '------inif-----';
            return $this->insertUsersDetails($username, $password1);
            // return $this->login($username, $password1);
        } 
        else {
            // echo '-----inelse------';
            return false;
        }
    }

    public function login($username, $password) {

        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
    
        $query->bindValue(":un", $username);
        $query->bindValue(":pw", $password);

        $query->execute();
        
        $loginInfo = $query->fetch();

        if ($query->rowcount() == 1) {
            // echo '------in   if-----';
            // var_dump($loginInfo["id"]);
            // echo '=======';
            return $loginInfo["id"];
        }
        else {
            // echo '------in    else-----';
            array_push($this->errorArr, Constants::$loginFailed);
            return false;
        }
    }

    private function insertUsersDetails($username, $password1) {
        $query = $this->con->prepare("INSERT INTO users (username, password) VALUES (:un, :pw)");
        
        $query->bindValue(":un", $username);
        $query->bindValue(":pw", $password1);
        
        return $query->execute();
    }
    
    private function validateDuplicateRegister($username, $password) {
        
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        
        $query->bindValue(":un", $username);
        $query->bindValue(":pw", $password);

        $query->execute();
        if ($query->rowcount() == 0) {
            return True;
        }
        else {
            array_push($this->errorArr, Constants::$duplicateRegister);
            return false;
        }
    }

    private function validatePassword($password1, $password2) {
        if ($password1 != $password2) {
            array_push($this->errorArr, Constants::$passwordsDontMatch);
            return;
        }
        if (strlen($password1) < 4) {
            array_push($this->errorArr, Constants::$passwordLength);
            return;
        }
    }

    public function getError($const) {
        if (in_array($const, $this->errorArr)) {
            return $const . "<br>";
        }
    }
}
?>