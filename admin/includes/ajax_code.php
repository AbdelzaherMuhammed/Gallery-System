<?php
require_once 'init.php';

$user = new User();


if (isset($_POST['image_name'], $_POST['user_id'])) {


    $user->ajaxSaveUserImage($_POST['image_name'], $_POST['user_id']);
}
if (isset($_POST['photo_id'])) {
    Photo::displaySideBarData($_POST['photo_id']);
}



