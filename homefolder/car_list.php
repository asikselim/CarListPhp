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

$cars=$db->prepare("SELECT * FROM cars ORDER BY id DESC");

$cars->execute();

 ?>
<html>
<head>
  <title>Ödevim</title>
  <link href="../plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link href="../plugin/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../plugin/sweetalert2.min.css" type="text/css" />

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
          <a href="logout.php" class="btn btn-danger button-login">Çıkış Yap</a>
         </div>
      </div><!--/.nav-collapse -->
    </div>
  </div>

  <div class="container">
      <div class="page-header">
            <h3>Araç Listesi <a href="new_car.php" class="btn btn-lg btn-success pull-right"><span class="glyphicon glyphicon-plus"></span> Yeni Araç Ekle</a></h3>
      </div>
  </div>
  <div class="container">
 <div class="panel panel-default">
     <table class="table table-striped table-hover">
           <thead>
             <tr>
               <th>#</th>
               <th>Araç Adı</th>
               <th>Araç KM</th>
                <th>Kasa Tipi</th>
               <th>Renk</th>
               <th>Max Hız</th>
               <th>Ağırlık</th>
               <th>İşlemler</th>
             </tr>
           </thead>
           <tbody>
           <?php
           $say = 0;
           while ($cars_check=$cars->fetch(PDO::FETCH_ASSOC)) { $say++; ?>
             <tr>
               <td><input type="checkbox"></td>
               <td><?php echo $cars_check['ad'];?></td>
               <td><?php echo $cars_check['km'];?></td>
               <td><?php echo $cars_check['kasa_tipi'];?></td>
               <td><?php echo $cars_check['renk'];?></td>
               <td><?php echo $cars_check['max_hiz'];?></td>
               <td><?php echo $cars_check['agirlik'];?></td>
               <td>
                 <a href="car_edit.php?car_id=<?php echo $cars_check['id']; ?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span> Düzenle</a>
                 <button type="button" id="delete_car" data-id="<?php echo $cars_check['id']; ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove-circle"></span> Sil</button>
               </td>
             </tr>
           <?php }?>
           </tbody>
         </table>
         </div>
 </div>
  <script src="../plugin/js/jquery.min.js"></script>
  <script src="../plugin/js/sweetalert2.min.js"></script>
  <script src="../plugin/bootstrap/js/bootstrap.min.js"></script>

  <script>

      $(document).ready(function(){

          $(document).on('click', '#delete_car', function(e){

              var carId = $(this).data('id');

              SwalDelete(carId);

              e.preventDefault();

          });

      });
      function SwalDelete(carId){

          swal({

              title: 'İşlem Kalıcıdır?',

              text: "Silmek istediğinize eminmisiniz!",

              type: 'warning',

              showCancelButton: true,

              confirmButtonColor: '#3085d6',

              cancelButtonColor: '#d33',

              confirmButtonText: 'Evet!',

              showLoaderOnConfirm: true,

              preConfirm: function() {

                  return new Promise(function(resolve) {

                      $.ajax({

                          url: 'car_delete.php',

                          type: 'POST',

                          data: 'car_delete='+carId,

                          dataType: 'json'

                      })

                          .done(function(response){

                              swal('Başarılı!', response.message, response.status);

                              location.reload();

                          })

                          .fail(function(){

                              swal('Oops...', 'Something went wrong with ajax !', 'error');

                          });

                  });

              },

              allowOutsideClick: false

          });

      }
  </script>
</body>
</html>
