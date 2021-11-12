<?php
require("./functions.php");

$addVideo = new AddVideo();

if ($addVideo->isErrorObj() == true) return;
if ($addVideo->insertVideo() == true) $addVideo->showSuccess();
