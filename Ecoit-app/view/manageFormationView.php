<!DOCTYPE html>
<html style="height: 100%">

    <?php
        require('../view/head.php');
    ?>
        
    <body style="height: 100%">

        <?php
        require('../view/header.php');
        ?>
        
        <main class="news container my-4">

            <h1>Vos formations :</h1>

            <div class="row mt-5">
                <div>
                    <a class="btn" href="../controller/addFormation.php" role="button">Ajouter une formation</a>
                </div>
            </div>
            

            <div class="row mt-5">
                <!-- Affichage des sections de la formation -->

            <?php
                foreach($formation as $row) {

                    $section = $sectionModel -> findBy(array('formid' => $row['id']));
            ?>

                <div class="col d-flex justify-content-center mb-5">

                    <div style="width: 34rem;">
                        <div class="card"">
                            <img class="card-img-top rounded" style="height: 350px" src="<?php echo $row['image'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['titre'] ?></h5>
                                <h6 class="card-title" style="font-weight: bold">Cours :</h6>
                                <ul>

                                <?php 
                                foreach($section as $secRow) { 
                                    
                                    $cours = $coursModel -> findBy(array('sectionid' => $secRow['id']));
                                ?>

                                    
                                    
                                    <li style="list-style: none"><?php echo $secRow['titre'] ?></li>
                                    <ul>

                                    <?php foreach($cours as $coursRow) { ?>

                                        <li><?php echo $coursRow['titre'] ?></li>

                                    <?php 
                                    } ?>

                                    </ul>

                                <?php
                                } ?>
                                </ul>
                                <button class="btn btnUpdate my-3">Modifier cette formation</button>
                                <!-- Controle des actions de management de l'instructeur sur sa formation -->
                                <div style="display: none; justify-content: space-evenly;" class="btnManage">
                                    <a href="../controller/addSection.php?id=<?php echo $_GET['id']?>&formation=<?php echo $row['id']?>" class="btn">Ajouter une section</a>
                                <?php if(count($section) > 0) { ?>
                                    <a href="../controller/addLesson.php?id=<?php echo $_GET['id']?>&formation=<?php echo $row['id']?>" class="btn">Ajouter une leçon</a>
                                <?php } ?>
                                <?php if(count($section) > 0) { ?>
                                    <a href="../controller/addQuiz.php?id=<?php echo $_GET['id']?>&formation=<?php echo $row['id']?>" class="btn">Ajouter un quiz</a>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 

            <?php
                }
            ?>
            </div>

        </main>
        <script type="text/javascript" src="../asset/js/fade.js"> 
        </script> 
    </body>
</html>