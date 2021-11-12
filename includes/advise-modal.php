<?php require_once __DIR__ . '/functions.php'; ?>
<div class="modal" id="advise-modal">
    <div class="modal-content-advise">
        <form id="advise-form">
            <div><textarea placeholder="アドバイスの内容" name="description"></textarea></div>
            <div id="description-error" class="form-error"></div>
            <?php require('../includes/file-upload.php'); ?>
            <div><input type="hidden" value="<?php echo $questionDetails->getQuestionId(); ?>" name="question-id"></div>
            <div><input type="hidden" value="<?php echo $questionDetails->getGolferId(); ?>" name="golfer_id"></div>
            <div><input type="hidden" value="<?php echo $questionDetails->getQuestionId(); ?>" name="question_id"></div>
            <div><button type="button" id="advise">この内容でアドバイスする</button></div>
        </form>
        <span class="close">&times;</span>
    </div>
</div>