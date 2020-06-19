<?php
include 'connect.php';

$users = $db->prepare("SELECT * FROM users where code=:code");
$users->execute(array(
    'code' => $_GET['code'],
));
$say=$users->rowCount();
$user_check=$users->fetch(PDO::FETCH_ASSOC);
if ($say!=0) {
    $edit = $db->prepare("UPDATE users SET status =:status WHERE id=:id");

    $update = $edit->execute(array(
        'status' => 1,
        'id' => $user_check['id']
    ));
    if ($update) {
        header("Location:login.php?status=success");
    }else {
        header("Location:login.php?status=danger");
    }
}


?>
