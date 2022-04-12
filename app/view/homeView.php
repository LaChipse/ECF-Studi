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

            <h1>Formations Eco-It</h1>
            <div class="row mb-2 d-flex justify-content-end">
                <form class="col-4 d-flex form-group" action="../controller/home.php" method="post">
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Rechercher une formation" aria-label="Search">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>

            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'apprenant') {
            ?>

            <div class="row mb-5 d-flex">
                <div class="col d-flex justify-content-end">
                <form class="form-grou" style="margin-right: 10px" action="../controller/home.php" method="post">
                    <button type="submit" name="trieForm" value="progression" class="btn btn-secondary">Formation en cours</button>
                </form>
                <form class=" form-group" style="margin-right: 10px" action="../controller/home.php" method="post">
                    <button type="submit" name="trieForm" value="terminer" class="btn btn-secondary">Formation terminée</button>
                </form>
                <form class=" form-group" style="margin-right: 10px" action="../controller/home.php" method="post">
                    <button type="submit" name="trieForm" value="allForm" class="btn btn-secondary">Toutes les formations</button>
                </form>
            </div>
            </div>

            <?php
            }
            ?>

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
                                <?php if (!isset($_SESSION['user']) || $_SESSION['user'] == FALSE || strval($_SESSION['role']) != 'apprenant') { ?>
                                    <a class="mt-5 btn btn-secondary btn-lg" href='../controller/login.php' role="button">Suivre cette formation </a>
                                
                                <?php } elseif (isset($formTermApprenant) && is_array($formTermApprenant) && in_array($row['id'], $formTermApprenant)) 
                                    {
                                ?>
                                <div class="d-flex justify-content-evenly">
                                    <a class="mt-5 btn btn-success" href='#' role="button">Formation finie !</a>
                                    <a class="mt-5 btn btn-outline-success" href='../controller/oneFormation.php?id=<?php echo $row['id']?>' role="button">Revoir la formation</a>
                                </div>
                                <?php } elseif (isset($formSuiviApprenant) && in_array($row['id'], $formSuiviApprenant)) 
                                    {
                                ?>
                                    <a class="mt-5 btn btn-secondary btn-lg" href='../controller/oneFormation.php?id=<?php echo $row['id']?>' role="button">Continuer cette formation </a>

                                <?php } else { ?>
                                    <form class="mt-5" action="../controller/oneFormation.php?id=<?php echo $row['id']?>" method="post">
                                        <button type="submit" name="manageSuivi" value="suivre" class="btn btn-secondary btn-lg">Suivre cette formation</button>
                                    </form>

                                <?php
                                    } 
                                ?>
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

            echo "<div class='row row-cols-1 row-cols-md-3 g-4 mt-5'>"
                    . "<div class='pageLink'>" . $pagination_urls . "</div>"
                . "</div>";
        ?>
    </body>
</html>