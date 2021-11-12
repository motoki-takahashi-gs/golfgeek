<?php
require_once __DIR__ . '/functions.php';
$sosOrLogin = isset($_SESSION['sid']) && isset($_SESSION["golfer_id"]) ? 'open-sos' : 'open-login';
?>

<div class="sos"><button type="button" id="<?php echo $sosOrLogin; ?>">SOS プロに質問する！</button></div>