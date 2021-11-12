<?php
require('./includes/functions.php');
$pageTitle = 'トップページ';
?>

<!DOCTYPE html>
<html lang="ja">

<?php require('./includes/head.php'); ?>

<body>

    <?php require('./includes/header.php') ?>

    <div class="container">
        <main>
            <p class="intro">Golf Geek はレッスン動画を見て、質問してアドバイスをもらえるウェブサービスです。</p>
        </main>
        <aside>
            <?php require('./includes/column.php'); ?>
        </aside>
    </div>

    <?php require('./includes/footer.php'); ?>
    <script src="./js/index.js" type="module"></script>
</body>

</html>