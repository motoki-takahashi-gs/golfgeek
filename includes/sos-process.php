<?php

require("./functions.php");

$sos = new Sos();

// when a file is attached
if ($sos->getFileName()) {

    // when the file is an image
    if (in_array($sos->getExtension(), $sos->getImgExtensions())) {
        $sos->resizeImage($sos->getExtension());
        $sos->setFileType(1);

        // when the file is a video
    } else if (in_array($sos->getExtension(), $sos->getVideoExtensions())) {
        $sos->setFileType(2);
    } else {
        // when the file is out of the permitted extensions
        $sos->outOfExtensions();
    }
}

if ($sos->isErrorObj() == true) return;

if ($sos->insertDescription() != true) return;
$sendEmail = new SendEmail($sos->getUserType(), $sos->getUserId());
$sendEmail->setContentsForSos($sos->getLastInsertId());

// when a file is attached
if ($sos->getFileName()) {
    $sos->setNewFileName();
    $sos->moveFileFromTmpPath();
    if ($sos->setFile() != true) return;
}

$sendEmail->sendEmail();
$sos->showSuccess();
