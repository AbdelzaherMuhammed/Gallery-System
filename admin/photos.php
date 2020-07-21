<?php include("includes/header.php"); ?>
<?php if (!$session->signedIn()) {
    redirect('login.php');
} ?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">


        <?php
        $photos = User::findById($_SESSION['user_id'])->photos();

        ?>


        <?php include('includes/top_nav.php') ?>


        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

        <?php include('includes/side_nav.php') ?>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Photos Page
                    </h1>
                    <p class="bg-success"><?php echo $message ?></p>

                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Id</th>
                                <th>File Name</th>
                                <th>Title</th>
                                <th>Size</th>
                                <th>Comments</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($photos as $photo) : ?>
                                <tr>

                                    <td><img class="admin-photo-thumbnail" src="<?php echo $photo->picturePath(); ?>"
                                             alt="">

                                        <div class="action_links">
                                            <a href="delete_photo.php?id=<?php echo $photo->id; ?>"
                                               class="btn btn-danger btn-xs delete_link"><i class="fa fa-trash "> Delete</i></a>
                                            <a href="edit_photo.php?id=<?php echo $photo->id ?>"
                                               class="btn btn-success btn-xs"><i class="fa fa-edit">
                                                    Edit </i></a>
                                            <a href="../photo.php?id=<?php echo $photo->id ?>"
                                               class="btn btn-primary btn-xs"><i class="fa fa-eye">
                                                    View </i></a>
                                        </div>

                                    </td>
                                    <td><?php echo $photo->id; ?></td>
                                    <td><?php echo $photo->image; ?></td>
                                    <td><?php echo $photo->title; ?></td>
                                    <td><?php echo $photo->size; ?></td>
                                    <td><a href="comment_photo.php?id=<?php echo $photo->id ?>">
                                            <?php
                                                $comments = Comment::findComment($photo->id);
                                                echo count($comments);
                                            ?>
                                        </a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                            </tbody>
                        </table> <!-- End of table !-->
                    </div>


                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>