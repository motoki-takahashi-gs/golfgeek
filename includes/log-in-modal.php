<?php require_once __DIR__ . '/functions.php'; ?>
<div class="modal" id="log-in-modal">
    <div class="modal-content-log-in">
        <h1>ログイン</h1>
        <form id="login-form">
            <div><input type="email" placeholder="メールアドレス" name="login-email"></div>
            <div id="loginEmail-error" class="form-error"></div>
            <div><input type="password" placeholder="パスワード" name="login-password"></div>
            <div id="loginPassword-error" class="form-error"></div>
            <div><input type="hidden" value="<?php echo userType(); ?>" name="user_type"></div>
            <div id="loginUnable-error" class="form-error"></div>
            <div><button type="button" id="submit-login">ログイン</button></div>
        </form>
        <div class="go-to-sign-up"><a href="#" id="go-to-sign-up">アカウントを持っていない方</a></div>
        <span class="close">&times;</span>
    </div>
</div>