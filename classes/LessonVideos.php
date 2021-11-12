<?php

require_once __DIR__ . '/../includes/functions.php';

class LessonVideos extends Dbh
{
    private $row;
    private $videoList;

    private function selectCourseName($courseId)
    {
        $sql = 'SELECT name_ja FROM courses WHERE id = :courseId';
        $sth = $this->connectDatabase()->prepare($sql);
        $sth->bindValue(':courseId', $courseId);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : $sth;
    }

    public function getCourseName($courseId)
    {
        $sth = $this->selectCourseName($courseId);
        $this->row = $sth->fetch(PDO::FETCH_ASSOC);
        return $this->row['name_ja'];
    }

    private function selectVideos($courseId)
    {
        $sql = 'SELECT lesson_videos.id as video_id, video_title, youtube_video_id, course, sort_order
        FROM lesson_videos
        WHERE course = :course
        ORDER BY sort_order ASC';
        $sth = $this->connectDatabase()->prepare($sql);
        $sth->bindValue(':course', $courseId);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : $sth;
    }

    public function setVideoList($courseId)
    {
        $sth = $this->selectVideos($courseId);
        $this->videoList = '<ul>';
        while ($this->row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $this->videoList .= '<li>';
            $this->videoList .= '<div class="video-title">(' . $this->row['sort_order'] . ') ' . specialChar($this->row['video_title']) . '</div>';
            $this->videoList .= '<iframe src="https://www.youtube.com/embed/' . specialChar($this->row['youtube_video_id']) . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            $this->videoList .= '</li>';
        }
        $this->videoList .= '</ul>';
    }

    public function setVideoListToEdit($courseId, $courseOptions)
    {
        $sth = $this->selectVideos($courseId);
        $this->videoList .= '<form id="edit-videos-form">';
        $this->videoList .= '<ul class="edit-videos">';
        while ($this->row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $this->videoList .= '<li>';
            $this->videoList .= '<input type="hidden" name="video-id[]" value="' . $this->row['video_id'] . '">';
            $this->videoList .= '<div>';
            $this->videoList .= '<textarea placeholder="動画のタイトル" name="video-title[]">';
            $this->videoList .= specialChar($this->row['video_title']);
            $this->videoList .= '</textarea>';
            $this->videoList .= '</div>';
            $this->videoList .= '<div class="videoTitle-error form-error"></div>';
            $this->videoList .= '<div>';
            $this->videoList .= '<input type="text" placeholder="YouTube 動画 ID" name="youtube-video-id[]" value="' . specialChar($this->row['youtube_video_id']) . '">';
            $this->videoList .= '</div>';
            $this->videoList .= '<div class="youtubeVideoId-error form-error"></div>';
            $this->videoList .= '<div class="sort-and-course">';
            $this->videoList .= '<div class="position-relative">';
            $this->videoList .= '<span>並び順</span>';
            $this->videoList .= '<select name="sort-order[]">';
            for ($i = 1; $i <= 10; $i++) {
                $selected = ($i == $this->row['sort_order']) ? ' selected' : '';
                $this->videoList .= '<option' . $selected . ' value="' . $i . '">' . $i . '</option>';
            }
            $this->videoList .= '</select>';
            $this->videoList .= '<span class="down-arrow"></span>';
            $this->videoList .= '</div>';
            $this->videoList .= '<div class="position-relative">';
            $this->videoList .= '<span>コース</span>';
            $this->videoList .= '<select name="course-id[]">';
            $this->videoList .= $courseOptions;
            $this->videoList .= '</select>';
            $this->videoList .= '<span class="down-arrow"></span>';
            $this->videoList .= '</div>';
            $this->videoList .= '</div>';
            $this->videoList .= '<div>';
            $this->videoList .= '<button type="button" class="delete">削除する</button>';
            $this->videoList .= '</div>';
            $this->videoList .= '</li>';
        }
        $this->videoList .= '</ul>';
        $this->videoList .= '<button type="button" id="save-video-settings" class="save">保存する</button>';
        $this->videoList .= '</form>';
    }

    public function getVideoList()
    {
        return $this->videoList;
    }

    public function goBackToLessonVideosTop()
    {
        header('Location: ./lesson-videos.php');
    }

    public function getSortOrderOptions()
    {
        $tags = '<option disabled selected value>並び順</option>';
        for ($i = 1; $i <= 10; $i++) {
            $tags .= '<option value="' . $i . '">' . $i . '</option>';
        }
        return $tags;
    }

    public function getEditModeQueryString($courseId)
    {
        $link = sprintf('?%s', http_build_query([
            'id' => $courseId,
            'mode' => 'edit'
        ]));
        return $link;
    }
}
