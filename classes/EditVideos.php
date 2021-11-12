<?php

require_once __DIR__ . '/../includes/functions.php';

class EditVideos extends AddVideo
{
    protected $videoId;

    public function __construct()
    {
        $this->videoTitle = filter_input(INPUT_POST, "video-title", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $this->youtubeVideoId = filter_input(INPUT_POST, "youtube-video-id", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $this->course = filter_input(INPUT_POST, "course-id", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $this->sortOrder = filter_input(INPUT_POST, "sort-order", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $this->videoId = filter_input(INPUT_POST, "video-id", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $this->errorObj = new stdClass;

        if (in_array('', $this->videoTitle)) {
            // index of the array which contains a blank in its value
            $this->errorObj->videoTitleArrayKeys = array_keys($this->videoTitle, '');
            $this->errorObj->videoTitle = '※動画のタイトルを入力してください';
        }

        if (in_array('', $this->youtubeVideoId)) {
            // index of the array which contains a blank in its value
            $this->errorObj->youtubeVideoIdArrayKeys = array_keys($this->youtubeVideoId, '');
            $this->errorObj->youtubeVideoId = '※YouTube 動画 IDを入力してください';
        }
    }

    public function updateVideos()
    {
        for ($i = 0; $i < count($this->videoTitle); $i++) {
            $sql = "UPDATE lesson_videos SET video_title = :video_title, youtube_video_id = :youtube_video_id, course = :course_id, sort_order = :sort_order WHERE id = :video_id";
            $sth = $this->connectDatabase()->prepare($sql);
            $sth->bindValue(':video_title', $this->videoTitle[$i], PDO::PARAM_STR);
            $sth->bindValue(':youtube_video_id', $this->youtubeVideoId[$i], PDO::PARAM_STR);
            $sth->bindValue(':course_id', $this->course[$i], PDO::PARAM_INT);
            $sth->bindValue(':sort_order', $this->sortOrder[$i], PDO::PARAM_INT);
            $sth->bindValue(':video_id', $this->videoId[$i], PDO::PARAM_INT);
            $status = $sth->execute();
            if ($status == false) $this->getSqlError($sth);
        }
        return true;
    }
}
