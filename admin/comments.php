<?php include("includes/header.php"); ?>
<?php if (!$session->signedIn()) {
    redirect('login.php');
} ?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">


        <?php
        $comments = Comment::findAll();
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
                        Comments Page
                    </h1>

                    <p class="bg-success"><?php echo $message ?></p>

                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Body</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($comments as $comment) : ?>
                                <tr>
                                    <td><?php echo $comment->id; ?></td>
                                    <td><?php echo $comment->author; ?>
                                        <div class="action_links">
                                            <a href="delete_comment.php?id=<?php echo $comment->id; ?>"
                                               class="btn btn-danger btn-xs delete_link"><i class="fa fa-trash "> Delete</i></a>
                                        </div>
                                    </td>


                                    <td><?php echo $comment->body; ?></td>
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