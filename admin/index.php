<?php
require("../includes/functions.php");
checkSid();
$pageTitle = '管理者ページトップ';
?>

<!DOCTYPE html>
<html lang="ja">

<?php require("../includes/head.php"); ?>

<body>

    <?php require('../includes/header.php'); ?>

    <div class="container">
        <main>
            <section>
                <h1><?php echo $pageTitle; ?></h1>

            </section>
        </main>
        <aside>
            <?php require('../includes/column.php'); ?>
        </aside>
    </div>

    <?php require('../includes/footer.php'); ?>
    <script src="../js/index.js" type="module"></script>
</body>

</html>