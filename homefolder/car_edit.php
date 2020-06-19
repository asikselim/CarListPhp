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
$car_detail = $db->prepare("SELECT * from cars where id =:id");
$car_detail->execute(array(
    'id' => $_GET['car_id'],
));

$car_detail_check = $car_detail->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['edit_car'])) {
    $get_id_car = $_GET['car_id'];
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

    $car_edit = $db->prepare("UPDATE cars SET
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
         durum =:durum
         WHERE id=:id");

    $update = $car_edit->execute(array(
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
        'durum' => $_POST['durum'],
        'id' => $get_id_car
    ));

    if ($update) {
        header("Location:car_list.php?status=success");
    }else {
        header("Location:car_list.php?status=danger");
    }
}
?>
<html>
<head>
    <title>Araç Düzenle</title>
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
        <h3>Araç Düzenleme</h3>
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
                            <input type="text" class="form-control" placeholder="" name="ad" value="<?php echo $car_detail_check['ad'];?>">
                        </div>
                    </div>
                    <!--  col-md-6   -->

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last">Yakıt</label>
                            <select class="form-control" name="yakit">
                                <option value="Dizel" <?php echo $car_detail_check["yakit"] == "Dizel" ? 'selected ' : null; ?>>Dizel</option>
                                <option value="Benzin" <?php echo $car_detail_check["yakit"] == "Benzin" ? 'selected ' : null; ?>>Benzin</option>
                                <option value="Lpg" <?php echo $car_detail_check["yakit"] == "Lpg" ? 'selected ' : null; ?>>Lpg</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last">Vites</label>
                            <select class="form-control" name="vites">
                                <option value="Otomatik" <?php echo $car_detail_check["vites"] == "Otomatik" ? 'selected ' : null; ?>>Otomatik</option>
                                <option value="Manuel" <?php echo $car_detail_check["vites"] == "Manuel" ? 'selected ' : null; ?>>Manuel</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last">KM</label>
                            <input type="text" class="form-control" placeholder="" name="km" value="<?php echo $car_detail_check['km'];?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last">Kasa Tipi</label>
                            <select class="form-control" name="kasa_tipi">
                                <option value="Sedan" <?php echo $car_detail_check["kasa_tipi"] == "Sedan" ? 'selected ' : null; ?>>Sedan</option>
                                <option value="Hatchback" <?php echo $car_detail_check["kasa_tipi"] == "Hatchback" ? 'selected ' : null; ?>>Hatchback</option>
                                <option value="Station wagon" <?php echo $car_detail_check["kasa_tipi"] == "Station wagon" ? 'selected ' : null; ?>>Station wagon</option>
                                <option value="Cabrio" <?php echo $car_detail_check["kasa_tipi"] == "Cabrio" ? 'selected ' : null; ?>>Cabrio</option>
                                <option value="Pick up" <?php echo $car_detail_check["kasa_tipi"] == "Pick up" ? 'selected ' : null; ?>>Pick up</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last">Motor Gücü</label>
                            <input type="text" class="form-control" placeholder="" name="motor_gucu" value="<?php echo $car_detail_check['motor_gucu'];?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last">Çekiş</label>
                            <select class="form-control" name="cekis">
                                <option value="Önden Çekiş" <?php echo $car_detail_check["cekis"] == "Önden Çekiş" ? 'selected ' : null; ?>>Önden Çekiş</option>
                                <option value="Arkadan Çekiş" <?php echo $car_detail_check["cekis"] == "Arkadan Çekiş" ? 'selected ' : null; ?>>Arkadan Çekiş</option>
                                <option value="4X4" <?php echo $car_detail_check["cekis"] == "4X4" ? 'selected ' : null; ?>>4X4</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last">Renk</label>
                            <select class="form-control" name="renk">
                                <option value="Kırmızı" <?php echo $car_detail_check["renk"] == "Kırmızı" ? 'selected ' : null; ?>>Kırmızı</option>
                                <option value="Mavi" <?php echo $car_detail_check["renk"] == "Mavi" ? 'selected ' : null; ?>>Mavi</option>
                                <option value="Siyah" <?php echo $car_detail_check["renk"] == "Siyah" ? 'selected ' : null; ?>>Siyah</option>
                                <option value="Beyaz" <?php echo $car_detail_check["renk"] == "Beyaz" ? 'selected ' : null; ?>>Beyaz</option>
                                <option value="Gri" <?php echo $car_detail_check["renk"] == "Gri" ? 'selected ' : null; ?>>Gri</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last">Teker</label>
                            <select class="form-control" name="teker">
                                <option value="1" <?php echo $car_detail_check["teker"] == "1" ? 'selected ' : null; ?>>1</option>
                                <option value="2" <?php echo $car_detail_check["teker"] == "2" ? 'selected ' : null; ?>>2</option>
                                <option value="3" <?php echo $car_detail_check["teker"] == "3" ? 'selected ' : null; ?>>3</option>
                                <option value="4" <?php echo $car_detail_check["teker"] == "4" ? 'selected ' : null; ?>>4</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last">Max Hız</label>
                            <input type="text" class="form-control" placeholder="" name="max_hiz" value="<?php echo $car_detail_check['max_hiz'];?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last">Ağırlık</label>
                            <input type="text" class="form-control" placeholder="" name="agirlik" value="<?php echo $car_detail_check['agirlik'];?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last">Durum</label>
                            <select class="form-control" name="durum">
                                <option value="1" <?php echo $car_detail_check["durum"] == "1" ? 'selected ' : null; ?>>Yayında</option>
                                <option value="0" <?php echo $car_detail_check["durum"] == "0" ? 'selected ' : null; ?>>Yayında Değil</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="edit_car">Düzenle</button>
            </form>
        </div>
    </div>
</body>
</html>
