<?php
include 'connect.php';
@ob_start();
session_start();
$users = $db->prepare("SELECT * FROM users where email=:email");
$users->execute(array(
    'email' => $_SESSION['email'],
));

$say=$users->rowCount();
$user_check=$users->fetch(PDO::FETCH_ASSOC);
if ($say==0) {
    Header("Location:login.php?status=unauthorized");
    exit;
}
if (isset($_POST['add_car'])) {

    $ad = $_POST['ad'];
    $yakit = $_POST['yakit'];
    $vites = $_POST['vites'];
    $km = $_POST['km'];
    $kasa_tipi = $_POST['kasa_tipi'];
    $motor_gucu = $_POST['motor_gucu'];
    $cekis = $_POST['cekis'];
    $renk = $_POST['renk'];
    $teker = $_POST['teker'];
    $max_hiz = $_POST['max_hiz'];
    $agirlik = $_POST['agirlik'];
    $durum = $_POST['durum'];

    $new_car_add = $db->prepare("INSERT INTO cars SET
         ad =:ad,
         yakit =:yakit,
         vites =:vites,
         km =:km,
         kasa_tipi =:kasa_tipi,
         motor_gucu =:motor_gucu,
         cekis =:cekis,
         renk =:renk,
         teker =:teker,
         max_hiz =:max_hiz,
         agirlik =:agirlik,
         durum =:durum");

    $insert = $new_car_add->execute(array(
        'ad' => $_POST['ad'],
        'yakit' => $_POST['yakit'],
        'vites' => $_POST['vites'],
        'km' => $_POST['km'],
        'kasa_tipi' => $_POST['kasa_tipi'],
        'motor_gucu' => $_POST['motor_gucu'],
        'cekis' => $_POST['cekis'],
        'renk' => $_POST['renk'],
        'teker' => $_POST['teker'],
        'max_hiz' => $_POST['max_hiz'],
        'agirlik' => $_POST['agirlik'],
        'durum' => $_POST['durum']));

    if ($insert) {
        header("Location:car_list.php?status=success");
    }else {
        header("Location:car_list.php?status=danger");
    }
}
?>
<html>
<head>
  <title>Yeni Araç</title>
  <link href="../plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link href="../plugin/style.css" rel="stylesheet">
  <script src="../plugin/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Hoş Geldiniz</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Hoş Geldiniz</a>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="car_list.php"><span class="glyphicon glyphicon-comment"></span> Araç Listesi</a></li>
        </ul>
         <div class="nav navbar-right">
          <a href="logout.php" class="btn btn-danger navbar-btn dropdown-toggle button-login" data-toggle="dropdown">Çıkış Yap</a>
         </div>
      </div><!--/.nav-collapse -->
    </div>
  </div>
  <div class="container">
      <div class="page-header">
          <h3>Araç Ekleme</h3>
      </div>
  </div>
  <div class="container">
 <div class="panel panel-default">
   <div class="container">
     <form method="post">
       <div class="row">
         <div class="col-md-6">
           <div class="form-group">
             <label for="first">Ad</label>
             <input type="text" class="form-control" placeholder="" name="ad">
           </div>
         </div>
         <!--  col-md-6   -->

         <div class="col-md-6">
           <div class="form-group">
             <label for="last">Yakıt</label>
               <select class="form-control" name="yakit">
                   <option value="Dizel">Dizel</option>
                   <option value="Benzin">Benzin</option>
                   <option value="Lpg">Lpg</option>
               </select>
           </div>
         </div>
         <div class="col-md-6">
           <div class="form-group">
             <label for="last">Vites</label>
               <select class="form-control" name="vites">
                   <option value="Otomatik">Otomatik</option>
                   <option value="Manuel">Manuel</option>
               </select>
           </div>
         </div>
         <div class="col-md-6">
           <div class="form-group">
             <label for="last">KM</label>
               <input type="text" class="form-control" placeholder="" name="km">
           </div>
         </div>
           <div class="col-md-6">
               <div class="form-group">
                   <label for="last">Kasa Tipi</label>
                   <select class="form-control" name="kasa_tipi">
                       <option value="Sedan">Sedan</option>
                       <option value="Hatchback">Hatchback</option>
                       <option value="Station wagon">Station wagon</option>
                       <option value="Cabrio">Cabrio</option>
                       <option value="Pick up">Pick up</option>
                   </select>
               </div>
           </div>
           <div class="col-md-6">
               <div class="form-group">
                   <label for="last">Motor Gücü</label>
                   <input type="text" class="form-control" placeholder="" name="motor_gucu">
               </div>
           </div>
           <div class="col-md-6">
               <div class="form-group">
                   <label for="last">Çekiş</label>
                   <select class="form-control" name="cekis">
                       <option value="Önden Çekiş">Önden Çekiş</option>
                       <option value="Arkadan Çekiş">Arkadan Çekiş</option>
                       <option value="4X4">4X4</option>
                   </select>
               </div>
           </div>
           <div class="col-md-6">
               <div class="form-group">
                   <label for="last">Renk</label>
                   <select class="form-control" name="renk">
                       <option value="Kırmızı">Kırmızı</option>
                       <option value="Maviş">Mavi</option>
                       <option value="Siyah">Siyah</option>
                       <option value="Beyaz">Beyaz</option>
                       <option value="Gri">Gri</option>
                   </select>
               </div>
           </div>
           <div class="col-md-6">
               <div class="form-group">
                   <label for="last">Teker</label>
                   <select class="form-control" name="teker">
                       <option value="1">1</option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       <option value="4">4</option>
                   </select>
               </div>
           </div>
           <div class="col-md-6">
               <div class="form-group">
                   <label for="last">Max Hız</label>
                   <input type="text" class="form-control" placeholder="" name="max_hiz">
               </div>
           </div>
           <div class="col-md-6">
               <div class="form-group">
                   <label for="last">Ağırlık</label>
                   <input type="text" class="form-control" placeholder="" name="agirlik">
               </div>
           </div>
           <div class="col-md-6">
               <div class="form-group">
                   <label for="last">Durum</label>
                   <select class="form-control" name="durum">
                       <option value="1">Yayında</option>
                       <option value="0">Yayında Değil</option>
                   </select>
               </div>
           </div>
       </div>
       <button type="submit" class="btn btn-primary" name="add_car">Ekle</button>
     </form>
   </div>
 </div>
</body>
</html>
