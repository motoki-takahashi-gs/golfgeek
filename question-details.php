<?php
require("./includes/functions.php");

$pageName = basename($_SERVER['PHP_SELF'], '.php');
$questionId = filter_input(INPUT_GET, 'id');
$questionId ? checkSidForRedirect($pageName, $questionId) : checkSid();

$userType = 'golfer';
$questionDetails = new QuestionDetails($userType);
$advices = new Advices($userType);

if ($questionDetails->getQuestionId()) {
    $pageTitle = '質問番号 ' . $questionDetails->getQuestionId() . ' の詳細';
    $questionDetails->setQuestionDetails();

    // to prevent users from accessing detail pages which other users made
    if ($questionDetails->getGolferId() != $questionDetails->getGolferIdFromRow()) {
        $questionDetails->goBackToQuestions();
    }
    $advices->setAdvices();
} else {
    $questionDetails->goBackToQuestions();
}
?>

<!DOCTYPE html>
<html lang="ja">
<?php require("./includes/head.php"); ?>

<body class="question-details">

    <?php require('./includes/header.php'); ?>

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
            <?php require('./includes/column.php'); ?>
        </aside>
    </div>
    <?php require('./includes/footer.php'); ?>
    <script src="./js/question-details.js" type="module"></script>
</body>

</html>