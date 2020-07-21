<?php include("includes/header.php"); ?>

<?php

$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

$itemsPerPAge = 4;

$itemTotalCount = Photo::countAll();

//$photos = Photo::findAll();

$paginate = new Paginate($page, $itemsPerPAge, $itemTotalCount);

$sql = "SELECT * FROM photos ";
$sql .= "LIMIT {$itemsPerPAge} ";
$sql .= "OFFSET {$paginate->offset()}";

$photos = Photo::FindByQuery($sql);


?>
<div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-12">
        <div class="thumbnails row">
            <?php foreach ($photos

                           as $photo): ?>

                <div class="col-xs-6 col-md-3">

                    <a class="thumbnail" href="photo.php?id=<?php echo $photo->id ?>">
                        <img class="img-responsive home_page_photo" src="admin/<?php echo $photo->picturePath(); ?>"
                             alt="">
                    </a>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Blog Sidebar Widgets Column -->
    <!--            <div class="col-md-4">-->
    <!--                 --><?php //include("includes/sidebar.php"); ?>
</div>

<div class="row">
    <ul class="pagination">

        <?php
        if ($paginate->pageTotal() > 1) {
            if ($paginate->hasNext()) {
                echo "<li class='next'><a href='index.php?page={$paginate->next()}'>Next</a></li>";
            }

            for ($i=1;$i<=$paginate->pageTotal();$i++)
            {
                if ($i == $paginate->currentPage)
                {
                    echo "<li class='active'><a href='index.php?page={$i}'>{$i}</a></li>";
                } else {
                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                }

            }





            if ($paginate->hasPrevious()) {
                echo "<li class='previous'><a href='index.php?page={$paginate->previous()}'>Previous</a></li>";
            }

        }
        ?>


    </ul>
</div>


<?php include("includes/footer.php"); ?>
