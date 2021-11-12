<?php require_once __DIR__ . '/functions.php'; ?>
<nav class="menu" id="menu">
    <ul>
        <li><a href="./index.php">トップページ</a></li>
        <li><a href="./lesson-videos.php">レッスン動画</a></li>
        <?php if (isset($_SESSION['golfer_id'])) : ?>
            <li><a href="./questions.php">SOSした質問</a></li>
            <li><a href="./log-out.php">ログアウト</a></li>
        <?php else : ?>
            <li><a href="./log-in.php">ログイン</a></li>
        <?php endif ?>
    </ul>
</nav>