<?php
require_once __DIR__ . '/functions.php';
$gender = new Gender();
?>

<div class="modal" id="sign-up-modal">
    <div class="modal-content-sign-up">
        <h1>アカウントの作成</h1>
        <form id="signup-form">
            <div><input type="text" placeholder="姓" name="lastName"></div>
            <div id="signupLastName-error" class="form-error"></div>
            <div><input type="text" placeholder="名" name="firstName"></div>
            <div id="signupFirstName-error" class="form-error"></div>
            <div class="position-relative">
                <select name="gender"><?php echo $gender->getGenderOptions(); ?></select>
                <span class="down-arrow"></span>
            </div>
            <div id="signupGender-error" class="form-error"></div>
            <div><input type="email" placeholder="メールアドレス" name="signup-email"></div>
            <div id="signupEmail-error" class="form-error"></div>
            <div><input type="password" placeholder="パスワード（6文字以上）" name="signup-password"></div>
            <div id="signupPassword-error" class="form-error"></div>
            <div><input type="hidden" value="<?php echo userType(); ?>" name="user_type"></div>
            <div id="signupUnable-error" class="form-error"></div>
            <div><button type="button" id="submit-signup">アカウントを作成</button></div>
        </form>
        <div class="go-to-log-in"><a href="#" id="go-to-log-in">ログイン画面へ</a></div>
        <span class="close">&times;</span>
    </div>
</div>