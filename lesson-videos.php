<?php

require('./includes/functions.php');

// when no course is selected
$pageTitle = 'レッスン動画';

// course ID in URL parameter
$courseId = filter_input(INPUT_GET, "id");

$lessonCourses = new LessonCourses();
$lessonCourses->setCourseList();

// when a course is selected
if ($courseId) {
    $lessonVideos = new LessonVideos();

    // get a course name of videos for title
    $pageTitle = $lessonVideos->getCourseName($courseId);
    $pageTitle .= 'コースの動画';

    $lessonVideos->setVideoList($courseId);

    // go back to top page of lesson videos when no video
    if (strpos($lessonVideos->getVideoList(), '<li>') == false) {
        $lessonVideos->goBackToLessonVideosTop();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<?php require('./includes/head.php'); ?>

<body class="lesson-videos">

    <?php
    if ($courseId) {
        require('./includes/sos-button.php');
        require('./includes/sos-modal.php');
        require('./includes/sos-complete-modal.php');
    }
    require('./includes/log-in-modal.php');
    require('./includes/sign-up-modal.php');
    require('./includes/sign-up-complete-modal.php');
    require('./includes/header.php');
    ?>

    <div class="container">
        <main>
            <h1><?php echo $pageTitle; ?></h1>
            <?php if ($courseId) : ?>
                <section class="video-list">
                    <?php echo $lessonVideos->getVideoList(); ?>
                </section>
            <?php else : ?>
                <section class="course-list">
                    <?php echo $lessonCourses->getCourseList(); ?>
                </section>
            <?php endif ?>
        </main>
        <aside>
            <?php if ($courseId) : ?>
                <?php echo $lessonCourses->getCourseList(); ?>
            <?php endif ?>
            <?php require('./includes/column.php'); ?>
        </aside>
    </div>

    <?php require('./includes/footer.php'); ?>
    <script src="./js/lesson-videos.js" type="module"></script>
</body>

</html>