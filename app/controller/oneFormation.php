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

    require_once('../model/Apprenant.php');
    $apprenantModel = new ApprenantModel();
    $apprenants = $apprenantModel -> findBy(array('userid' => $_SESSION['id']));

    foreach ($apprenants as $apprs)
    {
        $apprenantId = $apprs['id'];
    }

    $apprenant = $apprenantModel -> find($apprenantId);
    if($apprenant['coursterm'] != NULL) {
        $coursTermApprenant = postgres_to_php_array($apprenant['coursterm']);
    }

    if(array_key_exists('cours', $_GET)) {
        $oneCours = $coursModel -> find($_GET['cours']);
    }

    try { 
        if(!empty($_POST)) {
    
            if(isset($_POST["terminer"])) {

                if($apprenant['coursterm'] == NULL) 
                {
                    $apprenantModel->coursterm = "{" . $_GET['cours'] . "}";

                } else 
                {   
                    $apprArray = postgres_to_php_array($apprenant['coursterm']);
                    array_push($apprArray, $_GET['cours']);
                    $apprArray = php_to_postgres_array($apprArray);

                    $apprenantModel->coursterm = $apprArray;
                }

                $apprenantModel->update($apprenantId, $apprenantModel);

            } elseif(isset($_POST["suivre"])) {
                
                if($apprenant['formsuivi'] == NULL) 
                {
                    $apprenantModel->formsuivi = "{" . $_GET['id'] . "}";

                } else 
                {   
                    $apprArray = postgres_to_php_array($apprenant['formsuivi']);
                    array_push($apprArray, $_GET['id']);
                    $apprArray = php_to_postgres_array($apprArray);

                    $apprenantModel->coursterm = $apprArray;
                }
                $apprenantModel->update($apprenantId, $apprenantModel);
            }

        }

    } catch (PDOException $e) {
        die('echec : '.$e->getMessage());
    }

    require('../view/oneFormationView.php');