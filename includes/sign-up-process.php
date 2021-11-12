<?php

require("./functions.php");

$signup = new Signup();

if ($signup->isErrorObj() == true) return;
if ($signup->isEmailNotRegistered() == false) return;

$signup->hashPassword();
if ($signup->insertUserInfo() != true) return;

if ($signup->getUserType() == 'golfer') {
    $signup->setSessionVar();
    $sendEmail = new SendEmail('', $signup->getUserId());
    $sendEmail->setContentsForSignUp($signup->getVerificationKey());
    $sendEmail->sendEmail();
}

$signup->showSuccess();
exit();
