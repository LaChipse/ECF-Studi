<!DOCTYPE html>
<html style="height: 100%">

    <?php
        require('../view/head.php');
    ?>
        
    <body style="height: 100vh">
        
        <?php
            require('../view/header.php');
        ?>
        
        <div class="news container my-4">

            <h1>Formation Eco-It</h1>
            <div class="row row-cols-1 row-cols-md-3 g-4 mt-5">

            </div>

            <div class="row mt-5">

            <?php
                foreach($formations as $row) {

            ?>
                <div class="col d-flex justify-content-center mb-5">
                    <div style="width: 34rem;">
                        <div class="card h-100">
                            <img class="card-img-top rounded" style="height: 350px" src="<?php echo $row['image'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['titre'] ?></h5>
                                <a class="btn btn-secondary btn-lg" <?php if (!isset($_SESSION['user']) || $_SESSION['user'] == FALSE || strval($_SESSION['user']) != 'apprenant') { ?>
                                    href='../controller/login.php' <?php } else { ?> href='../controller/oneFormation.php' <?php } ?> role="button">Suivre cette formation</a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
                }
            ?>
            </div>

        </div>

        <?php
            $pagination_urls = '';
            $pagination_urls .= "<a href='../controller/home.php?page=1'>First </a>";

            if ($page != 1) {
                $pagination_urls .= "&nbsp;&nbsp;<a href='../controller/home.php?page=". ($page - 1) . "'>Previous</a>";
            } else {
                $pagination_urls .= "&nbsp;&nbsp;<a>Previous</a>";
            }

            if ($page != $total_pages) {
                $pagination_urls .= "&nbsp;&nbsp;<a href='../controller/home.php?page=". ($page + 1) . "'>Next</a>";
            } else {
                $pagination_urls .= "&nbsp;&nbsp;<a>Next</a>";
            }

            $pagination_urls .= "&nbsp;&nbsp;<a href='../controller/home.php?page=" . $total_pages ."'>Last</a>";

            echo "<div class='row row-cols-1 row-cols-md-3 g-4 mt-5'>"
                    . "<div class='pageLink'>" . $pagination_urls . "</div>"
                . "</div>";
        ?>
    </body>
</html>