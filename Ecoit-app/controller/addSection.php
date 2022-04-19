<?php

try { 
    // verifie si formulaire a été submit
    if(!empty($_POST)) {

    require_once('../model/Section.php');

        foreach($_POST as $valeur) {
            $sectionModel = new SectionModel();

            $sectionModel->titre = $valeur;
            $sectionModel->formid = $_GET['formation'];

            $sectionModel->create($sectionModel);
        }

        header("Location: ../controller/manageFormation.php?id=$_GET[id]");
            
    } else {

        header("Location: ../view/addSectionView.php?id=$_GET[id]&formation=$_GET[formation]");
    }
    
} catch (PDOException $e) {
    die('echec : '.$e->getMessage());
}