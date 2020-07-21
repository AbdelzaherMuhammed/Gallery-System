<?php include("includes/init.php"); ?>

<?php if (!$session->signedIn()) {redirect('login.php');} ?>


<?php
$comment = Comment::findById($_GET['id']);

if (empty($_GET['id']))
{
    redirect("comment_photo.php?id={$comment->photo_id}");
}


$user = Comment::findById($_GET['id']);

if ($user)
{
    $user->delete();
    redirect("comment_photo.php?id={$comment->photo_id}");
    $session->message('The comment has been deleted successfully');

} else {
    redirect("comment_photo.php?id={$comment->photo_id}");
}





?>