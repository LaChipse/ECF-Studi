<!DOCTYPE html>
<html style="height: 100%">

    <?php
        require('../view/head.php');
    ?>
        
    <body style="height: 100%">

        <?php
        require('../view/header.php');
        ?>

        <div class="toggleNavLat">
        <button type="button" id="sidebarCollapse" class="btn">
            <i class="fas fa-align-left"></i>
        </button>
        </div>
        <div class="d-flex" style="height: calc(100% - 100px);">
            <div class="nav-lateral flex-shrink-0 p-3" style="width: 15%; min-width: 175px; height: 100%">

                        
            <!-- Affichage des sections de la formation -->
            <?php $section = $sectionModel -> findBy(array('formid' => $formation['id'])); ?>
                <div class="border-bottom pb-3 mb-3 d-flex justify-content-between">
                    <h3><?php echo $formation['titre'] ?></h3>
                    <button type="button" id="sidebarClose" class="btn btn-small">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <ul class="list-unstyled ps-0">

                    <?php foreach($section as $secRow) { 
                        $cours = $coursModel -> findBy(array('sectionid' => $secRow['id']));
                    ?>

                    <li class="mb-1">
                        <button class="mb-2 btn btn-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#<?php echo str_replace(' ', '_', $secRow['titre']) ?>" aria-expanded="true">

                        <?php echo $secRow['titre'] ?>

                        </button>
                        <div class="collapse show" id="<?php echo str_replace(' ', '_', $secRow['titre']) ?>">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-4 small">

                            <!-- Affichage des cours et quiz de la section -->
                            <?php foreach($cours as $coursRow) { ?>
                                    <li>
                                        <a href="../controller/oneFormation.php?id=<?php echo $formation['id'] . '&cours=' . $coursRow['id'] ?>"><?php echo $coursRow['titre'] ?></a>
                                    </li>
                            
                            <?php } ?>
                                    <li class="btn-toggle-nav">
                                        <a href="../controller/oneFormation.php?id=<?php echo $formation['id'] . '&sectionQuiz=' . $secRow['id'] ?>">QUIZZ</a>
                                    </li>
                            </ul>
                            
                        </div>

                    </li>

                    <?php } ?>

                </ul>
            </div>
            
            <main class="news container my-4">   
            <!-- Affichage du cours selctionné grâce au lien de la nav latérale -->         
            <?php if ( isset($oneCours)) { ?>

                <div class="row text-center">
                    <div class='col-6  mb-3 mt-4'>
                        <h2><?php echo $oneCours['titre'] ?></h2>
                    </div>
                </div>

                <div class="row">
                    <div class='col d-flex justify-content-center'>
                    <video controls class="videoLesson" width="75%">

                        <source src="<?php echo $oneCours['video'] ?>">
                    </video>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class='col-12 m-4'>
                        <p class="p-3"><?php echo $oneCours['description'] ?></p>
                    </div>
                    <div class='col d-flex justify-content-end'>
                        <!-- Affichage si le cours est dans les leçons terminées de l'apprenant sinon le rajoute au clique sur le bouton Leçon terminée --> 
                        <?php 
                            if(isset($apprCoursTermArray) && in_array($_GET['cours'], $apprCoursTermArray)) {
                        ?>
                                <button class="btn" style="background-color: #5AAA1D">Leçon terminée</button>

                            <?php
                                } else {
                            ?>
                                <form action="../controller/oneFormation.php?id=<?php echo $_GET['id'] . '&cours=' . $_GET['cours'] ?>" method="post">
                                    <button id="btn-finish" type="submit" name="manageSuivi" value="terminer" class="btn">Leçon terminée</button>
                                </form>
                        <?php
                                }
                        ?>
                    </div>
                </div>

            <?php } elseif ( isset($quiz)) {    

                if (isset($correction)) {
                    if($correction == TRUE) { ?>

                    <!-- Affichage du quiz et verification si reponses deja envoyées et si c'est la cas, retour de la correction --> 

                        <p class="mt-5 pt-5" style="color: #5AAA1D; font-size: 36px; text-align: center; font-weight: bold">Correct !</p>
                    <?php } elseif ($correction == FALSE) { 
                    ?>

                        <p class="mt-5 pt-5 mb-5" style="color: #CF2600; font-size: 36px; text-align: center; font-weight: bold">Faux ! Bonnes réponses : </p>

                    <div style="text-align: center;">

                    <?php
        
                    foreach ($numbQuestion as $key => $value) { ?>
                            <div class="mb-4 mt-4">
                                <p style="font-size: 24px; margin: 15px 30px; font-weight: bold">Question numero : <?php  echo $value ?></p>
                                <p style="font-size: 18px; margin: 5px 30px;">Votre reponse : <?php  echo "<span style='color: #CF2600'>" . $repfalse[$key] . "</span>" ?></p>
                                <p style="font-size: 18px; margin: 5px 30px;">Bonne reponse : <?php  echo "<span style='color: #5AAA1D'>" . $repTrue[$key] . "</span>" ?></p>
                            </div>

                    <?php } ?>
                    </div>
                    <?php
                            $repfalse = array();
                            $repTrue = array();
                            $numbQuestion = array();
                        }
                    } else { $numeroQuestion = 0?>

                        <div class="row text-center">
                            <div class='col mb-3 mt-4'>
                                <h3>QUIZ</h3>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class='col mb-3 mt-4 d-flex justify-content-center'>
                                <div class='col-sm-7 col-md-6 col-10'>
                                <form action="oneFormation.php?id=<?php echo $_GET['id'] . '&sectionQuiz=' . $_GET['sectionQuiz']?>" method="POST">
                        
                        <?php foreach ($quiz as $value) {

                            $numeroQuestion = $numeroQuestion + 1;

                            $reponseQuiz = array();
                            
                            $reponseQuizFausse = postgres_to_php_array($value['repfausse']);

                            foreach($reponseQuizFausse as $valueRep) {

                                array_push($reponseQuiz, $valueRep);

                            }

                            array_push($reponseQuiz, $value['repvraie']);
                            shuffle($reponseQuiz);

                        ?>
                        <div class="mb-5">
                            <?php echo "<h5 style='font-weight: bold; text-align: start'>" . $numeroQuestion . " - " . $value['question']. "</h5>";
                                foreach ($reponseQuiz as $valueRadio) {
                                ?>
                                <div class="form-check d-flex">
                                    <input class="form-check-input" type="radio" value="<?php echo $valueRadio ?>" name="<?php echo $value["id"] ?>" id="<?php echo $value["id"] ?>" required>
                                    <label class="form-check-label" style="margin-left: 10px" for="<?php echo $value["id"] ?>">
                                        <?php echo $valueRadio ?>
                                    </label>
                                </div>
                                <?php } ?>
                        </div>
                            <?php }?>
                            <button type="submit" class="btn">Corriger</button>
                        </form>
                        </div>
                    </div>
                </div>
            <?php
                                }
            } else { ?>

                <div class="row">
                    <div class='col d-flex justify-content-center'>
                        <h1><?php echo $formation['titre'] ?></h1>
                    </div>
                </div>

            <?php } ?> 
            </main>
        </div>
    <script type="text/javascript" src="../asset/js/toggleNavLat.js">
    </script>
    </body>
</html>