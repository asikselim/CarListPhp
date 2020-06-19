<?php
include 'connect.php';
$car_delete = $db->prepare("DELETE from cars where id=:id");

$kontrol = $car_delete->execute(array(
    'id' => $_POST['car_delete'],
));

if ($kontrol) {
    $response['status'] = 'success';
    $response['message'] = 'Araç başarılı birşekilde silindi';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Araç Silinirken bir hata oluştu....';
}
echo json_encode($response);

?>
