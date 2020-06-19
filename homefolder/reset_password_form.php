<?php
include 'connect.php';
@ob_start();
session_start();
require_once "../plugin/phpmail/class.phpmailer.php";
require_once "../plugin/phpmail/PHPMailerAutoload.php";

if (isset($_POST['new_password'])) {

    $email = $_POST['email'];

    $users = $db->prepare("SELECT * FROM users where email=:email");
    $users->execute(array(
        'email' => $email
    ));
    $user_check=$users->fetch(PDO::FETCH_ASSOC);

    $say = $users->rowCount();
    if ($say == 1) {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'ssl://smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'selimasik2@gmail.com';
        $mail->Password = 'root12345!';
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;
        $mail->setFrom($_POST['email'], 'Şifremi Unuttum');
        $mail->addAddress($_POST['email'], 'Şifremi Unuttum');
        $mail->Subject = 'Şifremi Unuttum';
        $mail->isHTML(TRUE);
        $mail->Body = '<html><a target="_blank" href="http://finalodevi.unaux.com/homefolder/reset_password_2.php?code='.$user_check['code'].'">Şifreni değiştir.</a></html>';
        $mail->send();
        Header("Location:reset_password_form.php?status=success");
        exit;
    } else {
        header("Location:login.php?status=danger?status=danger");
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
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control form-control-sm" name="email">
                    </div>
                    <button type="submit" name="new_password" class="btn btn-primary btn-block">Mail adresime talep gönder</button>

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
