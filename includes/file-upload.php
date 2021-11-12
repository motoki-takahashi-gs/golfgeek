<?php require_once __DIR__ . '/functions.php'; ?>
<div>
    <button type="button" id="custom-button">ファイルを添付</button>
    <input type="file" id="real-button" hidden="hidden" name="image-video">
</div>
<div id="extension-error" class="form-error"></div>
<div class="file-preview">
    <img id="image-thumbnail">
    <video class="hidden-video" controls muted loop playsinline></video>
    <canvas class="canvas-video"></canvas>
    <div class="play-pause-button">
        <button type="button" class="play-pause-mark"></button>
    </div>
    <div id="now-loading" class="now-loading">ファイルを読み込み中です...</div>
</div>