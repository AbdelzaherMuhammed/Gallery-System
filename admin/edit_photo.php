<?php include("includes/header.php"); ?>
<?php if (!$session->signedIn()) {
    redirect('login.php');
} ?>


<?php

if (empty($_GET['id']))
{
    redirect('admin-photo.php');
} else {
    $photo = Photo::findById($_GET['id']);

    if (isset($_POST['update'])) {

        if ($photo)
        {
            $photo->title           = $_POST['title'];
            $photo->caption         = $_POST['caption'];
            $photo->alternate_text  = $_POST['alternate_text'];
            $photo->description     = $_POST['description'];
            $photo->save();
            $session->message('The photo has been updated successfully');
            redirect('photos.php');
        }

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
                    Photos Page
                    <small>Subheading</small>
                </h1>

                <form action="" method="post">
                    <div class="col-md-8">
                        <div class="form-group">
                            <lable for="caption">Title</lable>
                            <input type="text" name="title" class="form-control" value="<?php echo $photo->title; ?>">
                        </div>


                        <div class="form-group">
                            <a class="thumbnail" href="#"><img src="<?php echo $photo->picturePath(); ?>" alt=""></a>
                        </div>

                        <div class="form-group">
                            <lable for="caption">Caption</lable>
                            <input type="text" name="caption" class="form-control" value="<?php echo $photo->caption; ?>">
                        </div>
                        <div class="form-group">
                            <lable for="caption">Alternate text</lable>
                            <input type="text" name="alternate_text" class="form-control"
                                   value="<?php echo $photo->alternate_text; ?>">
                        </div>
                        <div class="form-group">
                            <lable for="caption">Description</lable>
                            <textarea class="form-control" name="description" id="mytextarea" cols="30" rows="10">
                            <?php echo $photo->description; ?>
                            </textarea>
                        </div>

                    </div>

                    <div class="col-md-4">
                        <div class="photo-info-box">
                            <div class="info-box-header">
                                <h4>Save <span id="toggle" class="glyphicon glyphicon-menu-up pull-right"></span></h4>
                            </div>
                            <div class="inside">
                                <div class="box-inner">
                                    <p class="text">
                                        <span class="glyphicon glyphicon-calendar"></span> Uploaded on: April 22, 2030 @
                                        5:26
                                    </p>
                                    <p class="text ">
                                        Photo Id: <span class="data photo_id_box"><?php echo $photo->id?></span>
                                    </p>
                                    <p class="text">
                                        Filename: <span class="data"><?php echo $photo->image?></span>
                                    </p>
                                    <p class="text">
                                        File Type: <span class="data"><?php echo $photo->type; ?></span>
                                    </p>
                                    <p class="text">
                                        File Size: <span class="data"> <?php echo $photo->size?></span>
                                    </p>
                                </div>
                                <div class="info-box-footer clearfix">
                                    <div class="info-box-delete pull-left">
                                        <a href="delete_photo.php?id=<?php echo $photo->id; ?>"
                                           class="btn btn-danger btn-lg ">Delete</a>
                                    </div>
                                    <div class="info-box-update pull-right ">
                                        <input type="submit" name="update" value="Update"
                                               class="btn btn-primary btn-lg ">
                                    </div>
                                </div>
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