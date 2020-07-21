<?php include("includes/init.php"); ?>

<?php if (!$session->signedIn()) {redirect('login.php');} ?>


<?php

if (empty($_GET['id']))
{
    redirect('photos.php');
}


$photo = Photo::findById($_GET['id']);

if ($photo)
{
    $photo->deletePhoto();
    redirect('photos.php');
    $session->message('The photo has been deleted successfully');
} else {
    redirect('photos.php');
}





?>
