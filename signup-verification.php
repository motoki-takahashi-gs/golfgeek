<?php

require("./includes/functions.php");

$verification = new Verification();

if ($verification->getGolferId() == false) checkSid();

// when a verification key parameter exists in URL
if ($verification->getVerificationKey()) {

    // when the non-verified user exists
    if ($verification->getGolfer(0)) {
        $verification->updateAccountAsVerified();
    } else {
        // when the verified user exists
        if ($verification->getGolfer(1)) {
            $verification->setVerificationMessage('アカウントは認証済みです。');
        } else {
            // when the user does not exist (no same verification key in the database)
            $verification->setVerificationMessage('異なる認証キーのため、アカウントを認証できません。');
        }
    }
} else {
    // when no verification key in URL parameter
    redirect('./index.php');
}

$pageTitle = 'アカウントの認証';

?>

<!DOCTYPE html>
<html lang="ja">

<?php require("./includes/head.php"); ?>

<body class="signup-verification">
    <?php require('./includes/header.php'); ?>
    <div class="container">
        <main>
            <h1><?php echo $pageTitle; ?></h1>
            <section>
                <div><?php echo $verification->getVerificationMessage(); ?></div>
            </section>
        </main>
        <aside>
            <?php require('./includes/column.php'); ?>
        </aside>
    </div>
    <?php require('./includes/footer.php'); ?>
    <script src="./js/signup-verification.js" type="module"></script>
</body>

</html>