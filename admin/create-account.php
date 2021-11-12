<?php
require("../includes/functions.php");
checkSid();
$pageTitle = '管理者アカウントの作成';
?>

<!DOCTYPE html>
<html lang="ja">

<?php require("../includes/head.php"); ?>

<body class="create-account">

    <?php
    require('../includes/header.php');
    require('../includes/create-account-complete-modal.php');
    ?>

    <div class="container">
        <main>
            <?php require('../includes/sign-up-modal.php'); ?>
        </main>
        <aside>
            <?php require('../includes/column.php'); ?>
        </aside>
    </div>

    <?php require('../includes/footer.php'); ?>
    <script src="../js/create-account.js" type="module"></script>
</body>

</html>