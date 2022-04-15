<?php

session_start();

// Conversion array postgresql en array php
function postgres_to_php_array($postgresArray){

    $postgresStr = trim($postgresArray,"{}");
    $elmts = explode(",",$postgresStr);
    return $elmts;
    
    }

function php_to_postgres_array( $phpArray){
    
    return "{".join(",",$phpArray)."}";
    
    }

// Recuperation des données suivant id de la formation et de l'apprenant
    require_once('../model/Formation.php');
    $formationModel = new FormationModel();
    $formation = $formationModel -> find($_GET['id']);

    require_once('../model/Section.php');
    $sectionModel = new SectionModel();

    require_once('../model/Cours.php');
    $coursModel = new CoursModel();
    $coursLesson = $coursModel -> findBy(array('formid' => $_GET['id']));
    $coursLessonId = array();

    require_once('../model/Quiz.php');
    $quizModel = new QuizModel();

    foreach ($coursLesson as $value) {

        array_push($coursLessonId, strval($value['id']));
    }

    require_once('../model/Apprenant.php');
    $apprenantModel = new ApprenantModel();
    $apprenants = $apprenantModel -> findBy(array('userid' => $_SESSION['id']));

    foreach ($apprenants as $apprs)
    {
        $apprenantId = $apprs['id'];
    }

    $apprenant = $apprenantModel -> find($apprenantId);

    $apprCoursTermArray = postgres_to_php_array($apprenant['coursterm']);
    $apprFormSuiviArray = postgres_to_php_array($apprenant['formsuivi']);
    $apprFormTermArray = postgres_to_php_array($apprenant['formterm']);

    // Recuperation cours ou quiz selon clique du bouton dans nav latérale
    if(array_key_exists('cours', $_GET)) {
        $oneCours = $coursModel -> find($_GET['cours']);
    }

    if(array_key_exists('sectionQuiz', $_GET)) {
        $quiz = $quizModel -> findBy(array('sectionid' => $_GET['sectionQuiz']));
    }

    // Lors du clique suir bouton terminer d'une lecon, ajout de l'id de cette leçon dans les leçons terminées de l'apprenant puis verification si toutes les leçons de la formations sont terminées.
    // Si oui, alors formations ajoutée dans formation terminée de l'apprenant
    try { 
        if(!empty($_POST)) {
    
            if(isset($_POST["manageSuivi"])) {

                if($_POST["manageSuivi"] == 'terminer') {

                    if(!in_array(intval($_GET['cours']), $apprCoursTermArray)){

                        if(($apprenant['coursterm'] == NULL) || ($apprenant['coursterm'] == '{}')) 
                        {
                            $apprenantModel->coursterm = "{" . $_GET['cours'] . "}";

                        } else 
                        {   
                            array_push($apprCoursTermArray, $_GET['cours']);
                            $apprCoursTermArray = php_to_postgres_array($apprCoursTermArray);
                            $apprenantModel->coursterm = $apprCoursTermArray;

                            $apprCoursTermArray = postgres_to_php_array($apprCoursTermArray);
                        }

                        $apprenantModel->update($apprenantId, $apprenantModel);
                    }

                    if (array_intersect($coursLessonId, $apprCoursTermArray) == $coursLessonId) {

                        $apprFormSuiviArray = array_diff($apprFormSuiviArray, array($_GET['id']));
                        $apprFormSuiviArray = php_to_postgres_array($apprFormSuiviArray);

                        $apprenantModel->formsuivi = $apprFormSuiviArray;

                        if(!in_array(intval($_GET['id']), $apprFormTermArray)){

                            if(($apprenant['formterm'] == NULL) || ($apprenant['formterm'] == '{}')) 
                            {
                                $apprenantModel->formterm = "{" . $_GET['id'] . "}";
    
                            } else 
                            {   
                                array_push($apprFormTermArray, $_GET['id']);
                                $apprFormTermArray = php_to_postgres_array($apprFormTermArray);
                                $apprenantModel->formterm = $apprFormTermArray;
    
                                $apprFormTermArray = postgres_to_php_array($apprFormTermArray);
                            }
    
                            $apprenantModel->update($apprenantId, $apprenantModel);
                        }

                    }

                } elseif($_POST["manageSuivi"] == 'suivre') {

                    if(!in_array(intval($_GET['id']), $apprFormSuiviArray)){
                
                        if(($apprenant['formsuivi'] == NULL)  || ($apprenant['formsuivi'] == '{}')) 
                        {
                            $apprenantModel->formsuivi = "{" . $_GET['id'] . "}";

                        } else
                        {   

                            array_push($apprFormSuiviArray, $_GET['id']);
                            $apprFormSuiviArray = php_to_postgres_array($apprFormSuiviArray);

                            $apprenantModel->formsuivi = $apprFormSuiviArray;

                            $apprFormSuiviArray = postgres_to_php_array($apprenant['formsuivi']);
                        }
                        $apprenantModel->update($apprenantId, $apprenantModel);
                    }
                }
            }else {

                // Verification des réponses du quiz données par l'apprenant
                $correction = TRUE;
                $countRep = 0;
                $repfalse = array();
                $repTrue = array();
                $numbQuestion = array();

                foreach ($_POST as $key => $valueRepGive) {

                    $countRep = $countRep + 1;

                    $oneQuiz = $quizModel -> find($key);
                    

                    if(strval($oneQuiz['repvraie']) != strval($valueRepGive)) {
                        $correction = FALSE;
                        array_push($repfalse, $valueRepGive);
                        array_push($repTrue, strval($oneQuiz['repvraie']));
                        array_push($numbQuestion, $countRep);

                    }
                }
            }

        }

    } catch (PDOException $e) {
        die('echec : '.$e->getMessage());
    }

    require_once('../view/oneFormationView.php');