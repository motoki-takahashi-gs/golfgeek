<?php

require_once __DIR__ . '/../includes/functions.php';

class Signup extends Login
{
    private $firstName;
    private $lastName;
    private $gender;
    private $verificationKey;

    public function __construct()
    {
        $this->firstName = filter_input(INPUT_POST, "firstName");
        $this->lastName = filter_input(INPUT_POST, "lastName");
        $this->gender = filter_input(INPUT_POST, "gender");
        $this->email = filter_input(INPUT_POST, "signup-email", FILTER_VALIDATE_EMAIL);
        $this->password = filter_input(INPUT_POST, "signup-password");
        $this->user_type = filter_input(INPUT_POST, "user_type");
        $this->verificationKey = md5(time() . $this->email);
        $this->errorObj = new stdClass();
        if (!$this->firstName) $this->errorObj->signupFirstName = '※名前を入力してください';
        if (!$this->lastName) $this->errorObj->signupLastName = '※名字を入力してください';
        if (!$this->gender) $this->errorObj->signupGender = '※性別を選択してください';
        if (!$this->email) $this->errorObj->signupEmail = '※メールアドレスを入力してください';
        if (!$this->password) {
            $this->errorObj->signupPassword = '※パスワードを入力してください';
        } else {
            if (strlen($this->password) < 6) {
                $this->errorObj->signupPassword = '※パスワードは6文字以上にしてください';
            }
        }
        $this->checkUserType(get_class());
    }

    public function isEmailNotRegistered()
    {
        $sth = $this->selectUser();
        $this->row = $sth->fetch(PDO::FETCH_ASSOC);
        if ($this->row == false) {
            return true;
        } else {
            $this->errorObj->signupEmail = '※既に登録されているメールアドレスです';
            $this->showError();
            return false;
        }
    }

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function insertUserInfo()
    {
        $sql = "INSERT INTO " . $this->tableName . " (first_name, last_name, gender, email, password, verification_key, created_at) VALUES(:first_name, :last_name, :gender, :email, :password, :verification_key, sysdate())";
        $sth = $this->connectDatabase()->prepare($sql);
        $sth->bindValue(':first_name', $this->firstName, PDO::PARAM_STR);
        $sth->bindValue(':last_name', $this->lastName, PDO::PARAM_STR);
        $sth->bindValue(':gender', $this->gender, PDO::PARAM_INT);
        $sth->bindValue(':email', $this->email, PDO::PARAM_STR);
        $sth->bindValue(':password', $this->password, PDO::PARAM_STR);
        $sth->bindValue(':verification_key', $this->verificationKey, PDO::PARAM_STR);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : true;
    }

    public function getUserId()
    {
        return $this->row["id"];
    }

    public function getVerificationKey()
    {
        return $this->verificationKey;
    }

    public function getUserType()
    {
        return $this->user_type;
    }
}
