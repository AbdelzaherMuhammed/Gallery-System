<?php include("includes/init.php"); ?>

<?php if (!$session->signedIn()) {redirect('login.php');} ?>


<?php

if (empty($_GET['id']))
{
    redirect('users.php');
}


$user = User::findById($_GET['id']);

if ($user)
{
    $user->deletePhoto();
    $session->message('The user has been deleted successfully');
    redirect('users.php');
} else {
    redirect('users.php');
}





?>