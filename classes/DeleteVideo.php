<?php

require_once __DIR__ . '/../includes/functions.php';

class DeleteVideo extends EditVideos
{
    public function __construct()
    {
        $this->videoId = filter_input(INPUT_POST, "video-id");
    }

    public function deleteVideo()
    {
        $sql = "DELETE FROM lesson_videos WHERE id = :id";
        $sth = $this->connectDatabase()->prepare($sql);
        $sth->bindValue(':id', $this->videoId, PDO::PARAM_INT);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : true;
    }
}
