<?php include("includes/init.php"); ?>

<?php if (!$session->signedIn()) {redirect('login.php');} ?>


<?php

if (empty($_GET['id']))
{
    redirect('comments.php');
}


$user = Comment::findById($_GET['id']);

if ($user)
{
    $user->delete();
    $session->message('The comment has been deleted successfully');

    redirect('comments.php');
} else {
    redirect('comments.php');
}





?>