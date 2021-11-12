<?php

preventDirectAccess();

session_start();

$siteTitle = 'Golf Geek';

function preventDirectAccess()
{
    if ((isIncludes() && !$_POST) || isClasses()) {
        redirect('../index.php');
    }
}

function isAdmin()
{
    return strpos($_SERVER['REQUEST_URI'], 'admin');
}

function isIncludes()
{
    return strpos($_SERVER['REQUEST_URI'], 'includes');
}

function isClasses()
{
    return strpos($_SERVER['REQUEST_URI'], 'classes');
}

function userType()
{
    return isAdmin() ? 'teaching_pro' : 'golfer';
}

function layer()
{
    return isAdmin() ? '../' : './';
}

// auto loader
spl_autoload_register('autoLoader');

function autoLoader($className)
{
    $path = __DIR__ . '/../classes/';
    $extension = '.php';
    $fullPath = $path . $className . $extension;
    if (!file_exists($fullPath)) return false;
    require_once $fullPath;
}

// Cross Site Scripting (XSS)
function specialChar($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

function redirect($page)
{
    header("Location: " . $page);
    exit;
}

function getIdentity()
{
    if (isset($_SESSION["sid"])) {
        $identity = isAdmin() ? $_SESSION["teaching_pro_id"] : $_SESSION["golfer_id"];
    } else {
        $identity = null;
    }
    return $identity;
}

function isNotIdentified($identity)
{
    if (!isset($identity) || $_SESSION["sid"] != session_id()) return true;
}

function giveNewSessionId()
{
    session_regenerate_id(true);
    $_SESSION["sid"] = session_id();
}

// check if the user is logged in
function checkSid()
{
    $url = './log-in.php';
    isNotIdentified(getIdentity()) ? redirect($url) : giveNewSessionId();
}

// for users who need to login before going to a detail page
function checkSidForRedirect($pageName, $id)
{
    $url = './log-in.php?page-name=' . $pageName . '&id=' . $id;
    isNotIdentified(getIdentity()) ? redirect($url) : giveNewSessionId();
}

function logOut($url)
{
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) setcookie(session_name(), '', time() - 42000, '/');
    session_unset();
    session_destroy();
    redirect($url);
}
