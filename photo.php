<?php include("includes/header.php"); ?>
<?php require_once "admin/includes/init.php";


if (empty($_GET['id'])) {
    redirect('index.php');
}

$photo = Photo::findById($_GET['id']);


if (isset($_POST['submit'])) {
    $author = trim($_POST['author']);
    $body = trim($_POST['body']);

    $newComment = Comment::createComment($photo->id, $author, $body);

    if ($newComment && $newComment->save()) {

        redirect("photo.php?id={$photo->id}");
        $session->message('The comment has been added successfully');

    } else {
        $message = 'There was some problem saving';
    }
} else {
    $author = '';
    $body = '';
}


$Comments = Comment::findComment($photo->id);

?>


<div class="row">
    <!-- Blog Post Content Column -->
    <div class="col-lg-12">

        <!-- Blog Post -->

        <!-- Title -->
        <h1><?php echo $photo->title ?></h1>

        <!-- Author -->
        <p class="lead">
            by <a href="#"> Abdelzaher Muhammed </a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p><span class="glyphicon glyphicon-time"></span> Posted on August 24, 2013 at 9:00 PM</p>

        <hr>

        <!-- Preview Image http://placehold.it/900x300-->
        <img class="img-responsive" src="admin/<?php echo $photo->picturePath(); ?>" alt="">

        <hr>

        <!-- Post Content -->
        <p class="lead"><?php echo $photo->caption ?></p>
        <p><?php echo $photo->description ?></p>

        <hr>

        <!-- Blog Comments -->
        <p class="bg-success"><?php echo $message ?></p>

        <!-- Comments Form -->


        <div class="well">
            <h4>Leave a Comment:</h4>
            <form role="form" method="post">
                <div class="form-group">
                    <label for="author">Author</label>
                    <input type="text" name="author" class="form-control">
                </div>

                <div class="form-group">
                    <textarea name="body" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>


        <hr>

        <!-- Posted Comments -->

        <!-- Comment -->
        <?php foreach ($Comments as $comment): ?>
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $comment->author ?>
                    </h4>
                    <?php echo $comment->body ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Comment -->


    </div>

    <!--    <div class="col-md-4">-->
    <!--        --><?php //include("includes/sidebar.php"); ?>
    <!--    </div>-->
    <!-- /.row -->
</div>

<?php include("includes/footer.php"); ?>
