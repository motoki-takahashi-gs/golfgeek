<?php

require("./functions.php");

$login = new Login();

if ($login->isErrorObj() == true) return;
if ($login->isEmailRegistered() == false) return;

if ($login->isPasswordCorrect()) {
    $login->setSessionVar();
    $login->showSuccess();
} else {
    $login->incorrectPassword();
}

exit();
