<?php

session_start();

function postgres_to_php_array($postgresArray){

    $postgresStr = trim($postgresArray,"{}");
    $elmts = explode(",",$postgresStr);
    return $elmts;
    
    }
    
function php_to_postgres_array( $phpArray){
    
    return "{".join(",",$phpArray)."}";
    
    }



    require_once('../model/Formation.php');
    $formationModel = new FormationModel();
    $formation = $formationModel -> find($_GET['id']);

    require_once('../model/Section.php');
    $sectionModel = new SectionModel();

    require_once('../model/Cours.php');
    $coursModel = new CoursModel();
    $coursLesson = $coursModel -> findBy(array('formid' => $_GET['id']));
    $coursLessonId = array();

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

    if(array_key_exists('cours', $_GET)) {
        $oneCours = $coursModel -> find($_GET['cours']);
    }

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
            }

        }

    } catch (PDOException $e) {
        die('echec : '.$e->getMessage());
    }

    require_once('../view/oneFormationView.php');