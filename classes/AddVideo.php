<?php

require_once __DIR__ . '/../includes/functions.php';

class AddVideo extends Login
{
    protected $videoTitle;
    protected $youtubeVideoId;
    protected $course;
    protected $sortOrder;

    public function __construct()
    {
        $this->videoTitle = filter_input(INPUT_POST, "video-title");
        $this->youtubeVideoId = filter_input(INPUT_POST, "youtube-video-id");
        $this->course = filter_input(INPUT_POST, "course-id");
        $this->sortOrder = filter_input(INPUT_POST, "sort-order");
        $this->errorObj = new stdClass;
        if (!$this->videoTitle) $this->errorObj->videoTitle = '※動画のタイトルを入力してください';
        if (!$this->youtubeVideoId) $this->errorObj->youtubeVideoId = '※YouTube 動画 IDを入力してください';
        if (!$this->sortOrder) $this->sortOrder = 1;
    }

    public function insertVideo()
    {
        $sql = "INSERT INTO lesson_videos (video_title, youtube_video_id, course, sort_order, created_at) VALUES(:video_title, :youtube_video_id, :course, :sort_order, sysdate())";
        $sth = $this->connectDatabase()->prepare($sql);
        $sth->bindValue(':video_title', $this->videoTitle, PDO::PARAM_STR);
        $sth->bindValue(':youtube_video_id', $this->youtubeVideoId, PDO::PARAM_STR);
        $sth->bindValue(':course', $this->course, PDO::PARAM_INT);
        $sth->bindValue(':sort_order', $this->sortOrder, PDO::PARAM_INT);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : true;
    }
}
