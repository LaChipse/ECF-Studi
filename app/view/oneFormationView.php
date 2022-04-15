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

                        
            <!-- Affichage des sections de la formation -->
            <?php $section = $sectionModel -> findBy(array('formid' => $formation['id'])); ?>

                <span class="fs-5 fw-semibold border-bottom d-flex align-items-center pb-3 mb-3 link-dark"><?php echo $formation['titre'] ?></span>
                <ul class="list-unstyled ps-0">

                    <?php foreach($section as $secRow) { 
                        $cours = $coursModel -> findBy(array('sectionid' => $secRow['id']));
                    ?>

                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#<?php echo str_replace(' ', '_', $secRow['titre']) ?>" aria-expanded="true">

                        <?php echo $secRow['titre'] ?>

                        </button>
                        <div class="collapse show" id="<?php echo str_replace(' ', '_', $secRow['titre']) ?>">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

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
                        <!-- Affichage si le cours est dans les leçons terminées de l'apprenant sinon le rajoute au clique sur le bouton Leçon terminée --> 
                        <?php 
                            if(isset($apprCoursTermArray) && in_array($_GET['cours'], $apprCoursTermArray)) {
                        ?>
                                <button class="btn btn-success">Lesson terminée</button>

                            <?php
                                } else {
                            ?>
                                <form action="../controller/oneFormation.php?id=<?php echo $_GET['id'] . '&cours=' . $_GET['cours'] ?>" method="post">
                                    <button type="submit" name="manageSuivi" value="terminer" class="btn btn-outline-success">Leçon terminée</button>
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

                        <p style="color: green; font-size: 18px; margin-top: 15px">Correct !</p>
                    <?php } elseif ($correction == FALSE) { 
                    ?>

                        <p style="color: red; font-size: 18px; margin-top: 15px">Faux ! Bonnes réponses : </p>

                    <?php 
                    foreach ($numbQuestion as $key => $value) { ?>

                                <p style="color: black; font-size: 22px; margin-top: 15px">Quesion numero : <?php  echo $value ?></p>
                                <p style="color: black; font-size: 22px; margin-top: 15px">Votre reponse : <?php  echo $repfalse[$key] ?></p>
                                <p style="color: black; font-size: 22px; margin-top: 15px">Bonne reponse : <?php  echo $repTrue[$key] ?></p>

                    <?php } 
                            $repfalse = array();
                            $repTrue = array();
                            $numbQuestion = array();
                        }
                    } else { $numeroQuestion = 0?>

                        <div class="row text-center">
                            <div class='col-6  mb-3 mt-4'>
                                <h3>QUIZ</h3>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class='col-6  mb-3 mt-4'>
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

                            <?php echo $numeroQuestion . " - " . $value['question'];
                                foreach ($reponseQuiz as $valueRadio) {
                                ?>
                                    <input type="radio" required name="<?php echo $value["id"] ?>" value="<?php echo $valueRadio ?>"><?php echo $valueRadio ?><br>
                                <?php } 
                            }?>
                            <button type="submit" class="btn btn-primary">Corriger</button>
                        </form>
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
    </body>
</html>