<?php

// Conversion array postgresql en array php
function postgres_to_php_array($postgresArray){

    $postgresStr = trim($postgresArray,"{}");
    $elmts = explode(",",$postgresStr);
    return $elmts;
    
    }

// Conversion array php en array postgresql
function php_to_postgres_array($phpArray){
    
    return "{".join(",",$phpArray)."}";
    
    }


try { 
    // verifie si formulaire a été submit
    if(!empty($_POST)) {

        require_once('../model/Quiz.php');
        $quizModel = new QuizModel();

        $string = "mauvaise-rep";
        $mauvaiseRepArray = array();

        $quizModel->question = $_POST['question'];
        $quizModel->repvraie = $_POST['bonne-rep'];
        $quizModel->sectionid = $_POST['sectionid'];


        // verifie le $_POST de la qestion et si il comporte $string alors ajout dans array
        foreach ($_POST as $key => $value) {

            if(preg_match("/{$string}/i", $key) == 1) {

                array_push($mauvaiseRepArray, $value);
            }
        }

        $mauvaiseRepArray = php_to_postgres_array($mauvaiseRepArray);
        $quizModel->repfausse = $mauvaiseRepArray;
        $quizModel->create($quizModel);

        if(isset($_SESSION['error'])) unset($_SESSION['error']);

        header("Location: ../controller/manageFormation.php?id=$_GET[id]");
            
    } else {

        header("Location: ../view/addQuizView.php?id=$_GET[id]&formation=$_GET[formation]");
    }
    
} catch (PDOException $e) {
    die('echec : '.$e->getMessage());
}