<?php require_once __DIR__ . '/functions.php'; ?>
<div class="modal" id="sos-modal">
    <div class="modal-content-sos">
        <form id="sos-form">
            <div id="noLogIn-error" class="form-error"></div>
            <div id="notVerified-error" class="form-error"></div>
            <div><textarea placeholder="質問の内容" name="description"></textarea></div>
            <div id="description-error" class="form-error"></div>
            <?php require('./includes/file-upload.php'); ?>
            <div><input type="hidden" value="<?php echo $courseId; ?>" name="course-id"></div>
            <div><button type="button" id="ask-question">この内容で質問する</button></div>
        </form>
        <span class="close">&times;</span>
    </div>
</div>