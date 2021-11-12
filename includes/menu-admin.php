<?php require_once __DIR__ . '/functions.php'; ?>
<nav class="menu" id="menu">
    <ul>
        <?php if (isset($_SESSION['teaching_pro_id'])) : ?>
            <li><a href="./index.php">管理者ページトップ</a></li>
            <li><a href="./lesson-videos.php">レッスン動画の登録</a></li>
            <li><a href="./questions.php">SOSされた質問</a></li>
            <li><a href="./create-account.php">新規アカウント作成</a></li>
            <li><a href="./log-out.php">ログアウト</a></li>
        <?php else : ?>
            <li><a href="./log-in.php">管理者ログイン</a></li>
        <?php endif ?>
    </ul>
</nav>