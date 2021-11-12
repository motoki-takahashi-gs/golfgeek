<?php

require_once __DIR__ . '/../includes/functions.php';

class Login extends Dbh
{
    protected $email;
    protected $password;
    protected $user_type;
    protected $errorObj;
    protected $row;
    protected $tableName;
    private $sessionName;

    public function __construct()
    {
        $this->email = filter_input(INPUT_POST, "login-email", FILTER_VALIDATE_EMAIL);
        $this->password = filter_input(INPUT_POST, "login-password");
        $this->user_type = filter_input(INPUT_POST, "user_type");
        $this->errorObj = new stdClass();
        if (!$this->email) $this->errorObj->loginEmail = '※メールアドレスを入力してください';
        if (!$this->password) $this->errorObj->loginPassword = '※パスワードを入力してください';
        $this->checkUserType(get_class());
    }

    protected function checkUserType($class)
    {
        if ($this->user_type == 'golfer') {
            $this->tableName = 'golfers';
            $this->sessionName = 'golfer_id';
            // in order to prevent creating an account of teaching pro from golfer pages
        } else if (($this->user_type == 'teaching_pro') && (strpos($_SERVER['HTTP_REFERER'], '/admin/'))) {
            $this->tableName = 'teaching_pros';
            $this->sessionName = 'teaching_pro_id';
        } else {
            // when a user intentionally changed the user type
            if ($class == 'Signup') {
                $this->errorObj->signupUnable = '※アカウントを作成できません';
            } else if ($class == 'Login') {
                $this->errorObj->loginUnable = '※ログインできません';
            }
        }
    }

    public function showError()
    {
        echo json_encode($this->errorObj);
    }

    public function showSuccess()
    {
        echo 'success';
    }

    public function isErrorObj()
    {
        if (count(get_object_vars($this->errorObj)) > 0) {
            $this->showError();
            return true;
        } else {
            return false;
        }
    }

    protected function selectUser()
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE email=:email";
        $sth = $this->connectDatabase()->prepare($sql);
        $sth->bindValue(':email', $this->email, PDO::PARAM_STR);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : $sth;
    }

    public function isEmailRegistered()
    {
        $sth = $this->selectUser();
        $this->row = $sth->fetch(PDO::FETCH_ASSOC);
        if ($this->row == false) {
            $this->errorObj->loginEmail = '※登録されていないメールアドレスです';
            $this->showError();
            return false;
        } else {
            return true;
        }
    }

    public function isPasswordCorrect()
    {
        if (password_verify($this->password, $this->row["password"])) return true;
    }

    public function setSessionVar()
    {
        $sth = $this->selectUser();
        $this->row = $sth->fetch(PDO::FETCH_ASSOC);
        $_SESSION["sid"] = session_id();
        $_SESSION[$this->sessionName] = $this->row["id"];
        $_SESSION["first_name"] = specialChar($this->row["first_name"]);
        $_SESSION["last_name"] = specialChar($this->row["last_name"]);
    }

    public function incorrectPassword()
    {
        $this->errorObj->loginPassword = '※パスワードが正しくありません';
        $this->showError();
    }
}
