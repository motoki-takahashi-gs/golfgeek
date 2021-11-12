<?php
require('./includes/functions.php');

// when the user has already logged in now
if (isset($_SESSION['golfer_id'])) {
    $pageName = filter_input(INPUT_GET, 'page-name');
    $id = filter_input(INPUT_GET, 'id');

    // when coming from an email to go to a detail page
    if ($pageName && $id) {
        $redirectUrl = './' . $pageName . '.php?id=' . $id;
        redirect($redirectUrl);

        // when the user just goes to the login page
    } else {
        redirect('./index.php');
    }
}

$pageTitle = 'ログイン';
?>

<!DOCTYPE html>
<html lang="ja">

<?php require('./includes/head.php'); ?>

<body class="login golfer">

    <?php require('./includes/header.php'); ?>

    <div class="container">
        <main>
            <?php require('./includes/log-in-modal.php'); ?>
        </main>
        <aside>
            <?php require('./includes/column.php'); ?>
        </aside>
    </div>

    <?php require('./includes/footer.php'); ?>
    <script src="./js/log-in.js" type="module"></script>
</body>

</html>