<?php
include 'connect.php';
@ob_start();
session_start();
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $users = $db->prepare("SELECT * FROM users where email=:email and password=:password and status=:status");
    $users->execute(array(
        'email' => $email,
        'password' => $password,
        'status' => 1,
    ));
    echo $say = $users->rowCount();
    if ($say == 1) {
        $_SESSION['email'] = $email;
        Header("Location:car_list.php");
        exit;
    } else {
        header("Location:login.php?status=danger");
        exit;
    }
}
if ($_SESSION) {
  $users = $db->prepare("SELECT * FROM users where email=:email");
  $users->execute(array(
      'email' => $_SESSION['email'],
  ));

  $say=$users->rowCount();
  $user_check=$users->fetch(PDO::FETCH_ASSOC);
  if ($say!=0) {
      Header("Location:car_list.php");
      exit;
  }
}
?>
<html>
<head>
  <title>Giriş Yap</title>
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

  		<h3 class="card-title text-center">Araç Listesi Giriş</h3>
  		<div class="card-text">
  			<div class="alert alert-danger alert-dismissible fade show" role="alert">Incorrect username or password.</div>
  			<form method="post">
  				<div class="form-group">
  					<label for="exampleInputEmail1">Email</label>
  					<input type="email" class="form-control form-control-sm" name="email">
  				</div>
  				<div class="form-group">
  					<label for="exampleInputPassword1">Şifre</label>
  					<a href="reset_password_form.php" style="float:right;font-size:12px;">Şifremi Unuttum</a>
  					<input type="password" class="form-control form-control-sm" name="password">
  				</div>
  				<button type="submit" name="login" class="btn btn-primary btn-block">Oturum Aç</button>

  				<div class="sign-up">
  					Hesabın yok mu? <a href="register.php">Bir tane oluşturun</a>
  				</div>
  			</form>
  		</div>
  	</div>
  </div>
  </div>
</body>
</html>
