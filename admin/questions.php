<?php

require("../includes/functions.php");
checkSid();

// when no course is selected
$pageTitle = 'SOSされた質問';

$questions = new Questions('teaching_pro');
$questions->setUpQuestions();
?>

<!DOCTYPE html>
<html lang="ja">

<?php require("../includes/head.php"); ?>

<body class="questions">
    <?php require('../includes/header.php'); ?>
    <div class="container">
        <main>
            <h1><?php echo $pageTitle; ?></h1>
            <section>
                <div class="question-count"><?php echo $questions->getNumberOfQuestions(); ?></div>
                <div>
                    <?php echo $questions->getQuestionList(); ?>
                </div>
                <div class="pagination">
                    <div>
                        <?php echo $questions->getPreviousPageLink(); ?>
                    </div>
                    <div>
                        <?php echo $questions->getNextPageLink(); ?>
                    </div>
                </div>
            </section>
        </main>
        <aside>
            <?php require('../includes/column.php'); ?>
        </aside>
    </div>
    <?php require('../includes/footer.php'); ?>
    <script src="../js/questions.js" type="module"></script>
</body>

</html>