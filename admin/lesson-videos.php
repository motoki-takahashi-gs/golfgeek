<?php

require __DIR__ . '/../includes/functions.php';
checkSid();

// when no course is selected
$pageTitle = 'レッスン動画の登録';

// Course ID and mode in URL parameter
$courseId = filter_input(INPUT_GET, "id");
$mode = filter_input(INPUT_GET, "mode");

$lessonCourses = new LessonCourses();
$lessonCourses->setCourseList();

// when a course is selected
if ($courseId) {
    $lessonVideos = new LessonVideos();

    // get a course name of videos for title
    $pageTitle = $lessonVideos->getCourseName($courseId);

    // normal video list (non-edit mode)
    if ($mode != 'edit') {
        $pageTitle .= 'コースの動画';
        $lessonVideos->setVideoList($courseId);
    } else {
        // make options of lesson courses for edit mode
        $lessonCourses->setCourseOptions($courseId);

        // editable video list (edit mode)
        $pageTitle .= 'コース動画の編集';
        $lessonVideos->setVideoListToEdit($courseId, $lessonCourses->getCourseOptions());
    }

    // go back to top page of lesson videos when no video
    if (strpos($lessonVideos->getVideoList(), '<li>') == false) {
        $lessonVideos->goBackToLessonVideosTop();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<?php require("../includes/head.php"); ?>

<body class="lesson-videos admin">

    <?php
    require('../includes/header.php');

    if (($courseId) && ($mode != 'edit')) {
        require('../includes/add-video-modal.php');
        require('../includes/add-video-complete-modal.php');
    } else if (($courseId) && ($mode == 'edit')) {
        require('../includes/delete-video-modal.php');
    }
    ?>

    <div class="container">
        <main>
            <h1><?php echo $pageTitle; ?></h1>

            <?php if (($courseId) && ($mode != 'edit')) : ?>
                <section class="button">
                    <button type="button" id="open-add-video-modal">動画を追加する</button>
                    <a href="<?php echo $lessonVideos->getEditModeQueryString($courseId); ?>">
                        <button type="button">編集する</button>
                    </a>
                </section>
            <?php endif ?>
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
            <?php require('../includes/column.php'); ?>
        </aside>
    </div>
    <?php require('../includes/footer.php'); ?>
    <script src="../js/lesson-videos-admin.js" type="module"></script>
</body>

</html>