<?php
include 'connect.php';
session_start();
session_destroy();
require_once "../plugin/phpmail/class.phpmailer.php";

require_once "../plugin/phpmail/PHPMailerAutoload.php";
if (isset($_POST['register'])) {

    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $length = 10;

    $users = $db->prepare("SELECT * FROM users where email=:email");
    $users->execute(array(
        'email' => $email
    ));
    $user_check=$users->fetch(PDO::FETCH_ASSOC);

    $say = $users->rowCount();
    if ($say != 1)
    {
        $code = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
        $new_user_add = $db->prepare("INSERT INTO users SET
         ad =:ad,
         soyad =:soyad,
         email =:email,
         code =:code,
         status =:status,
         password =:password");
        $insert = $new_user_add->execute(array(
            'ad' => $_POST['ad'],
            'soyad' => $_POST['soyad'],
            'email' => $_POST['email'],
            'code' => $code,
            'status' => 0,
            'password' => md5($_POST['password'])));
        if ($insert) {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = 'ssl://smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'selimasik2@gmail.com';
            $mail->Password = 'root12345!';
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;
            $mail->setFrom($_POST['email'], 'Hesap Aktive');
            $mail->addAddress($_POST['email'], 'Hesap Aktive');
            $mail->Subject = 'Hesap Aktive';
            $mail->isHTML(TRUE);
            $mail->Body = '<html><a target="_blank" href="http://finalodevi.unaux.com/homefolder/mail_active.php?code='.$code.'">Hesabı Aktifleştir.</a></html>';
            if($mail->send())
            {
                header("Location:login.php?status=success");
            }else{
                header("Location:login.php?status=danger");
            }

        }else {
            header("Location:register.php?status=danger");
        }
    }else
    {
        header("Location:register.php?status=danger");
    }

}
?>
<html>
<head>
    <title>Hesap Oluşturun</title>
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

            <h3 class="card-title text-center">Araç Listesi Kayıt</h3>
            <div class="card-text">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">Incorrect username or password.</div>
                <form method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ad</label>
                        <input type="text" class="form-control form-control-sm" name="ad">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Soyad</label>
                        <input type="text" class="form-control form-control-sm" name="soyad">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control form-control-sm" name="email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Şifre</label>
                        <input type="password" class="form-control form-control-sm" name="password">
                    </div>
                    <button type="submit" name="register" class="btn btn-primary btn-block">Hesap Oluşturun</button>

                    <div class="sign-up">
                        Hesabın var mı? <a href="login.php">Oturum Aç</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
