<?php

require_once __DIR__ . '/../includes/functions.php';

class Sos extends FileUpload
{
    private $description;
    private $needLoginMsg = '※ログインをする必要があります';
    private $userIdColumnName;
    private $targetIdColumnName;
    private $targetId;
    private $lastInsertId;
    private $fileType;

    public function __construct()
    {
        // create an empty object
        $this->errorObj = new stdClass();

        $this->user_type = filter_input(INPUT_GET, 'user_type');
        $this->description = filter_input(INPUT_POST, 'description');

        if (isset($_SESSION['sid'])) {
            if ($this->user_type == 'golfers') {
                if (!isset($_SESSION["golfer_id"])) {
                    $this->errorObj->noLogIn = $this->needLoginMsg;
                } else {
                    $this->user_id = $_SESSION["golfer_id"];
                    $this->userIdColumnName = 'golfer_id';
                    $this->tableName = 'questions';
                    $this->targetIdColumnName = 'course_id';
                    $this->targetId = filter_input(INPUT_POST, 'course-id');

                    // when the user hasn't been verified yet
                    if ($this->checkIfVerified() == 0) {
                        $this->errorObj->notVerified = 'アカウントを認証する必要があります。';
                    } else {
                        // when no description is written
                        if (!$this->description) {
                            $this->errorObj->description = '※質問の内容を入力してください';
                        }
                    }
                }
            } else if ($this->user_type == 'teaching_pros') {
                $this->user_id = $_SESSION['teaching_pro_id'];
                $this->userIdColumnName = 'teaching_pro_id';
                $this->tableName = 'advices';
                $this->targetIdColumnName = 'question_id';
                $this->targetId = filter_input(INPUT_POST, 'question-id');

                // when no description is written
                if (!$this->description) {
                    $this->errorObj->description = '※アドバイスの内容を入力してください';
                }
            }
        } else {
            $this->errorObj->noLogIn = $this->needLoginMsg;
        }
        parent::__construct();
    }

    private function selectGolfer()
    {
        $sql = 'SELECT verified FROM golfers WHERE id = :id';
        $sth = $this->connectDatabase()->prepare($sql);
        $sth->bindValue(':id', $this->user_id, PDO::PARAM_INT);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : $sth;
    }

    public function checkIfVerified()
    {
        $sth = $this->selectGolfer();
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        return $row['verified'];
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
    }

    public function ObjPropNum()
    {
        return count(get_object_vars($this->errorObj));
    }

    public function showError()
    {
        echo json_encode($this->errorObj);
    }

    public function insertDescription()
    {
        $sql = "INSERT INTO " . $this->tableName . " (description, " . $this->userIdColumnName . ", " . $this->targetIdColumnName . ", created_at) VALUES(:description, " . $this->user_id . ", " . $this->targetId . ", sysdate())";
        $dbh = $this->connectDatabase();
        $sth = $dbh->prepare($sql);
        $sth->bindValue(':description', $this->description, PDO::PARAM_STR);
        $status = $sth->execute();
        $this->lastInsertId = $dbh->lastInsertId();
        return $status == false ? $this->getSqlError($sth) : true;
    }

    public function getUserType()
    {
        return $this->user_type;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getLastInsertId()
    {
        return $this->lastInsertId;
    }

    public function outOfExtensions()
    {
        $this->errorObj->extension = '※' . strtoupper($this->getExtension()) . 'ファイルは添付できません';
    }

    public function setFile()
    {
        $sql = "UPDATE " . $this->tableName . " SET file_path = :file_path, file_type = :file_type
        WHERE id = " . $this->getLastInsertId();
        $sth = $this->connectDatabase()->prepare($sql);
        $sth->bindValue(':file_path', $this->getFilePath(), PDO::PARAM_STR);
        $sth->bindValue(':file_type', $this->fileType, PDO::PARAM_INT);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : true;
    }

    public function showSuccess()
    {
        echo 'success';
    }
}
