<?php require_once __DIR__ . '/functions.php'; ?>
<div class="modal" id="add-video-modal">
    <div class="modal-content-add-video">
        <h1>レッスン動画の登録</h1>
        <form id="add-video-form">
            <div><input type="text" value="<?php echo $pageTitle; ?>" readonly></div>
            <div><input type="hidden" value="<?php echo $courseId; ?>" name="course-id"></div>
            <div><textarea placeholder="動画のタイトル" name="video-title"></textarea></div>
            <div id="videoTitle-error" class="form-error"></div>
            <div><input type="text" placeholder="YouTube 動画 ID" name="youtube-video-id"></div>
            <div id="youtubeVideoId-error" class="form-error"></div>
            <div class="position-relative">
                <select name="sort-order">
                    <?php echo $lessonVideos->getSortOrderOptions(); ?>
                </select>
                <span class="down-arrow"></span>
            </div>
            <div><button type="button" id="add-this-video">この動画を登録する</button></div>
        </form>
        <span class="close">&times;</span>
    </div>
</div>