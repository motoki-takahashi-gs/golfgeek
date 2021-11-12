<?php

require_once __DIR__ . '/../includes/functions.php';

class Questions extends Dbh
{
    private $whereClause;
    protected $row;
    private $questionList;
    private $perPage;
    private $currentPage;
    private $startAt;
    private $totalQuestions;
    private $totalPages;
    private $numberOfQuestions;
    private $previousPageLink;
    private $nextPageLink;
    protected $userType;
    protected $filePath;

    public function __construct($userType)
    {
        $this->perPage = 5;
        $this->currentPage = (isset($_GET['page']) ? (int) $_GET['page'] : 1);
        $this->startAt = $this->perPage * ($this->currentPage - 1);
        $this->userType = $userType;
    }

    public function setWhereClause($golfer_id)
    {
        $this->whereClause = ' WHERE golfer_id = ' . $golfer_id;
    }

    private function countQuestions()
    {
        $sql = 'SELECT COUNT(DISTINCT id) AS cnt FROM questions' . $this->whereClause;
        $sth = $this->connectDatabase()->prepare($sql);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : $sth;
    }

    private function setTotalQuestions()
    {
        $sth = $this->countQuestions();
        $this->row = $sth->fetch(PDO::FETCH_ASSOC);
        $this->totalQuestions = $this->row['cnt'];
    }

    private function setTotalPages()
    {
        $this->totalPages = ceil($this->totalQuestions / $this->perPage);
    }

    private function setNumberOfQuestions()
    {
        if ($this->totalQuestions == 0) {
            $this->numberOfQuestions = '0 件';
        } else {
            $this->numberOfQuestions = '';
            $this->numberOfQuestions .= '全 ' . $this->totalQuestions . ' 件中  ';
            $this->numberOfQuestions .= ($this->startAt + 1) . ' 〜 ';
            // when current page is the last page
            if ($this->currentPage == $this->totalPages) {
                $this->numberOfQuestions .= $this->totalQuestions;
            } else {
                $this->numberOfQuestions .= ($this->startAt + $this->perPage);
            }
            $this->numberOfQuestions .= ' 件を表示';
        }
    }

    public function getNumberOfQuestions()
    {
        return $this->numberOfQuestions;
    }

    private function setPreviousPageLink()
    {
        $this->previousPageLink = ($this->currentPage > 1)
            ? sprintf('<a href="?%s"><i class="fas fa-chevron-circle-left"></i></a>', http_build_query(['page' => $this->currentPage - 1]))
            : '<i class="fas fa-chevron-circle-left no-link"></i>';
    }

    public function getPreviousPageLink()
    {
        return $this->previousPageLink;
    }

    private function setNextPageLink()
    {
        $this->nextPageLink = ($this->currentPage < $this->totalPages)
            ? sprintf('<a href="?%s"><i class="fas fa-chevron-circle-right"></i></a>', http_build_query(['page' => $this->currentPage + 1]))
            : '<i class="fas fa-chevron-circle-right no-link"></i>';
    }

    public function getNextPageLink()
    {
        return $this->nextPageLink;
    }

    private function selectQuestions()
    {
        $sql = 'SELECT id, description, file_path AS filePath, file_type AS fileType, golfer_id, created_at AS date_time
        FROM questions' . $this->whereClause . ' ORDER BY id ASC LIMIT :perPage OFFSET :startAt';
        $sth = $this->connectDatabase()->prepare($sql);
        $sth->bindValue(':perPage', $this->perPage, PDO::PARAM_INT);
        $sth->bindValue(':startAt', $this->startAt, PDO::PARAM_INT);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : $sth;
    }

    protected function formatDateTime()
    {
        return date('Y年m月d日 H時i分s秒', strtotime($this->row['date_time']));
    }

    protected function adjustFilePath()
    {
        if ($this->userType == 'golfer') {
            // omit '.' of file path for front UI
            $this->filePath = substr($this->row['filePath'], 1);
        } else if ($this->userType == 'teaching_pro') {
            $this->filePath = $this->row['filePath'];
        }
    }

    private function getImageTags()
    {
        $tags = '<div class="bold-text">画像：</div>';
        $tags .= '<img src="' . $this->filePath . '" class="active">';
        return $tags;
    }

    private function getVideoTags()
    {
        $tags = '<div class="bold-text">動画：</div>';
        $tags .= '<video class="hidden-video" src="' . $this->filePath . '" controls muted loop playsinline>';
        $tags .= '</video>';
        $tags .= '<canvas class="canvas-video"></canvas>';
        $tags .= '<div class="play-pause-button">';
        $tags .= '<button type="button" class="play-pause-mark"></button>';
        $tags .= '</div>';
        return $tags;
    }

    protected function addFilePreview()
    {
        // when a file is attached
        if ($this->filePath) {
            $tags = '<div class="file-preview">';
            if ($this->row['fileType'] == 1) {
                $tags .= $this->getImageTags();
            } else if ($this->row['fileType'] == 2) {
                $tags .= $this->getVideoTags();
            }
            $tags .= '</div>';
            return $tags;
        }
    }

    private function setQuestionList()
    {
        $sth = $this->selectQuestions();
        $this->questionList = '<ul>';
        while ($this->row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $this->questionList .= '<li>';
            $this->questionList .= '<div>';
            $this->questionList .= '<div class="bold-text">投稿日時：</div>';
            $this->questionList .= '<div>' . $this->formatDateTime() . '</div>';
            $this->questionList .= '</div>';
            $this->questionList .= '<div class="bold-text">質問番号：' . $this->row['id'] . '</div>';
            $this->questionList .= '<div>' . specialChar($this->row['description']) . '</div>';
            $this->adjustFilePath();
            $this->questionList .= $this->addFilePreview();
            $this->questionList .= '<div class="question-button">';
            $this->questionList .= '<a href="./question-details.php?id=' . $this->row['id'] . '">';
            $this->questionList .= '<button type="button">詳細を見る</button>';
            $this->questionList .= '</a>';
            $this->questionList .= '</div>';
            $this->questionList .= '</li>';
        }
        $this->questionList .= '</ul>';
    }

    public function getQuestionList()
    {
        return $this->questionList;
    }

    public function setUpQuestions()
    {
        $this->setTotalQuestions();
        $this->setTotalPages();
        $this->setNumberOfQuestions();
        $this->setPreviousPageLink();
        $this->setNextPageLink();
        $this->setQuestionList();
    }
}
