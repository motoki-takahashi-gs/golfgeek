<?php
require("../includes/functions.php");

if (isset($_SESSION["teaching_pro_id"]) && isset($_SESSION["sid"])) {
    redirect('./index.php');
}

$pageTitle = '管理者ログイン';
?>

<!DOCTYPE html>
<html lang="ja">

<?php require("../includes/head.php"); ?>

<body class="login admin">

    <?php require('../includes/header.php'); ?>

    <div class="container">
        <main>
            <?php require('../includes/log-in-modal.php'); ?>
        </main>
    </div>

    <?php require('../includes/footer.php'); ?>
    <script src="../js/log-in.js" type="module"></script>
</body>

</html>