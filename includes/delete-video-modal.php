<?php require_once __DIR__ . '/functions.php'; ?>
<div class="modal" id="delete-video-modal">
    <div class="modal-content-delete-video">
        <div id="video-title" class="video-title"></div>
        <div class="red-text">この動画を削除しますか？</div>
        <form id="delete-video-form">
            <input type="hidden" value="" name="video-id">
            <button type="button" id="delete-this-video">はい</button>
        </form>
        <span class="close">&times;</span>
    </div>
</div>