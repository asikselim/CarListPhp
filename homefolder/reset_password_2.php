<?php
include 'connect.php';
require_once "../plugin/phpmail/class.phpmailer.php";
require_once "../plugin/phpmail/PHPMailerAutoload.php";

if (isset($_POST['new_password'])) {

    $code = $_GET['code'];
    $users = $db->prepare("SELECT * FROM users where code=:code");
    $users->execute(array(
        'code' => $code
    ));
    $user_check=$users->fetch(PDO::FETCH_ASSOC);
    $say = $users->rowCount();
    if ($say == 1) {
    $edit = $db->prepare("UPDATE users SET password =:password WHERE id=:id");
    $update = $edit->execute(array(
        'password' => md5($_POST['password']),
        'id' => $user_check['id']
    ));
    if ($update) {
        header("Location:login.php?status=success");
    }else {
        header("Location:login.php?status=danger");
    }

    } else {
        header("Location:login.php?status=danger");
        exit;
    }
}
?>
<html>
<head>
    <title>Şifremi Unuttum</title>
    <link href="../plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="../plugin/style.css" rel="stylesheet">
    <script src="../plugin/bootstrap/js/bootstrap.min.js"></script>
    <style>

    </style>
</head>
<body>
<div class="global-container">
    <div class="card login-form">
        <div class="card-body">
            <h3 class="card-title text-center">Şifremi Unuttum</h3>
            <div class="card-text">
                <form method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Yeni Şifre</label>
                        <input type="password" class="form-control form-control-sm" name="password">
                    </div>
                    <button type="submit" name="new_password" class="btn btn-primary btn-block">Yenile</button>

                    <div class="sign-up">
                        Hesabın varmı? <a href="login.php">Giriş Yap</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

