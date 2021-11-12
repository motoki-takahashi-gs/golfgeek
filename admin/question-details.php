<?php
require("../includes/functions.php");

$pageName = basename($_SERVER['PHP_SELF'], '.php');
$questionId = filter_input(INPUT_GET, 'id');
$questionId ? checkSidForRedirect($pageName, $questionId) : checkSid();

$userType = 'teaching_pro';
$questionDetails = new QuestionDetails($userType);
$advices = new Advices($userType);

if ($questionDetails->getQuestionId()) {
    $pageTitle = '質問番号 ' . $questionDetails->getQuestionId() . ' の詳細';
    $questionDetails->setQuestionDetails();
    $questionDetails->setGolferId();
    $advices->setAdvices();
} else {
    $questionDetails->goBackToQuestions();
}
?>

<!DOCTYPE html>
<html lang="ja">
<?php require("../includes/head.php"); ?>

<body class="question-details">
    <?php
    require('../includes/header.php');
    require('../includes/advise-modal.php');
    require('../includes/advise-complete-modal.php');
    ?>

    <div class="container">
        <main>
            <h1><?php echo $pageTitle; ?></h1>
            <section>
                <div>
                    <button type="button" id="go-back" class="go-back">戻る</button>
                </div>
                <div class="question-info">
                    <?php echo $questionDetails->getQuestionDetails(); ?>
                </div>
            </section>
            <?php if ($advices->getAdvices()) : ?>
                <section>
                    <?php echo $advices->getAdvices(); ?>
                </section>
            <?php endif ?>
        </main>
        <aside>
            <?php require('../includes/column.php'); ?>
        </aside>
    </div>
    <?php require('../includes/footer.php'); ?>
    <script src="../js/question-details-admin.js" type="module"></script>
</body>

</html>