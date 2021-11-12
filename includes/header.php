<?php require_once __DIR__ . '/functions.php'; ?>
<header>
    <?php
    require(__DIR__ . '/logo.php');
    require(__DIR__ . '/hamburger.php');
    isAdmin() ? require(__DIR__ . '/../includes/menu-admin.php') : require(__DIR__ . '/../includes/menu.php');
    ?>
</header>