<?php

require_once __DIR__ . '/../includes/functions.php';

class Advices extends QuestionDetails
{
    private $advices;

    public function __construct($userType)
    {
        parent::__construct($userType);
    }

    private function selectAdvices()
    {
        $sql = 'SELECT description, advices.file_path AS filePath, advices.file_type AS fileType, teaching_pro_id, last_name, first_name, advices.created_at AS date_time
        FROM advices
        INNER JOIN teaching_pros ON advices.teaching_pro_id = teaching_pros.id
        WHERE question_id = :questionId';
        $sth = $this->connectDatabase()->prepare($sql);
        $sth->bindValue(':questionId', $this->questionId, PDO::PARAM_INT);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : $sth;
    }

    public function setAdvices()
    {
        $sth = $this->selectAdvices();
        while ($this->row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $this->advices .= '<div class="advice">';
            $this->advices .= '<div>';
            $this->advices .= '<div class="bold-text">投稿日時：</div>';
            $this->advices .= '<div>' . $this->formatDateTime() . '</div>';
            $this->advices .= '</div>';
            $this->advices .= '<div>';
            $this->advices .= '<span class="bold-text">返答者：</span>';
            $this->advices .= '<span>' . specialChar($this->row['last_name']) . ' ' . specialChar($this->row['first_name']) . ' プロ</span>';
            $this->advices .= '</div>';
            $this->advices .= '<div class="description">' . specialChar($this->row['description']) . '</div>';
            $this->adjustFilePath();
            $this->advices .= $this->addFilePreview();
            $this->advices .= '</div>';
        }
    }

    public function getAdvices()
    {
        return $this->advices;
    }
}
