<?php include("includes/header.php"); ?>
<?php if (!$session->signedIn()) {
    redirect('login.php');
} ?>


<?php

$user = new User();
if (isset($_POST['create'])) {


    if ($user) {
        $user->username = $_POST['username'];
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->password = $_POST['password'];
        $user->setFile($_FILES['image']);
        $user->saveInfo();
        $user->save();
        $session->message('The user has been added successfully');
        redirect('users.php');
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

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="col-md-6 col-md-offset-3">

                        <div class="form-group">
                            <label for="image">Choose Image</label>
                            <input type="file" name="image">
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="create" class="btn btn-primary">
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