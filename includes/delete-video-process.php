<?php

require('./functions.php');

$deleteVideo = new DeleteVideo();
if ($deleteVideo->deleteVideo() == true) $deleteVideo->showSuccess();
