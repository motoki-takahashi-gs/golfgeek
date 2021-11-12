<?php

require_once __DIR__ . '/../includes/functions.php';

class QuestionDetails extends Questions
{
    protected $questionId;
    private $questionDetails;
    private $golferId;

    public function __construct($userType)
    {
        $this->questionId = filter_input(INPUT_GET, 'id');
        $this->userType = $userType;
        if ($this->userType == 'golfer') $this->golferId = $_SESSION['golfer_id'];
    }

    public function getQuestionId()
    {
        return $this->questionId;
    }

    private function selectQuestion()
    {
        $sql = 'SELECT description, file_path AS filePath, file_type AS fileType, golfer_id, questions.created_at AS date_time, first_name, last_name, genders.name AS gender_name
        FROM questions
        INNER JOIN golfers ON questions.golfer_id = golfers.id
        INNER JOIN genders ON golfers.gender = genders.id
        WHERE questions.id = :questionId';
        $sth = $this->connectDatabase()->prepare($sql);
        $sth->bindValue(':questionId', $this->questionId, PDO::PARAM_INT);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : $sth;
    }

    public function setQuestionDetails()
    {
        $sth = $this->selectQuestion();
        $this->row = $sth->fetch(PDO::FETCH_ASSOC);
        $this->questionDetails .= '<div>';
        $this->questionDetails .= '<div class="bold-text">投稿日時：</div>';
        $this->questionDetails .= '<div>' . $this->formatDateTime() . '</div>';
        $this->questionDetails .= '</div>';

        if ($this->userType == 'teaching_pro') {
            $this->questionDetails .= '<div>';
            $this->questionDetails .= '<span class="bold-text">投稿者：</span>';
            $this->questionDetails .= '<span>' . specialChar($this->row['last_name']) . ' ' . specialChar($this->row['first_name']) . '</span>';
            $this->questionDetails .= '</div>';
            $this->questionDetails .= '<div>';
            $this->questionDetails .= '<span class="bold-text">性別：</span>';
            $this->questionDetails .= '<span>' . $this->row['gender_name'] . '</span>';
            $this->questionDetails .= '</div>';
        }
        $this->questionDetails .= '<div>';
        $this->questionDetails .= '<div class="bold-text">内容：</div>';
        $this->questionDetails .= '<div>' . specialChar($this->row['description']) . '</div>';
        $this->questionDetails .= '</div>';
        $this->adjustFilePath();
        $this->questionDetails .= $this->addFilePreview();

        if ($this->userType == 'teaching_pro') {
            $this->questionDetails .= '<div class="advise">';
            $this->questionDetails .= '<button type="button" id="open-advice">アドバイスする</button>';
            $this->questionDetails .= '</div>';
        }
    }

    // for admin (teaching pro)
    public function setGolferId()
    {
        $this->golferId = $this->row['golfer_id'];
    }

    public function getGolferId()
    {
        return $this->golferId;
    }

    public function getGolferIdFromRow()
    {
        return $this->row['golfer_id'];
    }

    public function getQuestionDetails()
    {
        return $this->questionDetails;
    }

    public function goBackToQuestions()
    {
        header('Location: ./questions.php');
    }
}
