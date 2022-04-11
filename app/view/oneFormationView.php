<!DOCTYPE html>
<html style="height: 100%">

    <?php
        require('../view/head.php');
    ?>
        
    <body style="height: 100%">

        <?php
        require('../view/header.php');
        ?>

        <div class="d-flex" style="height: calc(100% - 100px);">
            <div class="flex-shrink-0 p-3 bg-white" style="width: 15%; min-width: 200px; height: 100%">

                        

            <?php $section = $sectionModel -> findBy(array('formid' => $formation['id'])); ?>

                <span class="fs-5 fw-semibold border-bottom d-flex align-items-center pb-3 mb-3 link-dark"><?php echo $formation['titre'] ?></span>
                <ul class="list-unstyled ps-0">

                    <?php foreach($section as $secRow) { 
                        $cours = $coursModel -> findBy(array('sectionid' => $secRow['id']));
                    ?>

                    <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#<?php echo $secRow['titre'] ?>" aria-expanded="true">

                    <?php echo $secRow['titre'] ?>

                    </button>
                    <div class="collapse show" id="<?php echo $secRow['titre'] ?>">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                        <?php foreach($cours as $coursRow) { ?>
                                <li>
                                    <a href="../controller/oneFormation.php?id=<?php echo $formation['id'] . '&cours=' . $coursRow['id'] ?>"><?php echo $coursRow['titre'] ?></a>
                                </li>
                            
                        <?php } ?>

                        </ul>
                    </div>
                    </li>

                    <?php } ?>

                </ul>
            </div>
            
            <main class="news container my-4">            
            <?php if ( isset($oneCours)) { ?>

                <div class="row text-center">
                    <div class='col-6  mb-3 mt-4'>
                        <h3><?php echo $oneCours['titre'] ?></h3>
                    </div>
                </div>

                <div class="row">
                    <div class='col d-flex justify-content-center'>
                    <video controls width="75%">

                        <source src="<?php echo $oneCours['video'] ?>">
                    </video>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class='col-12 p-4'>
                        <p><?php echo $oneCours['description'] ?></p>
                    </div>
                    <div class='col d-flex justify-content-end'>
                        <?php 
                            if(isset($coursTermApprenant)) {
                                if(in_array($_GET['cours'], $coursTermApprenant)) {
                        ?>
                                <button class="btn btn-success">Lesson terminée</button>

                            <?php
                                } else {
                            ?>
                                <form action="../controller/oneFormation.php?id=<?php echo $_GET['id'] . '&cours=' . $_GET['cours'] ?>" method="post">
                                    <button type="submit" name="terminer" value="terminer" class="btn btn-outline-success">Lesson terminée</button>
                                </form>
                        <?php
                                }
                            } else { 
                        ?>
                        <form action="../controller/oneFormation.php?id=<?php echo $_GET['id'] . '&cours=' . $_GET['cours'] ?>" method="post">
                            <button type="submit" name="terminer" value="terminer" class="btn btn-outline-success">Lesson terminée</button>
                        </form>
                        <?php
                            }
                        ?>
                    </div>
                </div>

            <?php } else { ?>

                <div class="row">
                    <div class='col d-flex justify-content-center'>
                        <h1><?php echo $formation['titre'] ?></h1>
                    </div>
                </div>

            <?php } ?> 
            </main>
        </div>
        <script type="text/javascript" src="../asset/js/fade.js"> </script>
        <script type="text/javascript" src="../asset/js/sidebar.js"> </script> 
    </body>
</html>