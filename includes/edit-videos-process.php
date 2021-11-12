<?php

require('./functions.php');

$editVideos = new EditVideos();
if ($editVideos->isErrorObj() == true) return;
if ($editVideos->updateVideos() == true) $editVideos->showSuccess();
