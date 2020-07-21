<?php include("includes/header.php"); ?>
<?php include 'includes/photo_library_modal.php'?>
<?php if (!$session->signedIn()) {
    redirect('login.php');
} ?>


<?php

$user = User::findById($_GET['id']);
if (empty($user)) {
    redirect('users.php');

}

$user = User::findById($_GET['id']);
if (isset($_POST['update'])) {

    if ($user) {
        $user->username = $_POST['username'];
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->password = $_POST['password'];

        if (empty($_FILES['image'])) {
            $user->save();
            redirect("users.php");
            $session->message('The user has been updated successfully');
        } else {
            $user->setFile($_FILES['image']);
            $user->saveInfo();
            $user->save();
            $session->message('The user has been updated successfully');

//            redirect("edit_user.php?id={$user->id}");
            redirect("users.php");

        }

//        $user->save();
    }
}


?>


    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">


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
                    users Page
                    <small>Subheading</small>
                </h1>

                <div class="col-md-6 user_image_box">
                    <a href="#" data-toggle="modal" data-target="#photo-modal"><img class="img-responsive" src="<?php echo $user->imagePathPlaceholder(); ?>" alt=""></a>
                </div>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="image">Choose Image</label>
                            <input type="file" name="image">
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control"
                                   value="<?php echo $user->username; ?>">
                        </div>

                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control"
                                   value="<?php echo $user->first_name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control"
                                   value="<?php echo $user->last_name; ?>">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control"
                                   value="<?php echo $user->password ?>">
                        </div>

                        <div class="info-box-footer clearfix">
                            <div class="info-box-delete pull-left">
                                <a id="user-id"  href="delete_user.php?id=<?php echo $user->id; ?>"
                                   class="btn btn-danger btn-lg ">Delete</a>
                            </div>
                            <div class="info-box-update pull-right ">
                                <input type="submit" name="update" value="Update"
                                       class="btn btn-primary btn-lg ">
                            </div>
                        </div>


                    </div>

                </form>

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>